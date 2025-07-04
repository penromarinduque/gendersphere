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
        <router-view />
    </div>

    {{-- <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">
                    <div class="grid grid-cols-1 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-5 gap-4 mb-3">
                        <div class="col-span-1">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('List of PENRO Employees') }}
                                </h2>
                            </header>
                        </div>
                        <div class="col-span-1">
                            <select class="w-56 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="window.location.href='/report/employees/'+this.value;">
                                <option value="">-Employment Type-</option>
                                <option value="permanent" {{ ($type=='permanent') ? 'selected' : '' }}>Permanent</option>
                                <option value="cos" {{ ($type=='cos') ? 'selected' : '' }}>Contract of Service (COS)</option>
                            </select>
                        </div>
                    </div>
                    <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                                <span
                                    class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Name</span>
                            </th>
                            <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                                <span
                                    class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Position</span>
                            </th>
                            <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                                <span
                                    class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender</span>
                            </th>
                            <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                                <span
                                    class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Address</span>
                            </th>
                            <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                                <span
                                    class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Age</span>
                            </th>
                            <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                                <span
                                    class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Birthdate</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($employees as $employee)
                        <tr class="bg-white">
                            <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                <span style="text-transform: capitalize;">{{ $employee->lastname.', '.$employee->firstname.' '.$employee->middlename.' '.$employee->extname }}</span>
                            </td>
                            <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                <span style="text-transform: capitalize;">{{ $employee->position }}</span>
                            </td>
                            <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                <span style="text-transform: capitalize;">{{ $employee->gender }}</span>
                            </td>
                            <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                <span style="text-transform: capitalize;">{{ $employee->barangay_name.', '.$employee->municipality_name.', '.$employee->province_name }}</span>
                            </td>
                            <td class="border border-slate-300 px-6 py-2text-md leading-5 text-gray-900 whitespace-no-wrap">
                                <span style="text-transform: capitalize;">{{ $employee->age }}</span>
                            </td>
                            <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                                {{ $employee->birthdate }}
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
</x-app-layout>