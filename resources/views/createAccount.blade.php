<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex-col ">
                    <form action="{{ route('create') }}" method="POST">
                        @csrf
                        <label for="currency" class="block text-gray-700 font-bold mb-2">Currency</label>
                        <select id="currency" name="currency"
                                class="text-gray-700 border border-gray-300 rounded py-2 px-4 w-60">
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                        </select>
                        <label for="otp_secret" class="mt-2 block text-gray-700 font-bold mb-2">2FA Code</label>
                        <x-input id="otp_secret" placeholder="2FA Code" class="block mt-1 w-60" type="text"
                                 name="otp_secret" :value="old('otp_secret')" required autofocus/>
                        @if ($errors->any())
                            <div class="text-red-500 text-sm mt-1">
                                {{ $errors->first()}}
                            </div>
                        @endif
                        <button type="submit"
                                class="mt-6 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
