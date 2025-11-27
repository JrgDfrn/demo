<?php

namespace App\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $table = 'bookings';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'notes',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'success',
            'pending' => 'warning',
            'cancelled' => 'danger',
            default => 'gray',
        };
    }
}

