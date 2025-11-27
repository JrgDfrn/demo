<?php

namespace App\Filament\Resources\BookingResource\Widgets;

use App\Models\Booking;
use Filament\Widgets\Widget;

class BookingCalendarWidget extends Widget
{
    protected string $view = 'filament.resources.booking-resource.widgets.booking-calendar-widget';

    protected int | string | array $columnSpan = 'full';

    public ?array $events = [];

    protected ?string $heading = 'Calendario de Reservas';

    protected ?string $pollingInterval = null;

    protected static bool $isLazy = false;

    protected static bool $isDiscovered = true;

    public function mount(): void
    {
        // Cargar eventos de forma estática
        $this->loadEvents();
    }

    public function loadEvents(): void
    {
        $this->events = Booking::query()
            ->get()
            ->map(function ($booking) {
                $color = match ($booking->status) {
                    'confirmed' => '#10b981', // green
                    'pending' => '#f59e0b', // yellow/amber
                    'cancelled' => '#ef4444', // red
                    default => '#6b7280', // gray
                };

                return [
                    'id' => $booking->id,
                    'title' => $booking->title,
                    'start' => $booking->start->toIso8601String(),
                    'end' => $booking->end?->toIso8601String(),
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'customer_name' => $booking->customer_name,
                        'customer_email' => $booking->customer_email,
                        'customer_phone' => $booking->customer_phone,
                        'status' => $booking->status,
                        'description' => $booking->description,
                    ],
                ];
            })
            ->toArray();
    }

    public function updatedEvents(): void
    {
        // Este método se ejecutará cuando los eventos cambien
        $this->loadEvents();
    }

    public static function canView(): bool
    {
        return true;
    }
}

