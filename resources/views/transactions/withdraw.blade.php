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
            <div class="flex justify-center items-center flex-col bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('withdraw') }}">
                        @csrf
                        <label for="account" class="block text-gray-700 font-bold mb-2">Select Account:</label>
                        <div class="flex gap-x-2 items-center">

                            <select id="account" name="account" class="text-gray-700 border border-gray-300 rounded py-2 px-4 text-sm w-96">
                                @foreach (Auth::user()->accounts as $account)
                                    <option
                                        value="{{ $account->id }}">{{ $account->account_number }} {{ number_format($account->balance, 2) }} {{ $account->currency }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="amount" class="mt-2 block text-gray-700 font-bold mb-2">Amount:</label>
                        <div class="">
                            <x-input class="block mt-1 w-96" type="text" id="amount"
                                     name="amount" placeholder="Enter Amount" value="{{ old('amount') }}" />
                        </div>
                        @error('amount')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <label for="description" class="mt-2 block text-gray-700 font-bold mb-2">Description:</label>
                        <div class="">
                            <x-input class="block mt-1 w-96" type="text" id="description"
                                     name="description" placeholder="Enter Description" value="{{ old('description') }}" />
                        </div>

                        <label for="2fa_code" class="mt-2 block text-gray-700 font-bold mb-2">2FA Code</label>
                        <x-input id="2fa_code" placeholder="2FA Code" class="block mt-1 w-96" type="text"
                                 name="2fa_code" :value="old('2fa_code')"/>
                        @error('2fa_code')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="flex justify-content-center mt-1">
                            <p class="text-gray-500 text-xs mr-2">Don't have 2FA Code?</p>
                            <p class="text-xs font-bold text-slate-800 hover:text-[#FF0029]"><a
                                    href="/security">Set up!</a></p>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded mt-4">
                                Withdraw
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
