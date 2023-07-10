<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table w-full">
                        <thead class="bg-orange-300">
                        <tr>
                            <th class="p-2 text-justify">Account</th>
                            <th class="p-2 text-justify">To</th>
                            <th class="p-2 text-right">Type</th>
                            <th class="p-2 text-right">Description</th>
                            <th class="p-2 text-right">Amount</th>
                            <th class="p-2 text-right pr-5">Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="border-b">
                                <td class="p-2 text-left">{{ $transaction->from_account_id }}</td>
                                <td class="p-2 text-left">{{ $transaction->to_account_id }}</td>
                                <td class="p-2 text-right">{{ $transaction->type }}</td>
                                <td class="p-2 text-right">{{ $transaction->description }}</td>
                                <td class="p-2 text-right {{ $transaction->type === 'Deposit' ? 'text-green-500' : 'text-red-500' }}">
                                    @if ($transaction->type === 'Deposit')
                                        +{{ $transaction->amount }}
                                    @else
                                        -{{ $transaction->amount }}
                                    @endif
                                </td>
                                <td class="p-2 text-right text-gray-400">{{ $transaction->created_at }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
