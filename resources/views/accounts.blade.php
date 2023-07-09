<x-app-layout>
    {{--    <x-slot name="header">--}}
    {{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
    {{--            {{ __('Accounts') }}--}}
    {{--        </h2>--}}
    {{--    </x-slot>--}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table w-full">
                        <thead class="bg-orange-300">
                        <tr>
                            <th class="p-2 text-justify">Account Number</th>
                            <th class="p-2 text-right">Account Type</th>
                            <th class="p-2 text-right">Currency</th>
                            <th class="p-2 text-right">Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($accounts as $account)
                            <tr class="">
                                <td class="p-2 text-left">{{ $account->account_number }}</td>
                                <td class="p-2 text-right">Checking</td>
                                <td class="p-2 text-right">{{ $account->currency }}</td>
                                <td class="p-2 font-bold text-right {{ $account->balance > 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ number_format($account->balance, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
