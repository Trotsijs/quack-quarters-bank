<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table w-full">
                        <thead class="bg-orange-300">
                        <tr>
                            <th class="p-2 text-justify">Account Number</th>
                            <th class="p-2 text-right">Account Type</th>
                            <th class="p-2 text-right">Currency</th>
                            <th class="p-2 text-right">Balance</th>
                            <th class="p-2 text-right pr-5">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($accounts as $account)
                            <tr class="border-b">
                                <td class="p-2 text-left">{{ $account->account_number }}</td>
                                <td class="p-2 text-right">Checking</td>
                                <td class="p-2 text-right">{{ $account->currency }}</td>
                                <td class="p-2 font-bold text-right {{ $account->balance > 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ number_format($account->balance, 2) }}
                                </td>
                                <td class="p-2 text-right">
                                    <form action="{{ route('delete', $account->account_number) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white font-bold py-1 px-4 rounded {{ $account->balance > 0 ? 'bg-gray-300' : 'bg-red-500 hover:bg-red-700' }}" {{ $account->balance > 0 ? 'disabled cursor-not-allowed' : '' }}>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
