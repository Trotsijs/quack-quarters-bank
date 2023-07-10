<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <table class="table w-full">
                    <thead class="border-b-4">
                    <tr>
                        <th class="w-5 p-2 text-center">#</th>
                        <th class="p-2 text-justify">Name</th>
                        <th class="p-2 text-right">Price</th>
                        <th class="p-2 text-right">24h%</th>
                        <th class="p-2 text-right">7d%</th>
                        <th class="p-2 text-right">Market Cap</th>
                        <th class="p-2 text-right">Circulating Supply</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coins->data as $coin)
                        <tr class="border-b">
                            <td class="w-5 p-2 text-center">{{ $coin->cmc_rank }}</td>
                            <td class="p-2 text-left font-bold flex gap-x-2"><img src="https://coinicons-api.vercel.app/api/icon/{{ strtolower($coin->symbol) }}" height="25" width="25"> {{ $coin->name }} <span class="font-bold text-gray-500">{{ $coin->symbol }}</span></td>
                            <td class="p-2 text-right font-bold">${{ number_format($coin->quote->USD->price, 2) }}</td>
                            <td class="p-2 text-right font-bold @if($coin->quote->USD->percent_change_24h < 0) text-red-500 @else text-green-500 @endif">
                                {{ number_format($coin->quote->USD->percent_change_24h, 2) }}%
                            </td>
                            <td class="p-2 text-right font-bold @if($coin->quote->USD->percent_change_7d < 0) text-red-500 @else text-green-500 @endif">
                                {{ number_format($coin->quote->USD->percent_change_7d, 2) }}%
                            </td>
                            <td class="p-2 text-right font-bold">${{ $coin->quote->USD->market_cap }}</td>
                            <td class="w-5 p-2 text-right font-bold">{{ number_format($coin->total_supply, 0) }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                    </table>
                    <div class="text-center mt-6">
                        <p class="text-gray-400">Data from <a class="font-bold text-gray-500" href="https://coinmarketcap.com/">www.coinmarketcap.com</a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

