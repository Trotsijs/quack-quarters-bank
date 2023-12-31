<nav x-data="{ open: false }" class="text-white bg-black shadow-2xl">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('accounts') }}">
                        <x-application-logo class="block h-10 w-auto text-gray-600 mr-2"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex text-white">
{{--                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">--}}
{{--                        {{ __('Dashboard') }}--}}
{{--                    </x-nav-link>--}}
                    <x-nav-link :href="route('accounts')" :active="request()->routeIs('accounts')">
                        {{ __('Accounts') }}
                    </x-nav-link>
                    <x-nav-link :href="route('crypto')" :active="request()->routeIs('crypto')">
                        {{ __('Crypto') }}
                    </x-nav-link>
                </div>
                <!-- Transactions Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center font-bold text-white hover:text-purple-400 hover:border-gray-300 focus:outline-none focus:text-purple-400 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>Transactions</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('deposit')">
                                <div class="flex items-center gap-x-2">
                                    <div>
                                        <x-deposit-icon/>
                                    </div>
                                    <div>
                                        {{ __('Deposit') }}
                                    </div>
                                </div>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('withdraw')">
                                <div class="flex items-center gap-x-2">
                                    <div>
                                        <x-withdraw-icon/>
                                    </div>
                                    <div>
                                        {{ __('Withdraw') }}
                                    </div>
                                </div>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('transfer')">
                                <div class="flex items-center gap-x-2">
                                    <div>
                                        <x-transfer-icon/>
                                    </div>
                                    <div>
                                        {{ __('Transfer') }}
                                    </div>
                                </div>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('transactions')">
                                <div class="flex items-center gap-x-2">
                                    <div>
                                        <x-transaction-history-icon/>
                                    </div>
                                    <div>
                                        {{ __('Transaction history') }}
                                    </div>
                                </div>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('cryptoTransactions')">
                                <div class="flex items-center gap-x-2">
                                    <div>
                                        <x-transaction-history-icon/>
                                    </div>
                                    <div>
                                        {{ __('Crypto Transactions') }}
                                    </div>
                                </div>
                            </x-dropdown-link>

                        </x-slot>
                    </x-dropdown>
                </div>
            </div>


            <!-- Name Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-semibold text-white hover:text-purple-400 hover:border-gray-300 focus:outline-none focus:text-purple-400 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('create')">
                                <div class="flex items-center gap-x-2">
                                    <div>
                                        <x-create-icon/>
                                    </div>
                                    <div>
                                        {{ __('New Account') }}
                                    </div>
                                </div>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('portfolio')">
                                <div class="flex items-center gap-x-2">
                                    <div>
                                        <x-portfolio-icon/>
                                    </div>
                                    <div>
                                        {{ __('Crypto Portfolio') }}
                                    </div>
                                </div>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('security')">
                                <div class="flex items-center gap-x-2">
                                    <div>
                                        <x-security-icon/>
                                    </div>
                                    <div>
                                        {{ __('Security') }}
                                    </div>
                                </div>

                            </x-dropdown-link>

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <div class="flex items-center gap-x-2">
                                    <div class="fill-red-500">
                                        <x-logout-icon/>
                                    </div>
                                    <div class="text-red-500">
                                        {{ __('Log Out') }}
                                    </div>
                                </div>

                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('accounts')" :active="request()->routeIs('accounts')">
                {{ __('Accounts') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
