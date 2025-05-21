<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Doel</x-slot>
        <x-slot name="description">A brief overview of this page.</x-slot>
        <p>Welcome to my static page with sections!</p>
    </x-filament::section>

    <x-filament::section icon="heroicon-o-information-circle" icon-color="info">
        <x-slot name="heading">Technische details</x-slot>
        <x-slot name="description">Important information you need to know.</x-slot>
        <p>This section contains detailed textual information.</p>
    </x-filament::section>

    <x-filament::section collapsible collapsed>
        <x-slot name="heading">Additional Resources</x-slot>
        <div class="space-y-4">
            <div class="p-4">
                <h2 class="text-xl font-semibold">Laravel Version</h2>
                <p class="text-gray-700">{{ $laravelVersion }}</p>
            </div>
            <div class="p-4">
                <h2 class="text-xl font-semibold">Filament Version</h2>
                <p class="text-gray-700">{{ $filamentVersion }}</p>
            </div>

            <div class="p-4">
                <h2 class="text-xl font-semibold">PHP Version</h2>
                <p class="text-gray-700">{{ $phpVersion }}</p>
            </div>

            <div class="p-4">
                <h2 class="text-xl font-semibold">MySql Version</h2>
                <p class="text-gray-700">{{ $mysqlVersion }}</p>
            </div>

        </div>


    </x-filament::section>
</x-filament-panels::page>
