@php use Illuminate\Support\Str; 
@endphp

<x-app-layout>
    <x-slot name="title">
        {{ __('Report / Training') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report / Training Report') }}
        </h2>
    </x-slot>

    <!-- <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">

                <div class="mb-4">
                    <h3 class="text-lg font-bold">Training Report</h3>
                </div>

                @if($trainings->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm border border-gray-300 divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Title</th>
                                    <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Date</th>
                                    <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Duration</th>
                                    <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Nature</th>
                                    <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Type</th>
                                    <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">GAD Related</th>
                                    <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Sponsor/Facilitator</th>
                                    <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Attendees</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($trainings as $instance)
                                    <tr class="border-b border-gray-300">
                                        <td class="px-4 py-2 border-r border-gray-300">
                                            {{ isset($instance->training->training_title) ? Str::ucfirst($instance->training->training_title) : '-' }}
                                        </td>
                                        <td class="px-4 py-2 border-r border-gray-300">
                                            {{ \Carbon\Carbon::parse($instance->training_start)->format('M d, Y') }} -
                                            {{ \Carbon\Carbon::parse($instance->training_end)->format('M d, Y') }}
                                        </td>
                                        <td class="px-4 py-2 border-r border-gray-300">{{ (int) $instance->duration_hours }} hrs</td>
                                        <td class="px-4 py-2 border-r border-gray-300">
                                            {{ isset($instance->training->training_nature) ? Str::ucfirst($instance->training->training_nature) : '-' }}
                                        </td>
                                        <td class="px-4 py-2 border-r border-gray-300">
                                            {{ isset($instance->training->learning_description_type) ? Str::ucfirst($instance->training->learning_description_type) : '-' }}
                                        </td>
                                        <td class="px-4 py-2 border-r border-gray-300">
                                            @if($instance->training->is_gad_related)
                                                <span>Yes</span>
                                            @else
                                                <span>No</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border-r border-gray-300">
                                            {{ Str::ucfirst($instance->sponsor_facilitator) }}
                                        </td>
                                        <td class="px-4 py-2">{{ $instance->attendees->count() }}</td>
                                    </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $trainings->withQueryString()->links('pagination::tailwind') }}
                    </div>

                @else
                    <p class="text-gray-600">No trainings found for the selected criteria.</p>
                @endif

            </div>
        </div>
    </div> -->
    <div class="py-6">
        <app />
    </div>
</x-app-layout>
