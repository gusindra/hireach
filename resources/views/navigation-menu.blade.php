<nav x-data="{ open: false }"
    class="w-full bg-slate-100 lg:bg-white dark:text-white border-b border-gray-100 dark:border-slate-50/[0.06] supports-backdrop-blur:bg-slate-100/60 dark:bg-slate-800 fixed">
    <!-- Primary Navigation Menu -->
    <!-- Primary Navigation Menu -->
    <!-- Primary Navigation Menu -->
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a class="navbar-brand" href="/">
                        <img class="hidden" src="https://hireach.archeeshop.com/frontend/images/logo-trans.png"
                            title="{{ env('APP_NAME') }}" style="width: 150px;" />
                        <img style="height:50px;" src="{{url('/assets/img/logos/logo2.svg')}}" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if (Auth::user()->activeRole && str_contains(auth()->user()->activeRole->role->name, 'Admin'))
                        <x-jet-nav-link href="{{ route('admin') }}" :active="request()->routeIs('admin')">
                            {{ __('Dashboard') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('admin.user') }}" :active="request()->routeIs('admin.user')">
                            {{ __('User') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('admin.order') }}" :active="request()->routeIs('admin.order')">
                            {{ __('Order') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('admin.settings') }}" :active="request()->routeIs('admin.settings')">
                            {{ __('Setting') }}
                        </x-jet-nav-link>
                    @else
                        <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-jet-nav-link>

                        @if (request()->routeIs('assistant') ||
                                request()->routeIs('project') ||
                                request()->routeIs('commercial') ||
                                request()->routeIs('order') ||
                                request()->routeIs('commercial.show'))
                            <x-jet-nav-link href="{{ route('project') }}" :active="request()->routeIs('project')">
                                {{ __('Project') }}
                            </x-jet-nav-link>
                            <x-jet-nav-link href="{{ route('commercial') }}" :active="request()->routeIs('commercial')">
                                {{ __('Commercial') }}
                            </x-jet-nav-link>
                            <x-jet-nav-link href="{{ route('order') }}" :active="request()->routeIs('order')">
                                {{ __('Order') }}
                            </x-jet-nav-link>
                        @elseif(false)
                            @if (@Auth::user()->role || Auth::user()->super->first())
                                @if (Auth::user()->activeRole && str_contains(auth()->user()->activeRole->role->name, 'Admin'))
                                    <x-jet-nav-link href="{{ route('admin.user') }}" :active="request()->routeIs('admin.user')">
                                        {{ __('Users') }}
                                    </x-jet-nav-link>
                                    <!--<x-jet-nav-link href="{{ route('user.billing.index') }}" :active="request()->routeIs('user.billing.index')">-->
                                    <!--    {{ __('Master Billing') }}-->
                                    <!--</x-jet-nav-link>-->
                                    <x-jet-nav-link href="{{ route('billing') }}" :active="request()->routeIs('billing')">
                                        {{ __('Billing') }}
                                    </x-jet-nav-link>
                                @endif
                            @endif

                            @if (Auth::user()->activeRole)
                                <x-jet-nav-link href="{{ route('assistant') }}" :active="request()->routeIs('assistant')">
                                    {{ __('Assistant') }}
                                </x-jet-nav-link>
                            @else
                                <x-jet-nav-link href="{{ route('client') }}" :active="request()->routeIs('client')">
                                    {{ __('Customers') }}
                                </x-jet-nav-link>
                                <x-jet-nav-link href="{{ route('template') }}" :active="request()->routeIs('template')">
                                    {{ __('Templates') }}
                                </x-jet-nav-link>
                                @if (Auth::user()->currentTeam && Auth::user()->currentTeam->user_id == Auth::user()->id)
                                    <x-jet-nav-link href="{{ route('billing') }}" :active="request()->routeIs('billing')">
                                        {{ __('Report') }}
                                    </x-jet-nav-link>
                                @endif
                            @endif

                            @if (Auth::user()->activeRole && str_contains(Auth::user()->activeRole->role->name, 'Super Admin'))
                                <x-jet-nav-link href="{{ route('settings') }}" :active="request()->routeIs('settings')">
                                    {{ __('Settings') }}
                                </x-jet-nav-link>
                            @endif
                        @endif
                        <x-jet-nav-link href="{{ route('resources.index') }}" :active="request()->routeIs('resources')">
                            {{ __('Resource') }}
                        </x-jet-nav-link>

                        <x-jet-nav-link href="{{ route('template') }}" :active="request()->routeIs('contents')">
                            {{ __('Content') }}
                        </x-jet-nav-link>


                        <x-jet-nav-link href="{{ route('payment.deposit') }}" :active="request()->routeIs('payment.deposit')">
                            {{ __('Billing') }}
                        </x-jet-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 flex-auto justify-end space-x-1">
                <!-- Global Search -->
                @if (auth()->user()->currentTeam && auth()->user()->currentTeam->id == env('IN_HOUSE_TEAM_ID'))
                    @livewire('search.all')
                @endif

                <!-- Notification Dropdown -->
                @livewire('notification-app', ['client_id' => Auth::user()->id], key(Auth::user()->id))

                <!-- Teams Dropdown -->
                @if (!empty(auth()->user()->listTeams) && Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-slate-300 bg-white supports-backdrop-blur:bg-white/60 dark:bg-slate-800 hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                        {{ Auth::user()->currentTeam ? Auth::user()->currentTeam->name : '' }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    @if (Auth::user()->currentTeam && Auth::user()->currentTeam->id !== 1)
                                        <!-- Team Settings -->
                                        <x-jet-dropdown-link
                                            href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                            {{ __('Team Settings') }}
                                        </x-jet-dropdown-link>
                                    @endif

                                    @if (@Auth::user()->isSuper->role == 'superadmin')
                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                                {{ __('Create New Team') }}
                                            </x-jet-dropdown-link>
                                        @endcan
                                    @else
                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                                {{ __('Create New Team') }}
                                            </x-jet-dropdown-link>
                                        @endcan
                                    @endif

                                    <div class="border-t border-gray-100"></div>

                                    @livewire('switch-team', ['totalTeam' => empty(auth()->user()->listTeams)])
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-slate-200 rounded-full focus:outline-none focus:border-gray-300 dark:bg-slate-700 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    @if (Auth::user()->activeRole)
                                        <span class="m-2 text-xs">{{ Auth::user()->activeRole->role->name }}</span>
                                    @endif
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            @livewire('switch-role')

                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>
                            @if (balance(auth()->user()) > 0)
                                <x-jet-dropdown-link href="{{ route('payment.deposit') }}"
                                    class="flex justify-between">
                                    <span>{{ __('Balance') }}</span> <small>Rp
                                        {{ number_format(balance(auth()->user())) }}</small>
                                </x-jet-dropdown-link>
                            @endif
                            @if (Auth::user()->hasTeamRole(Auth::user()->currentTeam, 'admin'))
                                @if (auth()->user()->currentTeam &&
                                        Laravel\Jetstream\Jetstream::hasApiFeatures() &&
                                        auth()->user()->currentTeam->id != 1)
                                    <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-jet-dropdown-link>
                                @endif
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>

                <!-- Status Dropdown -->
                <div class="ml-3 relative">
                    @livewire('agent-status')
                </div>

                <div class="flex items-center p-4 text-right hidden">
                    <!-- <a href="{{ strpos(Request::fullUrl(), '?') !== false ? Request::fullUrl() . '&' : Request::url() . '?' }}v=1" class="inline-flex dark:hover:bg-slate-600 cursor-pointer items-center px-2 py-1 text-gray-600 dark:bg-slate-800 border border-transparent rounded-md font-normal text-xs dark:text-white 1g-widest hover:text-slate-700 active:bg-green-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                        </svg>
                    </a> -->
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <!-- Responsive Navigation Menu -->
    <!-- Responsive Navigation Menu -->
    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-slate-300 lg:bg-white">
            @if (Auth::user()->activeRole && str_contains(auth()->user()->activeRole->role->name, 'Admin'))
                <x-jet-responsive-nav-link href="{{ route('admin') }}" :active="request()->routeIs('admin')">
                    {{ __('Dashboard') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link href="{{ route('admin.user') }}" :active="request()->routeIs('admin.user')">
                    {{ __('User') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link href="{{ route('admin.order') }}" :active="request()->routeIs('admin.order')">
                    {{ __('Order') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link href="{{ route('admin.settings') }}" :active="request()->routeIs('admin.settings')">
                    {{ __('Setting') }}
                </x-jet-responsive-nav-link>
            @else
                <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-jet-responsive-nav-link>

                @if (request()->routeIs('assistant') ||
                        request()->routeIs('project') ||
                        request()->routeIs('commercial') ||
                        request()->routeIs('order') ||
                        request()->routeIs('commercial.show'))
                    <x-jet-responsive-nav-link href="{{ route('project') }}" :active="request()->routeIs('project')">
                        {{ __('Project') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('commercial') }}" :active="request()->routeIs('commercial')">
                        {{ __('Commercial') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('order') }}" :active="request()->routeIs('order')">
                        {{ __('Order') }}
                    </x-jet-responsive-nav-link>
                @elseif(false)
                    @if (@Auth::user()->role || Auth::user()->super->first())
                        @if (Auth::user()->activeRole && str_contains(auth()->user()->activeRole->role->name, 'Admin'))
                            <x-jet-responsive-nav-link href="{{ route('admin.user') }}" :active="request()->routeIs('admin.user')">
                                {{ __('Users') }}
                            </x-jet-responsive-nav-link>
                            <!--<x-jet-responsive-nav-link href="{{ route('user.billing.index') }}" :active="request()->routeIs('user.billing.index')">-->
                            <!--    {{ __('Master Billing') }}-->
                            <!--</x-jet-responsive-nav-link>-->
                            <x-jet-responsive-nav-link href="{{ route('billing') }}" :active="request()->routeIs('billing')">
                                {{ __('Billing') }}
                            </x-jet-responsive-nav-link>
                        @endif
                    @endif

                    @if (Auth::user()->activeRole)
                        <x-jet-responsive-nav-link href="{{ route('assistant') }}" :active="request()->routeIs('assistant')">
                            {{ __('Assistant') }}
                        </x-jet-responsive-nav-link>
                    @else
                        <x-jet-responsive-nav-link href="{{ route('client') }}" :active="request()->routeIs('client')">
                            {{ __('Customers') }}
                        </x-jet-responsive-nav-link>
                        <x-jet-responsive-nav-link href="{{ route('template') }}" :active="request()->routeIs('template')">
                            {{ __('Templates') }}
                        </x-jet-responsive-nav-link>
                        @if (Auth::user()->currentTeam && Auth::user()->currentTeam->user_id == Auth::user()->id)
                            <x-jet-responsive-nav-link href="{{ route('billing') }}" :active="request()->routeIs('billing')">
                                {{ __('Report') }}
                            </x-jet-responsive-nav-link>
                        @endif
                    @endif

                    @if (Auth::user()->activeRole && str_contains(Auth::user()->activeRole->role->name, 'Super Admin'))
                        <x-jet-responsive-nav-link href="{{ route('settings') }}" :active="request()->routeIs('settings')">
                            {{ __('Settings') }}
                        </x-jet-responsive-nav-link>
                    @endif
                @endif
                <x-jet-responsive-nav-link href="{{ route('resources.index') }}" :active="request()->routeIs('resources')">
                    {{ __('Resource') }}
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link href="{{ route('template') }}" :active="request()->routeIs('contents')">
                    {{ __('Content') }}
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link href="{{ route('payment.deposit') }}" :active="request()->routeIs('payment.deposit')">
                    {{ __('Billing') }}
                </x-jet-responsive-nav-link>
            @endif
            <!-- <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('resources.index') }}" :active="request()->routeIs('resources.index')">
                {{ __('Resource') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('template') }}" :active="request()->routeIs('contents')">
                {{ __('Content') }}
            </x-jet-responsive-nav-link> -->
            <!-- <x-jet-responsive-nav-link href="{{ route('message') }}" :active="request()->routeIs('message')">
                {{ __('Chat Area') }}
            </x-jet-responsive-nav-link> -->
            @if (Auth::user()->hasTeamRole(Auth::user()->currentTeam, 'admin'))
                <!-- <x-jet-responsive-nav-link href="{{ route('client') }}" :active="request()->routeIs('client')">
                    {{ __('Customers') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link href="{{ route('template') }}" :active="request()->routeIs('template')">
                    {{ __('Templates') }}
                </x-jet-responsive-nav-link> -->
                @if (Auth::user()->currentTeam && Auth::user()->currentTeam->user_id == Auth::user()->id)
                    <x-jet-responsive-nav-link href="{{ route('billing') }}" :active="request()->routeIs('billing')">
                        {{ __('Billing') }}
                    </x-jet-responsive-nav-link>
                @endif
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-1 pb-1 border-t border-gray-200">
            <div class="bg-slate-300 lg:bg-white">
                <!-- Team Management -->
                @if (Auth::user()->currentTeam && Laravel\Jetstream\Jetstream::hasTeamFeatures())

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @if (auth()->user()->super->first() && auth()->user()->super->first()->role == 'member')
                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                {{ __('Create New Team') }}
                            </x-jet-responsive-nav-link>
                        @endcan
                    @endif

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif

                <div class="border-t border-gray-200 my-4"></div>

                <div class="hidden lg:flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="flex-shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover"
                                src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (auth()->user()->currentTeam &&
                        Laravel\Jetstream\Jetstream::hasApiFeatures() &&
                        auth()->user()->currentTeam->id != 1)
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
