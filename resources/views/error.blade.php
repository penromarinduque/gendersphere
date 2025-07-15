<x-app-layout>
    <x-slot name="title">
        {{ __('Error') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <app />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
