<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-cloak x-init="$watch('darkMode', (val) => localStorage.setItem('dark',val))" x-data="{darkMode: localStorage.getItem('dark')}" :class="darkMode==='true' || darkMode==true ? 'dark' : ''" :data-dark="darkMode">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Telixcel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <!--<link rel="stylesheet" href="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/app.min.css">-->
        <link rel="stylesheet" href="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/2022/app.min.css">
        <link rel="stylesheet" href="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/2022/tail.min.css">
        <link rel="apple-touch-icon" sizes="57x57" href="{{url('favicon/apple-icon-57x57.png')}}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{url('favicon/apple-icon-60x60.png')}}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{url('favicon/apple-icon-72x72.png')}}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{url('favicon/apple-icon-76x76.png')}}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{url('favicon/apple-icon-114x114.png')}}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{url('favicon/apple-icon-120x120.png')}}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{url('favicon/apple-icon-144x144.png')}}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{url('favicon/apple-icon-152x152.png')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{url('favicon/apple-icon-180x180.png')}}">
        <!--<link rel="icon" type="image/png" sizes="192x192"  href="{{url('android-icon-192x192.png')}}">-->
        <link rel="icon" type="image/png" sizes="32x32" href="{{url('favicon/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{url('favicon/favicon-96x96.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{url('favicon/favicon-16x16.png')}}">
        <!--<link rel="manifest" href="/manifest.json">-->
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        @trixassets
        @livewireStyles

        <!-- Scripts -->
        <script src="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/app.js" defer></script>
    </head>
    <body class="font-sans antialiased" style="zoom:90%;">
        <x-jet-banner />
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
                {{ $slot }}
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
        @stack('chat-box')
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
                if (localStorage.dark === 'true') {
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
        <script>
            (function(n,o,t,i,f) {
                n[i] = {}; var m = ['init', 'on']; n[i]._c = [];m.forEach(me => n[i][me] = function() {n[i]._c.push([me, arguments])});
                var elt = o.createElement(f); elt.type = "text/javascript"; elt.async = true; elt.src = t;
                var before = o.getElementsByTagName(f)[0]; before.parentNode.insertBefore(elt, before);
            })(window, document, 'https://embed.novu.co/embed.umd.min.js', 'novu', 'script');

            novu.init('GmksWJkfvKlW', '#notification-bell', {
                subscriberId: "on-boarding-subscriber-id-123",
            });
        </script>   
    </body>
</html>
