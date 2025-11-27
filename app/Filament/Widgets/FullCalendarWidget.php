<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class FullCalendarWidget extends Widget
{
    protected string $view = 'filament.widgets.fullcalendar-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public ?array $events = [];

    protected ?string $heading = 'Calendario';

    public function mount(): void
    {
        // Aquí puedes cargar eventos desde tu base de datos
        // Por ejemplo:
        // $this->events = Order::query()
        //     ->select('created_at as start', 'number as title')
        //     ->get()
        //     ->map(fn ($order) => [
        //         'title' => $order->title,
        //         'start' => $order->start->toIso8601String(),
        //     ])
        //     ->toArray();
        
        // Ejemplo de eventos estáticos:
        $this->events = [
            [
                'title' => 'Evento 1',
                'start' => now()->toIso8601String(),
            ],
            [
                'title' => 'Evento 2',
                'start' => now()->addDay()->toIso8601String(),
            ],
        ];
    }

    public static function canView(): bool
    {
        return true;
    }
}

