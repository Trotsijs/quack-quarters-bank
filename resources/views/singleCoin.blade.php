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
                    <div class="flex justify-center">
                        <img src="{{$coin->logo}}" alt="" height="64" width="64">
                    </div>

                    <div class="text-center text-3xl font-bold">{{$coin->name}}</div>
                    <div class="text-center text-xl text-gray-400">({{$coin->symbol}})</div>
                    <div class="text-center">{{number_format($coinInfo->price, 2)}}</div>
                    <div class="flex justify-center">
                    <form method="POST"
                          action="{{ route('buyCrypto', ['id' => $coinId, 'symbol' => $coinSymbol, 'price' => $coinPrice]) }}">

                        @csrf
                        <label for="from_account" class="font-bold mb-2 mt-2">From Account:</label>
                        <div class="flex gap-x-2 items-center">

                            <div x-data="{ selectedAccountType: 'savings' }">
                                <select id="from_account" name="from_account" class="border p-1 rounded w-96 mt-2 mb-2">
                                    @foreach (Auth::user()->accounts as $account)
                                        <option x-show="{{ $account->account_type === 'savings' }}"
                                                value="{{ $account->id }}">
                                            {{ $account->account_number }} {{ number_format($account->balance, 2) }} {{ $account->currency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <label for="amount" class="font-bold mb-2 mt-2">Amount:</label>
                        <div class="">
                            <input class="border p-1 rounded input-field w-96 mt-2 mb-2" type="text" id="amount"
                                   name="amount" placeholder="Enter Amount" value="{{ old('amount') }}">
                        </div>
                        @error('amount')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror

                        <label for="2fa_code" class="font-bold mb-2 mt-2">2FA Code:</label>
                        <div class="">
                            <input class="border p-1 rounded input-field w-96 mt-2 mb-2" type="text" id="2fa_code"
                                   name="2fa_code" placeholder="Enter code" value="{{ old('2fa_code') }}">
                        </div>
                        @error('2fa_code')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="flex justify-content-center mt-1">
                            <p class="text-gray-500 text-xs mr-2">Don't have 2FA Code?</p>
                            <p class="text-xs font-bold text-slate-800 hover:text-[#FF0029]"><a
                                    href="/security">Set up!</a></p>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 rounded mt-4">
                                Buy
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

