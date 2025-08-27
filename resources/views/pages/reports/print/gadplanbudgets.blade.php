@extends('layouts.print')
@section('content')
<div class="py-6 bg-white">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 ">
            <section>
                <header>
                    </div>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('ANNUAL GENDER AND DEVELOPMENT (GAD) ACCOMPLISHMENT REPORT '.$year) }}
                    </h2>
                </header>
                <div class="min-w-full w-full py-6 overflow-x-scroll">
                    @php
                        $subtotals = [];
                    @endphp
                    <table class="table-auto min-w-full w-full border-collapse border !border-slate-900!important divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender Issue/GAD Mandate</span>
                                </th>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Cause of Gender Issue</span>
                                </th>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Result Statement/ GAD Objective</span>
                                </th>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Relevant Organization MFO/PAP or PPA</span>
                                </th>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Activity</span>
                                </th>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Performance Indicators /Targets</span>
                                </th>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actual Results/ Outputs and Outcomes </span>
                                </th>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Budget</span>
                                </th>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actual Cost / Cost Expenditure</span>
                                </th>
                                <th class="border border-slate-900 px-2 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Remarks</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- CLIENT-FOCUSED ACTIVITIES --}}
                            <tr class="border border-slate-900">
                                @php
                                    $goal = $goals->where('focus', 'client')->first();
                                    $total_budget = $planbudgets
                                        ->where("goal_id", optional($goal)->goal_id)
                                        ->flatMap(function ($planbudget) {
                                            return $planbudget->gad_activities->flatMap(function ($activity) {
                                                return $activity->activity_details;
                                            });
                                        })
                                        ->sum('gad_budget');
                                    
                                    $total_actual_cost = $planbudgets
                                        ->where("goal_id", optional($goal)->goal_id)
                                        ->flatMap(function ($planbudget) {
                                            return $planbudget->gad_activities->flatMap(function ($activity) {
                                                return $activity->activity_details;
                                            });
                                        })
                                        ->sum('actual_cost');
                                    $subtotals[] = [
                                        "label" => "Client Focused",
                                        "budget" => $total_budget,
                                        "actual_cost" => $total_actual_cost,
                                        "is_attribution" => false
                                    ];
                                @endphp
                                <td colspan="7" class="px-2 py-2 text-md bg-orange-100">
                                    CLIENT-FOCUSED ACTIVITIES
                                </td>
                                <td  class="px-2 py-2 text-md bg-orange-100">
                                    {{ number_format($total_budget, 2, '.', ',') }}
                                </td>
                                <td  class="px-2 py-2 text-md bg-orange-100">
                                    {{ number_format($total_actual_cost, 2, '.', ',') }}
                                </td>
                                <td  class="px-2 py-2 text-md bg-orange-100"></td>
                            </tr>
                            @foreach($goals as $goal)
                                @if($goal->focus=='client')
                                    <tr class="border border-slate-900">
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
                                            // $total_budget = $planbudget->sum("gad_activities.activity_details.gad_budget");
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
                                                        'border-slate-900',
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
                                                        'border-slate-900',
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
                                                        'border-slate-900',
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
                                                        'border-slate-900',
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
                                                        'border-slate-900',
                                                        'px-2', 'py-2',
                                                        'text-sm', 'leading-5',
                                                        'text-gray-900',
                                                        'whitespace-no-wrap'
                                                    ])>
                                                        @if ($key == 0)
                                                            <div class="p-2">{!! $gad_act->main_activity !!}</div>
                                                        @endif
                                                    </td>  
                                                    <td class="border border-slate-900 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                        {{-- @foreach ($activities as $act)
                                                            @php
                                                                $budget += $act->gad_budget;
                                                                $actual_cost += $act->actual_cost;
                                                            @endphp
                                                            @endforeach --}}
                                                        <div class="p-2">{!! $act->targets !!}</div>
                                                    </td>                       
                                                    <td class="border border-slate-900 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                        {{-- @foreach ($activities as $act)
                                                            <div class="p-2">{!! $act->actual_result !!}</div>
                                                        @endforeach --}}
                                                        <div class="p-2">{!! $act->actual_result !!}</div>
                                                    </td>                       
                                                    <td class="border border-slate-900 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                        <div class="p-2">{{ number_format($act->gad_budget, 2, '.', ',') }}</div>
                                                    </td>                        
                                                    <td class="border border-slate-900 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                        <div class="p-2">{{ number_format($act->actual_cost, 2, '.', ',') }}</div>
                                                    </td>                        
                                                    <td class="border border-slate-900 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                        <div class="p-2">{!! $act->remarks !!}</div>
                                                    </td>                   
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endif
                                @empty

                                @endforelse

                            @endforeach

                            {{-- ORGANIZATIONAL FOCUSED --}}
                            <tr class="border border-slate-900">
                                @php
                                    $goal = $goals->where('focus', 'organizational')->first();
                                    $total_budget = $planbudgets
                                        ->where("goal_id", optional($goal)->goal_id)
                                        ->flatMap(function ($planbudget) {
                                            return $planbudget->gad_activities->flatMap(function ($activity) {
                                                return $activity->activity_details;
                                            });
                                        })
                                        ->sum('gad_budget');
                                    
                                    $total_actual_cost = $planbudgets
                                        ->where("goal_id", optional($goal)->goal_id)
                                        ->flatMap(function ($planbudget) {
                                            return $planbudget->gad_activities->flatMap(function ($activity) {
                                                return $activity->activity_details;
                                            });
                                        })
                                        ->sum('actual_cost');
                                    $subtotals[] = [
                                        "label" => "Organizational Focused",
                                        "budget" => $total_budget,
                                        "actual_cost" => $total_actual_cost,
                                        "is_attribution" => false
                                    ];
                                @endphp
                                <td colspan="7" class="px-2 py-2 text-md bg-orange-100">
                                    ORGANIZATIONAL FOCUSED
                                </td>
                                <td  class="px-2 py-2 text-md bg-orange-100">
                                    {{ number_format($total_budget, 2, '.', ',') }}
                                </td>
                                <td  class="px-2 py-2 text-md bg-orange-100">
                                    {{ number_format($total_actual_cost, 2, '.', ',') }}
                                </td>
                                <td  class="px-2 py-2 text-md bg-orange-100"></td>
                            </tr>
                            @foreach($goals as $goal)
                                @if($goal->focus=='organizational')
                                    <tr class="border border-slate-900">
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
                                                        'border-slate-900',
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
                                                        'border-slate-900',
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
                                                        'border-slate-900',
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
                                                        'border-slate-900',
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
                                                        'border-slate-900',
                                                        'px-2', 'py-2',
                                                        'text-sm', 'leading-5',
                                                        'text-gray-900',
                                                        'whitespace-no-wrap'
                                                    ])>
                                                        @if ($key == 0)
                                                            <div class="p-2">{!! $gad_act->main_activity !!}</div>
                                                        @endif
                                                    </td>  
                                                    <td class="border border-slate-900 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                        {{-- @foreach ($activities as $act)
                                                            @php
                                                                $budget += $act->gad_budget;
                                                                $actual_cost += $act->actual_cost;
                                                            @endphp
                                                            @endforeach --}}
                                                        <div class="p-2">{!! $act->targets !!}</div>
                                                    </td>                       
                                                    <td class="border border-slate-900 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                        {{-- @foreach ($activities as $act)
                                                            <div class="p-2">{!! $act->actual_result !!}</div>
                                                        @endforeach --}}
                                                        <div class="p-2">{!! $act->actual_result !!}</div>
                                                    </td>                       
                                                    <td class="border border-slate-900 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                        <div class="p-2">{{ number_format($act->gad_budget, 2, '.', ',') }}</div>
                                                    </td>                        
                                                    <td class="border border-slate-900 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                        <div class="p-2">{{ number_format($act->actual_cost, 2, '.', ',') }}</div>
                                                    </td>                        
                                                    <td class="border border-slate-900 p-0 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                                        <div class="p-2">{!! $act->remarks !!}</div>
                                                    </td>                   
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endif
                                @empty

                                @endforelse
                            @endforeach

                            {{-- ATTRIBUTED PROGRAMS --}}
                            <tr class="border !border-slate-800">
                                @php
                                    $goal = $goals->where('focus', 'organizational')->first();
                                    $total_budget = $planbudgets
                                        ->where("focus", "attributed program")
                                        ->sum(function($planbudget) {
                                            return $planbudget->attr_program_budget * ($planbudget->percentage / 100);
                                        });
                                @endphp
                                <td colspan="7" class="px-2 py-2 text-md ">
                                    ATTRIBUTED PROGRAMS
                                </td>
                                <td  class="px-2 py-2 text-md ">
                                    {{ number_format($total_budget, 2, '.', ',') }}
                                </td>
                                <td  class="px-2 py-2 text-md "></td>
                                <td  class="px-2 py-2 text-md "></td>
                            </tr>
                            @forelse($planbudgets->where('focus', 'attributed program') as $planbudget)
                                @php
                                    $subtotals[] = [
                                        "label" => $planbudget->attr_program_name."(".$planbudget->percentage."%)",
                                        "budget" => $planbudget->attr_program_budget * ($planbudget->percentage / 100),
                                        "actual_cost" => $planbudget->attr_program_budget * ($planbudget->percentage / 100),
                                        "is_attribution" => true
                                    ];
                                @endphp
                               <tr class="align-text-top bg-orange-500">
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ])>
                                        {{ $planbudget->attr_program_name }}
                                    </td>
                                    @for ($i = 0; $i < 6; $i++)
                                        <td @class([
                                            'border',
                                            'border-slate-900',
                                            'px-2', 'py-2',
                                            'text-sm', 'leading-5',
                                            'text-gray-900',
                                            'whitespace-no-wrap'
                                        ]) ></td>
                                    @endfor
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ])>
                                        {{ number_format($planbudget->attr_program_budget, 2, '.', ',') }}
                                    </td>
                                    @for ($i = 0; $i < 2; $i++)
                                        <td @class([
                                            'border',
                                            'border-slate-900',
                                            'px-2', 'py-2',
                                            'text-sm', 'leading-5',
                                            'text-gray-900',
                                            'whitespace-no-wrap'
                                        ]) ></td>
                                    @endfor
                               </tr>
                            @empty
                            @endforelse

                            <tr>
                                @for ($i = 0; $i < 10; $i++)
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ]) ></td>
                                @endfor
                            </tr>
                            <tr>
                                @for ($i = 0; $i < 5; $i++)
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ]) ></td>
                                @endfor
                                <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap',
                                        "text-right",
                                        "font-semibold"
                                ]) >SUB TOTAL</td>
                                @for ($i = 0; $i < 4; $i++)
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ]) ></td>
                                @endfor
                            </tr>
                            <tr>
                                @for ($i = 0; $i < 10; $i++)
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ]) ></td>
                                @endfor
                            </tr>
                            <tr>
                                @for ($i = 0; $i < 5; $i++)
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ]) ></td>
                                @endfor
                                <td @class([
                                    'border',
                                    'border-slate-900',
                                    'px-2', 'py-2',
                                    'text-sm', 'leading-5',
                                    'text-gray-900',
                                    'whitespace-no-wrap',
                                    "font-semibold",
                                ]) >Attribution (%)</td>
                                @for ($i = 0; $i < 4; $i++)
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ]) ></td>
                                @endfor
                            </tr>

                            @foreach (collect($subtotals)->where("is_attribution", true) as $subtotal)
                                <tr>
                                    @for ($i = 0; $i < 5; $i++)
                                        <td @class([
                                            'border',
                                            'border-slate-900',
                                            'px-2', 'py-2',
                                            'text-sm', 'leading-5',
                                            'text-gray-900',
                                            'whitespace-no-wrap'
                                        ]) ></td>
                                    @endfor
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap',
                                        "font-semibold"
                                    ])>{{ $subtotal["label"] }}</td>
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ])>{{ number_format($subtotal["budget"], 2, '.', ',') }}</td>
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ])>{{ number_format($subtotal["actual_cost"], 2, '.', ',') }}</td>
                                    @for ($i = 0; $i < 2; $i++)
                                        <td @class([
                                            'border',
                                            'border-slate-900',
                                            'px-2', 'py-2',
                                            'text-sm', 'leading-5',
                                            'text-gray-900',
                                            'whitespace-no-wrap'
                                        ]) ></td>
                                    @endfor
                                </tr>
                            @endforeach
                            @foreach (collect($subtotals)->where("is_attribution", false) as $subtotal)
                                <tr>
                                    @for ($i = 0; $i < 5; $i++)
                                        <td @class([
                                            'border',
                                            'border-slate-900',
                                            'px-2', 'py-2',
                                            'text-sm', 'leading-5',
                                            'text-gray-900',
                                            'whitespace-no-wrap'
                                        ]) ></td>
                                    @endfor
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap',
                                        "font-semibold"
                                    ])>{{ $subtotal["label"] }}</td>
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ])>{{ number_format($subtotal["budget"], 2, '.', ',') }}</td>
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ])>{{ number_format($subtotal["actual_cost"], 2, '.', ',') }}</td>
                                    @for ($i = 0; $i < 2; $i++)
                                        <td @class([
                                            'border',
                                            'border-slate-900',
                                            'px-2', 'py-2',
                                            'text-sm', 'leading-5',
                                            'text-gray-900',
                                            'whitespace-no-wrap'
                                        ]) ></td>
                                    @endfor
                                </tr>
                            @endforeach
                            <tr>
                                @for ($i = 0; $i < 5; $i++)
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ]) ></td>
                                @endfor
                                <td @class([
                                    'border',
                                    'border-slate-900',
                                    'px-2', 'py-2',
                                    'text-sm', 'leading-5',
                                    'text-gray-900',
                                    'whitespace-no-wrap',
                                    "font-semibold",
                                    "text-right"
                                ])>TOTAL GAD BUDGET</td>
                                <td @class([
                                    'border',
                                    'border-slate-900',
                                    'px-2', 'py-2',
                                    'text-sm', 'leading-5',
                                    'text-gray-900',
                                    'whitespace-no-wrap'
                                ])>{{ number_format(collect($subtotals)->sum("budget"), 2, '.', ',') }}</td>
                                <td @class([
                                    'border',
                                    'border-slate-900',
                                    'px-2', 'py-2',
                                    'text-sm', 'leading-5',
                                    'text-gray-900',
                                    'whitespace-no-wrap'
                                ])>{{ number_format(collect($subtotals)->sum("actual_cost"), 2, '.', ',') }}</td>
                                @for ($i = 0; $i < 2; $i++)
                                    <td @class([
                                        'border',
                                        'border-slate-900',
                                        'px-2', 'py-2',
                                        'text-sm', 'leading-5',
                                        'text-gray-900',
                                        'whitespace-no-wrap'
                                    ]) ></td>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('script-extra')
<script type="text/javascript">
    window.print();
</script>
@endsection
