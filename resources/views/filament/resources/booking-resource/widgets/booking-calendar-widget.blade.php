@once
    <style>
        .fc {
            font-family: inherit;
        }
        .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .fc-button {
            background-color: rgb(59 130 246);
            border-color: rgb(59 130 246);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .fc-button:hover {
            background-color: rgb(37 99 235);
            border-color: rgb(37 99 235);
        }
        .fc-button-active {
            background-color: rgb(29 78 216);
            border-color: rgb(29 78 216);
        }
        .fc-event {
            border-radius: 0.25rem;
            padding: 2px 4px;
            cursor: pointer;
        }
        .fc-daygrid-event {
            white-space: normal;
        }
        .booking-calendar-container {
            min-height: 600px;
        }
    </style>
@endonce

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="w-full booking-calendar-container">
            <div 
                x-data="bookingCalendarData()"
                x-init="setTimeout(() => init(), 800)"
                wire:key="booking-calendar-static"
                wire:ignore
            >
                <div x-ref="calendar" class="p-4"></div>
                <div x-show="!initialized" class="p-4 text-center text-gray-500">
                    Cargando calendario...
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
(function() {
    if (typeof window.bookingCalendarData === 'undefined') {
        window.bookingCalendarData = function() {
            return {
                calendar: null,
                events: @json($this->events ?? []),
                initialized: false,
                init() {
                    // Esperar a que todo esté listo
                    this.$nextTick(() => {
                        setTimeout(() => {
                            this.loadFullCalendar();
                        }, 800);
                    });
                },
                loadFullCalendar() {
                    if (typeof FullCalendar !== 'undefined') {
                        this.initCalendar();
                    } else {
                        let attempts = 0;
                        const maxAttempts = 50;
                        const checkInterval = setInterval(() => {
                            attempts++;
                            if (typeof FullCalendar !== 'undefined') {
                                clearInterval(checkInterval);
                                this.initCalendar();
                            } else if (attempts >= maxAttempts) {
                                clearInterval(checkInterval);
                                console.error('FullCalendar no se pudo cargar');
                            }
                        }, 100);
                    }
                },
                initCalendar() {
                    if (this.initialized) return;
                    
                    const calendarEl = this.$refs.calendar;
                    if (!calendarEl) {
                        setTimeout(() => this.initCalendar(), 100);
                        return;
                    }
                    
                    try {
                        this.calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            events: this.events,
                            editable: true,
                            selectable: true,
                            selectMirror: true,
                            dayMaxEvents: true,
                            weekends: true,
                            locale: 'es',
                            firstDay: 1,
                            eventClick: (info) => {
                                console.log('Event clicked:', info.event.extendedProps);
                            },
                            dateClick: (info) => {
                                console.log('Date clicked:', info.dateStr);
                            },
                            eventDidMount: (info) => {
                                const props = info.event.extendedProps;
                                const tooltip = `${info.event.title}\nCliente: ${props.customer_name || 'N/A'}\nTel: ${props.customer_phone || 'N/A'}`;
                                info.el.setAttribute('title', tooltip);
                            }
                        });
                        
                        this.calendar.render();
                        this.initialized = true;
                    } catch (error) {
                        console.error('Error al inicializar FullCalendar:', error);
                    }
                }
            };
        };
    }
})();
</script>
@endpush

