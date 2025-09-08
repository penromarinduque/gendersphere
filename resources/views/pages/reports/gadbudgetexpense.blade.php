@php
    $start_year = request('start_year', date('Y'));
    $end_year = request('end_year', date('Y'));
@endphp

<x-app-layout>
    <x-slot name="title">
        {{ __('Report - GAD Budget and Expenses') }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report / GAD Budget and Expenses') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <div class="text-gray-900">
                    <h5 class="text-lg font-semibold mb-4">
                        GAD plan budgets and expenses report
                    </h5>
                </div>

                <form action="" method="GET">
                    <div class="flex justify-end gap-1 mb-3">
                        <div class="">
                            <label for="start_year" class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Start Year</label>
                            <select name="start_year" id="start_year" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 min-w-full">
                                @foreach (collect($years) as $year)
                                    <option value="{{ $year["year"] }}" @if($year["year"] == $start_year) selected @endif>{{ $year["year"] }}</option>    
                                @endforeach
                            </select>   
                        </div>
                        <div class="">
                            <label for="end_year" class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">End Year</label>
                            <select name="end_year" id="end_year" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5  min-w-full">
                                @foreach (collect($years) as $year)
                                    <option value="{{ $year["year"] }}" @if($year["year"] == $end_year) selected @endif>{{ $year["year"] }}</option>    
                                @endforeach
                            </select>   
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button> 
                        </div>
                    </div>
                </form>
                <table class="table-auto min-w-full w-full border-collapse border !border-slate-900!important divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th rowspan="2" width="250px" class="border border-slate-900 px-2 py-2 bg-gray-50"></th>
                            @for ($i = $start_year; $i <= $end_year; $i++)
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50" colspan="2">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">{{ $i }}</span>
                                </th>
                            @endfor
                        </tr>
                        <tr>
                            @for ($i = $start_year; $i <= $end_year; $i++)
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50" >
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Budget</span>
                                </th>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50" >
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actual Cost</span>
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="border border-slate-900 text-left"><span class="text-sm font-medium leading-4 tracking-wider text-gray-700 uppercase">Client Focus</span></th>
                            @for ($i = $start_year; $i <= $end_year; $i++)
                                <td class="border border-slate-900 px-2 py-2 ">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Php {{ number_format($clientFocus->where('gad_activity.plan_budget.year', $i)->sum('gad_budget'), 2) }}</span>
                                </td>
                                <td class="border border-slate-900 px-2 py-2 ">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Php {{ number_format($clientFocus->where('gad_activity.plan_budget.year', $i)->sum('actual'), 2) }}</span>
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <th class="border border-slate-900 text-left"><span class="text-sm font-medium leading-4 tracking-wider text-gray-700 uppercase">Organizational Focus</span></th>
                            @for ($i = $start_year; $i <= $end_year; $i++)
                                <td class="border border-slate-900 px-2 py-2 ">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Php {{ number_format($organizationalFocus->where('gad_activity.plan_budget.year', $i)->sum('gad_budget'), 2) }}</span>
                                </td>
                                <td class="border border-slate-900 px-2 py-2 ">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Php {{ number_format($organizationalFocus->where('gad_activity.plan_budget.year', $i)->sum('actual'), 2) }}</span>
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <th class="border border-slate-900 text-left"><span class="text-sm font-medium leading-4 tracking-wider  text-gray-700 uppercase ">Attributed Programs</span></th>
                            @for ($i = $start_year; $i <= $end_year; $i++)
                                <td class="border border-slate-900 px-2 py-2 " colspan="2">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Php {{ number_format($attributedProgramFocus->where('year', $i)->sum('attr_program_budget'), 2) }}</span>
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
