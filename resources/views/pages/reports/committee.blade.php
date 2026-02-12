@php
    $year = request()->get('year', date('Y'));
@endphp
<x-app-layout>
    <x-slot name="title">
    {{ __('Report - Committee') }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report / Committee') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <div class="flex justify-between mb-4">
                    <form method="GET" action="" >
                        Filter by Year
                        <select name="year" id="year" class="w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 " onchange="this.form.submit()">
                            <option value="">-YEAR-</option>
                            @for($i=date('Y'); $i >= 2018; $i--)
                            <option value="{{$i}}" {{($i==$year) ? 'selected' : ''}}>{{$i}}</option>
                            @endfor
                        </select>
                    </form>
                    <button onclick="printJS({printable:'toPrint', type:'html',  css: '{{ Vite::asset('resources/css/app.css') }}'})" type="button" class="inline-flex items-center mr-1 px-4 py-1 text-md h-10 font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25" >
                        <span>Print Result</span>
                    </button>
                </div>
                <div class="p-4 bg-white shadow sm:rounded-lg mb-4">
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">Summary</h6>
                    <div class="grid gap-1  sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-5">
                        <div class="">
                            <h6 class="italic font-bold">Permanent Employees</h6>
                            <p>Male: <b>{{ $committees->where('personInfo.employment_type', 'permanent')->where('personInfo.gender', 'male')->count() }}</b></p>
                            <p>Female: <b>{{ $committees->where('personInfo.employment_type', 'permanent')->where('personInfo.gender', 'female')->count() }}</b></p>
                            <p>LGBTQIA+: <b>{{ $committees->where('personInfo.employment_type', 'permanent')->where('personInfo.gender', 'lgbtqia+')->count() }}</b></p>
                            <p>Total: <b>{{ $committees->where('personInfo.employment_type', 'permanent')->count() }}</b></p>
                        </div>
                        <div class="">
                            <h6 class="italic font-bold">COS Employees</h6>
                            <p>Male: <b>{{ $committees->where('personInfo.employment_type', 'cos')->where('personInfo.gender', 'male')->count() }}</b></p>
                            <p>Female: <b>{{ $committees->where('personInfo.employment_type', 'cos')->where('personInfo.gender', 'female')->count() }}</b></p>
                            <p>LGBTQIA+: <b>{{ $committees->where('personInfo.employment_type', 'cos')->where('personInfo.gender', 'lgbtqia+')->count() }}</b></p>
                            <p>Total: <b>{{ $committees->where('personInfo.employment_type', 'cos')->count() }}</b></p>
                        </div>
                        <div class="">
                            <h6 class="italic font-bold">Male</h6>
                            <p>COS: <b>{{ $committees->where('personInfo.employment_type', 'cos')->where('personInfo.gender', 'male')->count() }}</b></p>
                            <p>Permanent: <b>{{ $committees->where('personInfo.employment_type', 'permanent')->where('personInfo.gender', 'male')->count() }}</b></p>
                            <p>Total: <b>{{ $committees->where('personInfo.gender', 'male')->count() }}</b></p>
                        </div>
                        <div class="">
                            <h6 class="italic font-bold">Female</h6>
                            <p>COS: <b>{{ $committees->where('personInfo.employment_type', 'cos')->where('personInfo.gender', 'female')->count() }}</b></p>
                            <p>Permanent: <b>{{ $committees->where('personInfo.employment_type', 'permanent')->where('personInfo.gender', 'female')->count() }}</b></p>
                            <p>Total: <b>{{ $committees->where('personInfo.gender', 'female')->count() }}</b></p>
                        </div>
                        <div class="">
                            <h6 class="italic font-bold">LGBTQIA+</h6>
                            <p>COS: <b>{{ $committees->where('personInfo.employment_type', 'cos')->where('personInfo.gender', 'lgbtqia+')->count() }}</b></p>
                            <p>Permanent: <b>{{ $committees->where('personInfo.employment_type', 'permanent')->where('personInfo.gender', 'lgbtqia+')->count() }}</b></p>
                            <p>Total: <b>{{ $committees->where('personInfo.gender', 'lgbtqia+')->count() }}</b></p>
                        </div>
                    </div>
                </div>
                <div id="toPrint">
                    <h3 class="text-lg"><b>Committee List</b></h3>
                    <div class="min-w-full w-full py-6">
                        <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Year</span>
                                    </th>
                                    <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Name</span>
                                    </th>
                                    <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Position</span>
                                    </th>
                                    <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender</span>
                                    </th>
                                    <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Address</span>
                                    </th>
                                    <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                        <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Age</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            @forelse($committees as $committee)
                                <tr class="bg-white">
                                    <td width="100px" class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                        <span style="text-transform: capitalize;">{{ $committee->created_at->format('Y') }}</span>
                                    </td>
                                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                        <span style="text-transform: capitalize;">{{ $committee->personInfo->full_name }}</span>
                                    </td>
                                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                        <span style="text-transform: capitalize;">{{ $committee->committeePosition->position_title }}</span>
                                    </td>
                                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                        <span style="text-transform: uppercase;">{{ $committee->personInfo->gender }}</span>
                                    </td>
                                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                        <span style="text-transform: capitalize;">{{ $committee->personInfo->address }}</span>
                                    </td>
                                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                        <span style="text-transform: capitalize;">{{ $committee->personInfo->age }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap"><center>No results found.</center></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="jscript">
        <script type="text/javascript">
        </script>
    </x-slot>
</x-app-layout>

