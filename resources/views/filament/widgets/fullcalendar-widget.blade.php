@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css' rel='stylesheet' />
@endpush

<x-filament-widgets::widget>
    <x-filament::section>
        <div 
            x-data="fullCalendarWidget()"
            wire:ignore
            class="w-full"
        >
            <div x-ref="calendar" class="p-4"></div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
function fullCalendarWidget() {
    return {
        calendar: null,
        events: @js($this->events),
        init() {
            this.$nextTick(() => {
                if (typeof FullCalendar !== 'undefined') {
                    this.calendar = new FullCalendar.Calendar(this.$refs.calendar, {
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
                    });
                    this.calendar.render();
                } else {
                    console.error('FullCalendar no está disponible');
                }
            });
        }
    }
}
</script>
@endpush

