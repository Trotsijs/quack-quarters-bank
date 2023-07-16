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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

