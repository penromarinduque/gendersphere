<x-app-layout>
    <x-slot name="title">
        {{ __('Report - Annual GAD Plan and Budget '.$year) }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report / Annual GAD Plan and Budget') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <div class="flex w-32 mx-auto float-end">
                            <label class="">YEAR&nbsp;</label>
                            <select onchange="window.location.href='?year='+this.value" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">-YEAR-</option>
                                @for($i=date('Y'); $i >= 2018; $i--)
                                    <option value="{{$i}}" {{($i==$year) ? 'selected' : ''}}>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('ANNUAL GENDER AND DEVELOPMENT (GAD) PLAN AND BUDGET '.$year) }}
                        </h2>
                    </header>
                    <div class="min-w-full w-full py-6 overflow-x-scroll">
                        <table class="table-auto min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender Issue/GAD Mandate</span>
                                    </th>
                                    <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Cause of Gender Issue</span>
                                    </th>
                                    <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Result Statement/ GAD Objective</span>
                                    </th>
                                    <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Relevant Organization MFO/PAP or PPA</span>
                                    </th>
                                    <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Activity</span>
                                    </th>
                                    <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Performance Indicators /Targets</span>
                                    </th>
                                    <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actual Results/ Outputs and Outcomes </span>
                                    </th>
                                    <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Budget</span>
                                    </th>
                                    <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actual Cost / Cost Expenditure</span>
                                    </th>
                                    <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Remarks</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="10" class="px-2 py-2 text-md bg-orange-100">
                                        CLIENT-FOCUSED ACTIVITIES
                                    </td>
                                </tr>
                                @foreach($goals as $goal)
                                    @if($goal->focus=='client')
                                        <tr>
                                            <td colspan="10" class="px-2 py-2 text-md bg-blue-100">
                                                GAD Goal {{$goal->goal_no}}: {{$goal->gad_goal}}
                                            </td>
                                        </tr>
                                    @endif

                                    @forelse($planbudgets as $planbudget)
                                    
                                        @if($goal->focus=='client' && $goal->goal_id == $planbudget->goal_id && $planbudget->focus=='client')
                                            @php
                                                $ga_count_c = count($planbudget->gad_activities);
                                                $activities = [];
                                                $budget = 0;
                                                $actual_cost = 0;
                                            @endphp
                                            @foreach($planbudget->gad_activities as $key => $gad_act)
                                                @php
                                                    $activities = [...$activities, ...$gad_act->activity_details];
                                                @endphp
                                                @foreach ($activities as $key => $act)
                                                    <tr class="align-text-top">
                                                        <td @class([
                                                            'border',
                                                            'border-b-0' => $key == 0,
                                                            'border-y-0' => $key != 0,
                                                            'border-slate-300',
                                                            'px-2', 'py-2',
                                                            'text-sm', 'leading-5',
                                                            'text-gray-900',
                                                            'whitespace-no-wrap'
                                                        ])>
                                                            @if ($key == 0)
                                                                {{ $planbudget->gender_issue_mandate }}
                                                            @endif
                                                        </td>
                                                        <td @class([
                                                            'border',
                                                            'border-b-0' => $key == 0,
                                                            'border-y-0' => $key != 0,
                                                            'border-slate-300',
                                                            'px-2', 'py-2',
                                                            'text-sm', 'leading-5',
                                                            'text-gray-900',
                                                            'whitespace-no-wrap'
                                                        ])>
                                                            @if ($key == 0)
                                                                {{ $planbudget->cause_gender_issue }}
                                                            @endif
                                                        </td>
                                                        <td @class([
                                                            'border',
                                                            'border-b-0' => $key == 0,
                                                            'border-y-0' => $key != 0,
                                                            'border-slate-300',
                                                            'px-2', 'py-2',
                                                            'text-sm', 'leading-5',
                                                            'text-gray-900',
                                                            'whitespace-no-wrap'
                                                        ])>
                                                            @if ($key == 0)
                                                                {{ $planbudget->gad_objective }}
                                                            @endif
                                                        </td>
                                                        <td @class([
                                                            'border',
                                                            'border-b-0' => $key == 0,
                                                            'border-y-0' => $key != 0,
                                                            'border-slate-300',
                                                            'px-2', 'py-2',
                                                            'text-sm', 'leading-5',
                                                            'text-gray-900',
                                                            'whitespace-no-wrap'
                                                        ])>
                                                            @if ($key == 0)
                                                                {{ $planbudget->relevant_org }}
                                                            @endif
                                                        </td>      
                                                        <td @class([
                                                            'border',
                                                            'border-b-0' => $key == 0,
                                                            'border-y-0' => $key != 0,
                                                            'border-slate-300',
                                                            'px-2', 'py-2',
                                                            'text-sm', 'leading-5',
                                                            'text-gray-900',
                                                            'whitespace-no-wrap'
                                                        ])>
                                                            @if ($key == 0)
                                                                <div class="p-2">{!! $gad_act->main_activity !!}</div>
                                                            @endif
                                                        </td>  
                                                        <td class="border border-slate-300 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                            {{-- @foreach ($activities as $act)
                                                                @php
                                                                    $budget += $act->gad_budget;
                                                                    $actual_cost += $act->actual_cost;
                                                                @endphp
                                                                @endforeach --}}
                                                            <div class="p-2">{!! $act->targets !!}</div>
                                                        </td>                       
                                                        <td class="border border-slate-300 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                            {{-- @foreach ($activities as $act)
                                                                <div class="p-2">{!! $act->actual_result !!}</div>
                                                            @endforeach --}}
                                                            <div class="p-2">{!! $act->actual_result !!}</div>
                                                        </td>                       
                                                        <td class="border border-slate-300 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                            <div class="p-2">{{ number_format($act->gad_budget, 2, '.', ',') }}</div>
                                                        </td>                        
                                                        <td class="border border-slate-300 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                            <div class="p-2">{{ number_format($act->actual_cost, 2, '.', ',') }}</div>
                                                        </td>                        
                                                        <td class="border border-slate-300 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                            <div class="p-2">{!! $act->remarks !!}</div>
                                                        </td>                   
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @empty

                                    @endforelse

                                @endforeach

                                <tr>
                                    <td colspan="10" class="px-2 py-2 text-md bg-orange-100">
                                        ORGANIZATIONAL FOCUSED
                                    </td>
                                </tr>
                                @foreach($goals as $goal)
                                    @if($goal->focus=='organizational')
                                        <tr>
                                            <td colspan="10" class="px-2 py-2 text-md bg-blue-100">
                                                GAD Goal {{$goal->goal_no}}: {{$goal->gad_goal}}
                                            </td>
                                        </tr>
                                    @endif

                                    @forelse($planbudgets as $planbudget)
                                    
                                        @if($goal->focus=='organizational' && $goal->goal_id == $planbudget->goal_id && $planbudget->focus=='organizational')
                                            @php
                                                $ga_count_c = count($planbudget->gad_activities);
                                                $activities = [];
                                                $budget = 0;
                                                $actual_cost = 0;
                                            @endphp
                                            @foreach($planbudget->gad_activities as $key => $gad_act)
                                                @php
                                                    $activities = [...$activities, ...$gad_act->activity_details];
                                                @endphp
                                                @foreach ($activities as $key => $act)
                                                    <tr class="align-text-top">
                                                        <td @class([
                                                            'border',
                                                            'border-b-0' => $key == 0,
                                                            'border-y-0' => $key != 0,
                                                            'border-slate-300',
                                                            'px-2', 'py-2',
                                                            'text-sm', 'leading-5',
                                                            'text-gray-900',
                                                            'whitespace-no-wrap'
                                                        ])>
                                                            @if ($key == 0)
                                                                {{ $planbudget->gender_issue_mandate }}
                                                            @endif
                                                        </td>
                                                        <td @class([
                                                            'border',
                                                            'border-b-0' => $key == 0,
                                                            'border-y-0' => $key != 0,
                                                            'border-slate-300',
                                                            'px-2', 'py-2',
                                                            'text-sm', 'leading-5',
                                                            'text-gray-900',
                                                            'whitespace-no-wrap'
                                                        ])>
                                                            @if ($key == 0)
                                                                {{ $planbudget->cause_gender_issue }}
                                                            @endif
                                                        </td>
                                                        <td @class([
                                                            'border',
                                                            'border-b-0' => $key == 0,
                                                            'border-y-0' => $key != 0,
                                                            'border-slate-300',
                                                            'px-2', 'py-2',
                                                            'text-sm', 'leading-5',
                                                            'text-gray-900',
                                                            'whitespace-no-wrap'
                                                        ])>
                                                            @if ($key == 0)
                                                                {{ $planbudget->gad_objective }}
                                                            @endif
                                                        </td>
                                                        <td @class([
                                                            'border',
                                                            'border-b-0' => $key == 0,
                                                            'border-y-0' => $key != 0,
                                                            'border-slate-300',
                                                            'px-2', 'py-2',
                                                            'text-sm', 'leading-5',
                                                            'text-gray-900',
                                                            'whitespace-no-wrap'
                                                        ])>
                                                            @if ($key == 0)
                                                                {{ $planbudget->relevant_org }}
                                                            @endif
                                                        </td>      
                                                        <td @class([
                                                            'border',
                                                            'border-b-0' => $key == 0,
                                                            'border-y-0' => $key != 0,
                                                            'border-slate-300',
                                                            'px-2', 'py-2',
                                                            'text-sm', 'leading-5',
                                                            'text-gray-900',
                                                            'whitespace-no-wrap'
                                                        ])>
                                                            @if ($key == 0)
                                                                <div class="p-2">{!! $gad_act->main_activity !!}</div>
                                                            @endif
                                                        </td>  
                                                        <td class="border border-slate-300 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                            {{-- @foreach ($activities as $act)
                                                                @php
                                                                    $budget += $act->gad_budget;
                                                                    $actual_cost += $act->actual_cost;
                                                                @endphp
                                                                @endforeach --}}
                                                            <div class="p-2">{!! $act->targets !!}</div>
                                                        </td>                       
                                                        <td class="border border-slate-300 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                            {{-- @foreach ($activities as $act)
                                                                <div class="p-2">{!! $act->actual_result !!}</div>
                                                            @endforeach --}}
                                                            <div class="p-2">{!! $act->actual_result !!}</div>
                                                        </td>                       
                                                        <td class="border border-slate-300 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                            <div class="p-2">{{ number_format($act->gad_budget, 2, '.', ',') }}</div>
                                                        </td>                        
                                                        <td class="border border-slate-300 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                            <div class="p-2">{{ number_format($act->actual_cost, 2, '.', ',') }}</div>
                                                        </td>                        
                                                        <td class="border border-slate-300 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                            <div class="p-2">{!! $act->remarks !!}</div>
                                                        </td>                   
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @empty

                                    @endforelse
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>