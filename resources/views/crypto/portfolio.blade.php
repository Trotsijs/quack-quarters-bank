<x-app-layout>
    @if(Session::has('error'))
        <x-error-notification>
            {{ session('error') }}
        </x-error-notification>
    @endif
    @if(Session::has('success'))
        <x-success-notification>
            {{ session('success') }}
        </x-success-notification>
    @endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="text-center text-3xl font-bold mb-1 mt-4">My Portfolio</div>
                <div class="text-center text-xl font-bold mb-4 text-green-500">
                    ${{number_format($totalPortfolioValue, 2)}}</div>
            </div>
            @foreach($portfolioData as $data)
                <div class="flex flex-row py-4">
                    <div class="flex-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex gap-x-2 items-center">
                                    <img
                                        src="https://s2.coinmarketcap.com/static/img/coins/64x64/{{ $data->coin_id }}.png"
                                        height="50" width="50" alt="">
                                    <p class="font-bold text-lg">{{ $data->coin_symbol }}</p>
                                    <p class="p-2 font-bold text-lg">
                                        {{ number_format($data->amount, 10) }}
                                    </p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-bold text-lg">
                                            ${{ number_format($data->coin_value, 2) }}
                                        </p>
                                    </div>
                                    <a href="coin/{{$data->coin_id}}">
                                        <button class="bg-purple-900 hover:bg-purple-500 py-2 px-4 text-white rounded ml-4">
                                            Trade
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

