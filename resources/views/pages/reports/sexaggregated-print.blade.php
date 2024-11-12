@extends('layouts.print')
@section('title') Sex Aggregated Data @endSection
@section('content')
<div>
    <center>
        <h3 class="text-2xl font-bold dark:text-white">{{$report_heading}}</h3>
        <h3 class="text-2xl font-bold dark:text-white mb-2">CY {{$year}}</h3>
    </center>
	<table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="border border-slate-300 px-3 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">No.</span>
                </th>
                <th class="border border-slate-300 px-3 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Name of the Client</span>
                </th>
                <th class="border border-slate-300 px-3 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender</span>
                </th>
                <th class="border border-slate-300 px-3 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Address</span>
                </th>
                <th class="border border-slate-300 px-3 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Date Applied/Received</span>
                </th>
                <th class="border border-slate-300 px-3 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Date Approved/Released</span>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 divide-solid">
        @php
            $c = 1;
            $c_m = 0;
            $c_f = 0;
        @endphp
        @forelse($frontlineservices as $frontlineservice)
            <?php
            if ($frontlineservice->gender=="male") {
                $c_m++;
            }
            if ($frontlineservice->gender=="female") {
                $c_f++;
            }
            ?>
            <tr class="bg-white">
                <td class="border border-slate-300 px-3 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap">
                    <span style="text-transform: capitalize;">{{ $c++ }}</span>
                </td>
                <td class="border border-slate-300 px-3 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap">
                    <span style="text-transform: capitalize;">{{ $frontlineservice->client_name }}</span>
                </td>
                <td class="border border-slate-300 px-3 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap">
                    <span style="text-transform: capitalize;">{{ $frontlineservice->gender }}</span>
                </td>
                <td class="border border-slate-300 px-3 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap">
                    <span style="text-transform: capitalize;">{{ $frontlineservice->barangay_name.', '.$frontlineservice->municipality_name }}</span>
                </td>
                <td class="border border-slate-300 px-3 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap">
                    <span style="text-transform: capitalize;">{{ $frontlineservice->date_applied }}</span>
                </td>
                <td class="border border-slate-300 px-3 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap">
                    <span style="text-transform: capitalize;">{{ $frontlineservice->date_released }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="border border-slate-300 px-3 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap"><center>No results found.</center></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div>
        <p>Male: {{$c_m}}</p>
        <p>Female: {{$c_f}}</p>
    </div>
</div>
@endSection

@section('script-extra')
<script type="text/javascript">
    window.print();
</script>
@endSection