<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonInfo;
use App\Models\PlanBudget;
use App\Models\FrontlineServiceType;
use App\Models\PermitType;
use App\Models\FrontlineService;

class ReportController extends Controller
{
    public function employees($type='permanent')
    {
        $employees = PersonInfo::select('person_infos.*', 'provinces.province_name', 'municipalities.municipality_name', 'barangays.barangay_name')
        // , 'barangays.barangay_name', 'municipalities.municipality_name, provinces.province_name'
            ->join('provinces', 'provinces.id', 'person_infos.province_id')
            ->join('municipalities', 'municipalities.id', 'person_infos.municipality_id')
            ->join('barangays', 'barangays.id', 'person_infos.barangay_id')
            ->where('person_type',1)
            ->where('employment_type', $type)
            ->get();
        return view('pages.reports.employees', [
            'employees' => $employees,
            'type' => $type
        ]);
    }

    public function gadPlanBudgets(Request $request)
    {
        $_planbudget = new PlanBudget;

        $year = ($request->year) ? $request->year : date('Y');
        $goals = $_planbudget->getPlanBudgetGoals($year);
        $planbudgets = $_planbudget->getPlanBudgetByYear($year);

        $str = '';
        $str = '<table border="1" style="border-collapse: collapse;">
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
                    <td colspan="10">
                        CLIENT-FOCUSED ACTIVITIES
                    </td>
                </tr>';
        foreach ($goals as $goal) {
            if($goal->focus=='client') {
            $str .= '<tr>
                    <td colspan="10">GAD Goal '.$goal->goal_no.' : '.$goal->gad_goal.'</td>
                </tr>';
            }

            if (!empty($planbudgets)) {
                foreach ($planbudgets as $planbudget) {
                    if($goal->focus=='client' && $goal->goal_id == $planbudget->goal_id && $planbudget->focus=='client'){
                        $ga_countc = count($planbudget->gad_activities);
                        // echo '<br>';
                        $ad_countc = 0;
                        $ad_colc = 1;
                        if (!empty($planbudget->gad_activities)) {
                            foreach ($planbudget->gad_activities as $gad_act) {
                                $ads_countc = count($gad_act->activity_details);
                                // echo '<br>';
                                if (!empty($gad_act->activity_details)) {
                                    foreach ($gad_act->activity_details as $activity_detail) {
                                        // $ad_col = ($ad_count > 1) ? 6 : 1;
                                        if ($ads_countc == 1 && $activity_detail->sub_activity==NULL) {
                                            $ad_colc = 1;
                                            $ad_countc = 0;
                                        } elseif ( ($ads_countc == 1 && $activity_detail->sub_activity!=NULL) || $ads_countc > 1 ) {
                                            $ad_colc = 6;
                                            $ad_countc = $ads_countc + 1;
                                        }
                                    }
                                }
                            }
                        }

                        // echo $ad_countc;
                        $rowspanc = $ga_countc + $ad_countc;
                        $str .= '<tr valign="top">
                                <td rowspan="'.$rowspanc.'">'.$planbudget->gender_issue_mandate.'</td>
                                <td rowspan="'.$rowspanc.'">'.$planbudget->cause_gender_issue.'</td>
                                <td rowspan="'.$rowspanc.'">'.$planbudget->gad_objective.'</td>
                                <td rowspan="'.$rowspanc.'">'.$planbudget->relevant_org.'</td>';
                                if (!empty($planbudget->gad_activities)) {
                                    foreach ($planbudget->gad_activities as $gad_act) {
                                        if($ga_countc > 1){ $str .= '</tr><tr>'; }
                                        $str .= '<td colspan="'.$ad_colc.'">'.$gad_act->id.'>'.$gad_act->main_activity.'</td>';
                                        if (!empty($gad_act->activity_details)) {
                                            foreach ($gad_act->activity_details as $activity_detail) {
                                                if (($ad_countc == 1 && $activity_detail->sub_activity!=NULL) || $ad_countc > 1) { $str .= '</tr><tr>'; }
                                                if($ad_countc > 1){
                                                $str .= '<td>'.$activity_detail->sub_activity.'</td>';    
                                                }
                                                $str .= '<td>'.$activity_detail->targets.'</td>';
                                                $str .= '<td>'.$activity_detail->actual_result.'</td>';
                                                $str .= '<td align="right">'.$activity_detail->gad_budget.'</td>';
                                                $str .= '<td align="right">'.$activity_detail->gad_cost.'</td>';
                                                $str .= '<td>'.$activity_detail->remarks.'</td>';
                                                if (($ad_countc == 1 && $activity_detail->sub_activity!=NULL) || $ad_countc > 1) { $str .= '</tr>'; }
                                            }
                                        } else {
                                            $str .= '
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            ';
                                        }
                                        if($ga_countc > 1){ $str .= '</tr>'; }
                                    }
                                    
                                }
                        $str .= '</tr>';
                        
                    }

                }
            }
        }

        $str .= '<tr>
                    <td colspan="10">
                        ORGANIZATIONAL FOCUSED
                    </td>
                </tr>';
        foreach ($goals as $goal) {
            if($goal->focus=='organizational') {
            $str .= '<tr>
                    <td colspan="10">GAD Goal '.$goal->goal_no.' : '.$goal->gad_goal.'</td>
                </tr>';
            }

            if (!empty($planbudgets)) {
                foreach ($planbudgets as $planbudget) {
                    if($goal->focus=='organizational' && $goal->goal_id == $planbudget->goal_id && $planbudget->focus=='organizational'){
                        $ga_count = count($planbudget->gad_activities);
                        $ad_count = 0;
                        $ad_col = 1;
                        if (!empty($planbudget->gad_activities)) {
                            foreach ($planbudget->gad_activities as $gad_act) {
                                $ads_count = count($gad_act->activity_details);
                                // echo '<br>';
                                if (!empty($gad_act->activity_details)) {
                                    foreach ($gad_act->activity_details as $activity_detail) {
                                        // $ad_col = ($ad_count > 1) ? 6 : 1;
                                        if ($ads_count == 1 && $activity_detail->sub_activity==NULL) {
                                            $ad_col = 1;
                                            $ad_count = 0;
                                        } elseif ( ($ads_count == 1 && $activity_detail->sub_activity!=NULL) || $ads_count > 1 ) {
                                            $ad_col = 6;
                                            $ad_count = $ads_count + 1;
                                        }
                                    }
                                }
                            }
                        }

                        // echo $ad_count;
                        $rowspan = $ga_count + $ad_count;
                        $str .= '<tr valign="top">
                                <td rowspan="'.$rowspan.'">'.$planbudget->gender_issue_mandate.'</td>
                                <td rowspan="'.$rowspan.'">'.$planbudget->cause_gender_issue.'</td>
                                <td rowspan="'.$rowspan.'">'.$planbudget->gad_objective.'</td>
                                <td rowspan="'.$rowspan.'">'.$planbudget->relevant_org.'</td>';
                                if (!empty($planbudget->gad_activities)) {
                                    foreach ($planbudget->gad_activities as $gad_act) {
                                        if($ga_count > 1){ $str .= '</tr><tr>'; }
                                        $str .= '<td colspan="'.$ad_col.'">'.$gad_act->id.'>'.$gad_act->main_activity.'</td>';
                                        if (!empty($gad_act->activity_details)) {
                                            foreach ($gad_act->activity_details as $activity_detail) {
                                                if (($ad_count == 1 && $activity_detail->sub_activity!=NULL) || $ad_count > 1) { $str .= '</tr><tr>'; }
                                                if($ad_count > 1){
                                                $str .= '<td>'.$activity_detail->sub_activity.'</td>';    
                                                }
                                                $str .= '<td>'.$activity_detail->targets.'</td>';
                                                $str .= '<td>'.$activity_detail->actual_result.'</td>';
                                                $str .= '<td align="right">'.$activity_detail->gad_budget.'</td>';
                                                $str .= '<td align="right">'.$activity_detail->gad_cost.'</td>';
                                                $str .= '<td>'.$activity_detail->remarks.'</td>';
                                                if (($ad_count == 1 && $activity_detail->sub_activity!=NULL) || $ad_count > 1) { $str .= '</tr>'; }
                                            }
                                        } else {
                                            $str .= '
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            ';
                                        }
                                        if($ga_count > 1){ $str .= '</tr>'; }
                                    }
                                    
                                }
                        $str .= '</tr>';
                        
                    }

                }
            }
        }

        $str .= '</tbody>
        </table>';

        // return $str;

        return view('pages.reports.gadplanbudgets', [
            'year' => $year,
            'goals' => $goals,
            'planbudgets' => $planbudgets,
        ]);
    }

    public function sexAggregated(Request $request)
    {
        return $this->generateSexAggregated($request);
    }

    public function sexAggregatedPrint(Request $request)
    {
        return $this->generateSexAggregated($request);
    }

    public function generateSexAggregated($request)
    {
        $_frontlineservicetype = new FrontlineServiceType;
        $_permittype = new PermitType;
        $_frontlinservice = new FrontlineService;

        $year = ($request->year) ? $request->year : date('Y');
        $frontline_service_type_id = ($request->frontline_service_type_id) ? $request->frontline_service_type_id : 0;
        $permit_type_id = $request->permit_type_id ? $request->permit_type_id : 1;

        $counts = [
            "frontline_service_type" => [],
            "permit_type" => [],
            "gender" => [
                "male" => FrontlineService::where([
                            "gender" => "male"
                        ])
                        ->whereYear('date_released', $year)
                        ->count(),
                "female" => FrontlineService::where([
                            "gender" => "female"
                        ])
                        ->whereYear('date_released', $year)
                        ->count(),
            ]
        ];

        $permit_types = $frontline_service_type_id > 0 ? PermitType::where("is_active_ptype", 1)->where("frontline_service_type_id", $frontline_service_type_id)->get() : PermitType::where("is_active_ptype", 1)->get();
        foreach($permit_types as $ptype){
            $counts["permit_type"][] = [
                "name" => $ptype->permit_type,
                "count" => FrontlineService::where("permit_type_id", $ptype->id)->count()
            ];
        }

        foreach(FrontlineServiceType::where("fs_status", 1)->get() as $ftype){
            $ptype_ids = PermitType::where([
                "frontline_service_type_id" => $ftype->id,
                "is_active_ptype" => 1
            ])->pluck("id");
            $counts["frontline_service_type"][] = [
                "name" => $ftype->service,
                "count" => FrontlineService::whereIn("permit_type_id", $ptype_ids)->count()
            ];
        }

        $frontlineservicetypes = $_frontlineservicetype->getFrontlineServiceType(1);
        $permittypes = $_permittype->getPermitTypes($frontline_service_type_id);
        $frontlineservices = $_frontlinservice->getFrontlineServicesByPermitType($permit_type_id, $year);
        $permit_type = ($permit_type_id!=0) ? $_permittype->getPermitType($permit_type_id) : [];
        $report_heading = "";
        if (!empty($permit_type)) {
            if ($permit_type->report_heading!=NULL) {
                $report_heading = $permit_type->report_heading;
            } else {
                $report_heading = "List of ".$permit_type->service." > ".$permit_type->permit_type;
            }
        }

        $blade_file = "sexaggregated";

        if ($request->print) {
            $blade_file = "sexaggregated-print";
        }

        return view('pages.reports.'.$blade_file, [
            'year' => $year,
            'frontline_service_type_id' => $frontline_service_type_id,
            'permit_type_id' => $permit_type_id,
            'frontlineservicetypes' => $frontlineservicetypes,
            'permittypes' => $permittypes,
            'frontlineservices' => $frontlineservices,
            'report_heading' => $report_heading,
            "counts" => $counts
        ]);
    }

    public function getPermitTypes($frontlineservicetype_id)
    {
        $_permittype = new PermitType;

        $permittypes = $_permittype->getPermitTypes($frontlineservicetype_id);
        return $permittypes;
    }
}
