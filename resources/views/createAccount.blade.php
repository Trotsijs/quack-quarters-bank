<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex-col">
                    <div class="text-center text-3xl font-bold mb-4 text-center">Create a new Account</div>
                    <div class="flex justify-center">
                        <form action="{{ route('create') }}" method="POST" x-data="{ accountType: 'checking' }">
                            @csrf
                            <div>
                                <div>
                                    <label for="account_type" class="block text-gray-700 font-bold mb-2">Account
                                        type</label>
                                    <select id="account_type" name="account_type"
                                            class="text-gray-700 border border-gray-300 rounded py-2 px-4 w-60"
                                            x-model="accountType">
                                        <option value="checking">Checking</option>
                                        <option value="savings">Savings</option>
                                    </select>
                                </div>
                                <label for="currency" class="block text-gray-700 font-bold mb-2">Currency</label>
                                <select id="currency" name="currency"
                                        :class="{ 'bg-gray-100': accountType === 'savings' }"
                                        class="text-gray-700 border border-gray-300 rounded py-2 px-4 w-60 mb-2"
                                        x-bind:disabled="accountType === 'savings' && currency !== 'USD'"
                                        x-model="currency">
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>
                            <label for="2fa_code" class="mt-2 block text-gray-700 font-bold mb-2">2FA Code</label>
                            <x-input id="2fa_code" placeholder="2FA Code" class="block mt-1 w-60" type="text"
                                     name="2fa_code" :value="old('2fa_code')" required autofocus/>
                            @if ($errors->any())
                                <div class="text-red-500 text-sm mt-1">
                                    {{ $errors->first()}}
                                </div>
                            @endif
                            <div class="flex justify-content-center mt-1">
                                <p class="text-gray-500 text-xs mr-2">Don't have 2FA Code?</p>
                                <p class="text-xs font-bold text-slate-800 hover:text-[#FF0029]"><a
                                        href="/security">Set up!</a></p>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit"
                                        class="mt-6 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Create
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
