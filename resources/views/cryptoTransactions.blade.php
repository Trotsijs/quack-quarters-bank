<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center text-3xl font-bold mb-4">CRYPTO TRANSACTIONS</div>
                    <table class="table w-full">
                        <thead class="border-b-4">
                        <tr>

                            <th class="p-2 text-justify">Coin</th>
                            <th class="p-2 text-right">Trade Price</th>
                            <th class="p-2 text-right">Trade Amount</th>
                            <th class="p-2 text-right">Trade Type</th>
                            <th class="p-2 text-right">Spent</th>
                            <th class="p-2 text-right pr-5">Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cryptoTransactions as $transaction)
                            <tr class="border-b font-semibold">

                                <td class="p-2 text-left">{{ $transaction->coin_symbol }}</td>
                                <td class="p-2 text-right text-gray-600">$ {{ $transaction->coin_price }}</td>
                                <td class="p-2 text-right {{ $transaction->type === 'Sell' ? 'text-red-500' : 'text-green-500' }}">
                                    @if ($transaction->type === 'Buy')
                                        +{{ number_format($transaction->coin_amount, 10) }}
                                    @else
                                        -{{ number_format($transaction->coin_amount, 10) }}
                                    @endif
                                    {{ $transaction->coin_symbol }}
                                </td>
                                <td class="p-2 text-right">{{ $transaction->type }}</td>
                                <td class="p-2 text-right {{ $transaction->type === 'Sell' ? 'text-green-500' : 'text-red-500' }}">
                                    @if ($transaction->type === 'Buy')
                                        -{{ number_format($transaction->spent, 2) }}
                                    @else
                                        +{{ number_format($transaction->spent, 2) }}
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
