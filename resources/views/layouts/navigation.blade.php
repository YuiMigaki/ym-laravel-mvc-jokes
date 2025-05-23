<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">


                    @auth
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800"/>
                        </a>

                    @else
                        <a href="{{ route('home') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800"/>
                        </a>
                    @endauth

                </div>

                <!-- Left Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        <x-nav-link :href="route('dashboard')"
                                    :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('home')"
                                    :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('joke')"
                                    :active="request()->routeIs('joke')">
                            {{ __('Joke') }}
                        </x-nav-link>

                        @if(auth()->user()->hasRole('Superuser') || auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff'))
                            <x-nav-link :href="route('user')"
                                        :active="request()->routeIs('user')">
                                {{ __('User') }}
                            </x-nav-link>
                        @endif
                        @can('role-assign')
                            <x-nav-link :href="route('admin.permissions')" :active="request()->routeIs('permissions')">
                                {{ __('Roles') }}
                            </x-nav-link>
                        @endcan

                    @else
                        <x-nav-link :href="route('home')"
                                    :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('joke')"
                                    :active="request()->routeIs('joke')">
                            {{ __('Joke') }}
                        </x-nav-link>

                    @endauth

                </div>

                <!-- Right Navigation Links -->

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link :href="route('about')"
                                :active="request()->routeIs('about')">
                        {{ __('About') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contact')"
                                :active="request()->routeIs('contact')">
                        {{ __('Contact') }}
                    </x-nav-link>
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->nickname }}</div>

                                <div class="ms-1">
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
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="p-5">{{ __('Guest') }}</div>
                    <br>
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Log In') }}
                    </x-nav-link>
                    @if (Route::has('register'))
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('Register') }}
                        </x-nav-link>
                    @endif
                @endauth

                <form action="{{ route('search')  }}"
                      method="POST" class="block mx-5">
                    @csrf
                    @method("POST")

                    <x-text-input type="text" name="keywords" placeholder="Joke search..." value=""
                                  class="w-full md:w-auto px-4 py-2 focus:outline-none text-black"/>

                    <x-primary-button type="submit"
                                      class="w-full md:w-auto
                           bg-sky-500 hover:bg-sky-600
                           text-white
                           px-4 py-2
                           focus:outline-none transition ease-in-out duration-500">
                        <i class="fa fa-search"></i> {{ __('Search') }}
                    </x-primary-button>
                </form>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
            @endauth

            @auth

                <x-responsive-nav-link :href="route('home')"
                                       :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('joke')"
                                       :active="request()->routeIs('joke')">
                    {{ __('Joke') }}
                </x-responsive-nav-link>

                @if(auth()->user()->hasRole('Superuser') || auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff'))
                    <x-responsive-nav-link :href="route('user')"
                                           :active="request()->routeIs('user')">
                        {{ __('User') }}
                    </x-responsive-nav-link>
                @endif
                @can('role-assign')
                    <x-responsive-nav-link :href="route('admin.permissions')"
                                           :active="request()->routeIs('permissions')">
                        {{ __('Roles') }}
                    </x-responsive-nav-link>
                @endcan

            @else

                <x-responsive-nav-link :href="route('joke')"
                                       :active="request()->routeIs('joke')">
                    {{ __('Joke') }}
                </x-responsive-nav-link>

            @endauth
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('About') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                {{ __('Contact') }}
            </x-responsive-nav-link>

            @auth
            @else
                <x-responsive-nav-link :href="route('login')"
                                       :active="request()->routeIs('login')">
                    {{ __('Log In') }}
                </x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')"
                                           :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->nickname }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

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
            @endauth
        </div>
    </div>
</nav>
