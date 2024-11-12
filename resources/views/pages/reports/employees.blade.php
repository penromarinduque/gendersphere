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
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('List of PENRO Employees') }}
                            </h2>
                        </header>
                        <form method="post" action="" class="mt-6 space-y-6">
                        
                        </form>
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
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>