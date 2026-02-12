<x-app-layout>
    <x-slot name="title">
        {{ __('Report - Employees') }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report / Employees') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <app />
    </div>
</x-app-layout>

