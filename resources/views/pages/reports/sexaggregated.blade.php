<x-app-layout>
    <x-slot name="title">
    {{ __('Report - Sex Dis-Aggregated Data') }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report / Sex Dis-Aggregated Data') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-5 gap-4">
                    <div class="col-span-1">
                        <h3 class="text-lg"><b>Sex Dis-Aggregated Data</b></h3>
                    </div>
                    <div class="col-span-3">
                        <form method="GET" action="{{route('report.sexaggregated')}}">
                            <div class="flex flex-no-wrap">
                              <div class="w-auto flex-none px-2">
                                <div>
                                    <select name="year" id="year" class="w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">-YEAR-</option>
                                        @for($i=date('Y'); $i >= 2018; $i--)
                                        <option value="{{$i}}" {{($i==$year) ? 'selected' : ''}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                              </div>
                              <div class="w-auto flex-none px-2">
                                <div>
                                    <select name="frontline_service_type_id" id="frontline_service_type_id" onchange="getPermitTypes(this.value);" class="w-60 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="">-FRONTLINE SERVICE TYPE-</option>
                                        @forelse($frontlineservicetypes as $frontlineservicetype)
                                        <option value="{{$frontlineservicetype->id}}" {{($frontlineservicetype->id==$frontline_service_type_id) ? 'selected' : ''}}>{{$frontlineservicetype->service}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                              </div>
                              <div class="w-auto flex-none px-2">
                                <div>
                                    <select name="permit_type_id" id="permit_type_id" class="w-48 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="">-PERMIT TYPE-</option>
                                        @forelse($permittypes as $permittype)
                                        <option value="{{$permittype->id}}" {{($permittype->id==$permit_type_id) ? 'selected' : ''}}>{{$permittype->permit_type}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                              </div>
                              <div class="w-auto flex-none px-2">
                                <button type="submit" name="view" value="view" class="inline-flex items-center mr-1 px-4 py-1 text-md h-10 font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25" >
                                    <span>Filter</span>
                                </button>
                              </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-span-1 flex place-content-end">
                        <button type="button" class="inline-flex items-center mr-1 px-4 py-1 text-md h-10 font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25" onclick="filter('year', 'frontline_service_type_id', 'permit_type_id');" >
                            <span>Print Result</span>
                        </button>
                    </div>
                </div>

                <br>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <div class="p-4 bg-white rounded-lg shadow h-full">
                            <div class="">
                                <h5 class="text-lg"><b>Frontline Service Types</b></h5>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach ($counts["frontline_service_type"] as $t)
                                <div class="">
                                    <h6 class="text-sm">{{ $t["name"] }} : <b>{{number_format($t["count"], 0)}}</b></h6>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="p-4 bg-white rounded-lg shadow h-full">
                            <div class="">
                                <h5 class="text-lg"><b>Permit Types</b></h5>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach ($counts["permit_type"] as $t)
                                <div class="">
                                    <h6 class="text-sm">{{ $t["name"] }} : <b>{{number_format($t["count"], 0)}}</b></h6>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="p-4 bg-white rounded-lg shadow h-full">
                            <div class="">
                                <h5 class="text-lg"><b>Gender</b></h5>
                            </div>
                            <div class="grid grid-cols-3 gap-4 0">
                                <div class="">
                                    <h6 class="text-sm">Male : <b>{{number_format($counts["gender"]["male"], 0)}}</b></h6>
                                </div>
                                <div class="">
                                    <h6 class="text-sm">Female : <b>{{number_format($counts["gender"]["female"], 0)}}</b></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="min-w-full w-full py-6">
                    <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">No.</span>
                                </th>
                                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Name of the Client</span>
                                </th>
                                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender</span>
                                </th>
                                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Address</span>
                                </th>
                                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Date Applied/Received</span>
                                </th>
                                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
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
                                <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                    <span style="text-transform: capitalize;">{{ $c++ }}</span>
                                </td>
                                <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                    <span style="text-transform: capitalize;">{{ $frontlineservice->client_name }}</span>
                                </td>
                                <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                    <span style="text-transform: capitalize;">{{ $frontlineservice->gender }}</span>
                                </td>
                                <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                    <span style="text-transform: capitalize;">{{ $frontlineservice->barangay_name.', '.$frontlineservice->municipality_name }}</span>
                                </td>
                                <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                    <span style="text-transform: capitalize;">{{ $frontlineservice->date_applied }}</span>
                                </td>
                                <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                    <span style="text-transform: capitalize;">{{ $frontlineservice->date_released }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap"><center>No results found.</center></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div>
                        <p>Male: {{$c_m}}</p>
                        <p>Female: {{$c_f}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="jscript">
        <script type="text/javascript">
        function getPermitTypes(frontlineservicetype_id) {
            $.ajax({
                type: 'GET',
                url: '/report/getpermittypes/'+frontlineservicetype_id,
                dataType: 'json',
                success: function (result){
                    // console.log(result);
                    var opt = '<option selected="selected" disabled="disabled">-PERMIT TYPE-</option>';
                    $.each(result, function (key, val) {
                        // console.log(val.id);
                        opt += '<option value="'+val.id+'">'+val.permit_type+'</option>';
                    });
                    $('#permit_type_id').html('').append(opt);
                    // console.log(opt);
                },
                error: function (result){
                    console.log(result);
                }
            });
        }

        function filter(year_fld, frontline_service_type_id_fld, permit_type_id_fld) {
            var year = document.getElementById(year_fld).value;
            var frontline_service_type_id = document.getElementById(frontline_service_type_id_fld).value;
            var permit_type_id = document.getElementById(permit_type_id_fld).value;
            console.log(year+' '+frontline_service_type_id+' '+permit_type_id);

            window.open("/report/sexaggregated-print?year="+year+"&frontline_service_type_id="+frontline_service_type_id+"&permit_type_id="+permit_type_id+"&print=print", "blank");
        }
        </script>
    </x-slot>
</x-app-layout>

