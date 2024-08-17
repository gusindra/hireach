<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-cloak x-init="$watch('darkMode', (val) => localStorage.setItem('dark',val))" x-data="{darkMode: localStorage.getItem('dark')}" :class="darkMode ? '' : ''" :data-dark="darkMode">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HiReach') }}</title>

        <!--Favicon-->
        <link rel="manifest" href="{{url('frontend/images/webmanifest.json')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{url('frontend/images/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{url('frontend/images/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{url('frontend/images/favicon-16x16.png')}}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{url('frontend/images/android-chrome-512x512.png')}}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <!--<link rel="stylesheet" href="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/app.min.css">-->
        <link rel="stylesheet" href="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/2022/app.min.css">
        <link rel="stylesheet" href="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/2022/tail.min.css">
        <style>
            #livewire-error {width: 100% !important;height: 100% !important;}
            [x-cloak] { display: none; }
        </style>
        @trixassets
        @livewireStyles

        <!-- Scripts -->
        <script src="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/app.js" defer></script>
    </head>
    <body class="font-sans antialiased" style="zoom:90%;">
        <x-jet-banner />
        @if (session('message'))
            <div x-data="{'show':true,'style':'success','message':null}" :class="{ 'bg-indigo-500': style == 'success', 'bg-red-700': style == 'danger' }" x-show="show" x-init="
                document.addEventListener('message', event => {
                    style = event.detail.style;
                    message = event.detail.message;
                    show = true;
                });
            " :class="{ 'shadow-lg': atTop, 'bg-indigo-500 text-white': !atTop, 'bg-white hidden text-indigo-800': atTop }"
            @scroll.window="show = (window.pageYOffset < 50) ? false: false">
                <div class="mx-auto py-2 px-3 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between flex-wrap">
                        <div class="w-0 flex-1 flex items-center min-w-0">
                            <span class="flex p-2 rounded-lg bg-indigo-600" :class="{ 'bg-indigo-600': style == 'success', 'bg-red-600': style == 'danger' }">
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>

                            <p class="ml-3 font-medium text-sm text-white truncate">{{ session('message') }}</p>
                        </div>

                        <div class="flex-shrink-0 sm:ml-3">
                            <button type="button" class="-mr-1 flex p-2 rounded-md focus:outline-none sm:-mr-2 transition hover:bg-indigo-600 focus:bg-indigo-600" :class="{ 'hover:bg-indigo-600 focus:bg-indigo-600': style == 'success', 'hover:bg-red-600 focus:bg-red-600': style == 'danger' }" aria-label="Dismiss" x-on:click="show = false">
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="min-h-screen bg-white dark:bg-slate-900">
            {{-- <button x-cloak x-on:click="darkMode==='true' || darkMode==true ? darkMode=false : darkMode=true;" class="inline-flex right-10 md:right-0 m-5">
                <!-- Icon Moon -->
                <svg x-show="darkMode==false||darkMode==='false'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <!-- Icon Sun -->
                <svg x-show="darkMode==true||darkMode==='true'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button> --}}

            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="hidden bg-white shadow">
                    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                <div id="chat-event" class="mb-0 w-full flex md:flex-col bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-bl-2xl rounded-t-xl"></div>
                <div class="mt-16">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        @livewireChartsScripts
        <script src="https://telixcel.com/vendor/livewire-charts/app.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ url('backend/js/socket.js')}}"></script>
        @stack('chat-websocket')
        @stack('charts')
        <!-- @stack('chat-box') -->
        @stack('chat-waweb')

        <script>
            // Initial load of the page
            window.addEventListener("load", function() {
                var mode = 'false';
                //Check if User Has Set Pref from Application
                if (('dark' in localStorage)) {
                    switchMode(localStorage.dark)
                } else {
                    // User Has No Preference, So Get the Browser Mode ( set in Computer settings )
                    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        mode = 'false';
                    } else {
                        mode = 'false';
                    }
                    localStorage.dark = mode;
                    // Inform Livewire of the Mode so that It toggles the DarkMode set  in Tailwind.config.js
                    Livewire.emitTo('dark', 'ModeView', localStorage.dark)
                    switchMode(mode)
                }
            });

            function switchMode(mode) {
                if (localStorage.dark === 'true' || localStorage.dark==1) {
                    document.documentElement.classList.add('dark')
                } else {
                    document.documentElement.classList.remove('dark')
                }
                Livewire.emitTo('dark', 'ModeView', mode)
            }

            // this emitted from Livewire to change the Class DarkMoe on and Off.
            window.addEventListener('view-mode', event => {
                localStorage.dark = event.detail.newMode;
                switchMode(event.detail.newMode);
            });
        </script>

        <audio id="sound" class="hidden" controls>
            <source src="{{url('/assets/sound/notif.wav')}}" type="audio/wav">
            Your browser does not support the audio element.
        </audio>
    </body>
</html>
