<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen">
        <div class="flex flex-col items-center">
            <div>
                <x-application-logo class="w-96 h-20 fill-current"/>
            </div>
            <div class="mt-4">
                <a href="{{ route('login') }}" class="px-4 py-2 border-4 border-white text-white font-bold mr-2">Log In</a>
                <a href="{{ route('register') }}" class="px-4 py-2 border-4 border-white text-white font-bold">Register</a>
            </div>
        </div>
    </div>
</x-guest-layout>
