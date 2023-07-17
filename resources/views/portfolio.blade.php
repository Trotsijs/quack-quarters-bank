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
                    <div class="text-center text-3xl font-bold mb-4">Portfolio</div>
                    <div class="text-center text-xl font-bold mb-4">${{number_format($totalPortfolioValue, 2)}}</div>
                    <table class="table w-full">
                        <thead class="border-b-4">
                        <tr>
                            <th class="p-2 text-justify">Coin</th>
                            <th class="p-2 text-right">Amount owned</th>
                            <th class="p-2 text-right">Value</th>
                            <th class="p-2 text-right">Trade</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($portfolioData as $data)
                            <tr class="border-b hover:bg-gray-200">
                                <td class="p-2 text-left font-bold flex gap-x-2"><img
                                        src="https://s2.coinmarketcap.com/static/img/coins/64x64/{{ $data->coin_id }}.png"
                                        height="25" width="25" alt=""> {{ $data->coin_symbol }}</td>
                                <td class="p-2 text-right font-bold">{{ number_format($data->amount, 10) }}</td>
                                <td class="p-2 text-right font-bold">${{ number_format($data->coin_value, 2) }}</td>
                                <td class="w-5 p-2 text-right font-bold">Trade</td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

