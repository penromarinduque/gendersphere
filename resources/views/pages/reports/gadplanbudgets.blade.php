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
                                @endphp
                                <tr class="align-text-top">
                                    <td rowspan="{{$ga_count_c}}" class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $planbudget->gender_issue_mandate }}
                                    </td>
                                    <td rowspan="{{$ga_count_c}}" class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $planbudget->cause_gender_issue }}
                                    </td>
                                    <td rowspan="{{$ga_count_c}}" class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $planbudget->gad_objective }}
                                    </td>
                                    <td rowspan="{{$ga_count_c}}" class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $planbudget->relevant_org }}
                                    </td>                                    
                                </tr>
                                
                                @if(!empty($ga_count_c))
                                @foreach($planbudget->gad_activities as $key => $gad_act)
                                <?php $key ?>
                                <tr>
                                    <td class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {!! $gad_act->main_activity !!}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                
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
                                    $ga_count_o = count($planbudget->gad_activities);
                                @endphp
                                <tr class="align-text-top">
                                    <td rowspan="{{$ga_count_o}}" class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $planbudget->gender_issue_mandate }}
                                    </td>
                                    <td rowspan="{{$ga_count_o}}" class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $planbudget->cause_gender_issue }}
                                    </td>
                                    <td rowspan="{{$ga_count_o}}" class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $planbudget->gad_objective }}
                                    </td>
                                    <td rowspan="{{$ga_count_o}}" class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $planbudget->relevant_org }}
                                    </td>
                                    <?php
                                        $act_details_o = 0;
                                        $activity_details_o = [];
                                    ?>
                                    @foreach($planbudget->gad_activities as $gadacty)
                                    <?php
                                        $act_details_o = count($gadacty->activity_details);
                                        $activity_details_o = $gadacty->activity_details;
                                    ?>
                                    <td class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $gadacty->main_activity }}
                                    </td>
                                    @endforeach
                                    @if($act_details_o == 1)
                                    @foreach($activity_details_o as $activity_detail_o)
                                    <td class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {!! $activity_detail_o->targets !!}
                                    </td>
                                    <td class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {!! $activity_detail_o->actual_result !!}
                                    </td>
                                    <td class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $activity_detail_o->gad_budget }}
                                    </td>
                                    <td class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $activity_detail_o->actual_cost }}
                                    </td>
                                    <td class="border border-slate-300 px-2 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {!! $activity_detail_o->remarks !!}
                                    </td>
                                    @endforeach
                                    @endif
                                </tr>
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