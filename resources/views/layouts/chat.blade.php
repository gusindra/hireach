<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-cloak
    x-init="$watch('darkMode', (val) => localStorage.setItem('dark',val))"
    x-init="$watch('darkMode', value => console.log(value))"
    x-data="{darkMode: localStorage.getItem('dark')}"
    :class="darkMode==='true' || darkMode==true ? 'dark' : ''"
    :data-dark="darkMode">
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
        <!--<link rel="stylesheet" href="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/costum.css">-->
        <link rel="stylesheet" href="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/2022/app.min.css">
        <link rel="stylesheet" href="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/2022/tail.min.css">
        <link rel="stylesheet" href="{{ url('js/emoji/docs/assets/css/style.css') }}">
        @trixassets
        @livewireStyles
        <!-- Scripts -->
        <script src="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/app.js" defer></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script type="module" src="{{ url('js/emoji/docs/assets/js/jquery.emojiarea.min.js') }}"></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-slate-700">

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
                <div id="chat-event" class="md:mb-2 w-full flex md:flex-col bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-bl-2xl rounded-t-xl"></div>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ url('backend/js/socket.js')}}"></script>
        @stack('chat-websocket')
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
    </body>
</html>
