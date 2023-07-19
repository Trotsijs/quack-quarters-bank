<x-app-layout>
    @if(Session::has('success'))
        <x-success-notification>
            {{ session('success') }}
        </x-success-notification>
    @endif
    @if(Session::has('error'))
        <x-error-notification>
            {{ session('error') }}
        </x-error-notification>
    @endif
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-white text-xl font-bold">Checking</div>
        @foreach ($checkingAccounts as $account)
            <div class="flex flex-row py-4">
                <div class="flex-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex gap-x-2">
                                <x-bank-account-icon class="w-16 h-16"/>
                                <p class="font-bold text-lg">{{ $account->account_number }}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="p-2 font-bold text-right {{ $account->balance > 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ number_format($account->balance, 2) }}
                                </p>
                                <p class="font-bold">
                                    {{ $account->currency }}
                                </p>
                            </div>
                            <div>
                                <form action="{{ route('delete', $account->account_number) }}" method="POST"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this account?');"
                                            class="text-white font-bold py-1 px-4 rounded {{ $account->balance > 0 ? 'fill-gray-300' : 'fill-red-500 hover:fill-red-700' }}"
                                        {{ $account->balance > 0 ? 'disabled cursor-not-allowed' : '' }}>
                                        <x-delete-icon class="w-4 h-4"/>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if ($savingsAccounts)
            <div class="text-white text-xl font-bold">Savings</div>
        @endif
        @foreach ($savingsAccounts as $account)
            @if ($account->account_type === 'savings')
                <div class="flex flex-row py-4">
                    <div class="flex-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex gap-x-2">
                                    <x-savings-account-icon class="w-16 h-16"/>
                                    <p class="font-bold text-lg">{{ $account->account_number }}</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="p-2 font-bold text-right {{ $account->balance > 0 ? 'text-green-500' : 'text-red-500' }}">
                                        {{ number_format($account->balance, 2) }}
                                    </p>
                                    <p class="font-bold">
                                        {{ $account->currency }}
                                    </p>
                                </div>
                                <div>
                                    <form action="{{ route('delete', $account->account_number) }}" method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this account?');"
                                                class="text-white font-bold py-1 px-4 rounded {{ $account->balance > 0 ? 'fill-gray-300' : 'fill-red-500 hover:fill-red-700' }}"
                                            {{ $account->balance > 0 ? 'disabled cursor-not-allowed' : '' }}>
                                            <x-delete-icon class="w-4 h-4"/>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</x-app-layout>
