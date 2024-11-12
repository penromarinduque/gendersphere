<x-app-layout>
    <x-slot name="title">
        {{ __('Frontline Services Data') }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Frontline Services Data') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-9">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <router-view /> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
