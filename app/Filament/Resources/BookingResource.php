<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages\ListBookings;
use App\Filament\Resources\BookingResource\Pages\CreateBooking;
use App\Filament\Resources\BookingResource\Pages\EditBooking;
use App\Filament\Resources\BookingResource\Tables\BookingsTable;
use App\Models\Booking;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $slug = 'bookings';

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Reservas';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(3),
                        DateTimePicker::make('start')
                            ->label('Fecha y hora de inicio')
                            ->required()
                            ->native(false),
                        DateTimePicker::make('end')
                            ->label('Fecha y hora de fin')
                            ->native(false),
                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'pending' => 'Pendiente',
                                'confirmed' => 'Confirmada',
                                'cancelled' => 'Cancelada',
                            ])
                            ->default('pending')
                            ->required(),
                    ])
                    ->columns(2),
                Section::make('Información del Cliente')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Nombre del cliente')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('customer_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('customer_phone')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(255),
                    ])
                    ->columns(3),
                Section::make('Notas')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notas adicionales')
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return BookingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }
}

