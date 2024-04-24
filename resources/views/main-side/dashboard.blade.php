@extends('layouts.side-menu')

@section('title', 'Dashboard')

@section('header')
    <link href="{{ url('assets/css/full-calendar.css') }}" type="text/css" rel="stylesheet">
@endsection

@section('sidebar')
    @parent
    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <nav class="absolute z-20 flex flex-wrap items-center justify-between w-full px-6 py-2 text-white transition-all shadow-none duration-250 ease-soft-in lg:flex-nowrap lg:justify-start"
        navbar-profile navbar-scroll="true">
        <div class="flex items-center justify-between w-full px-6 py-1 mx-auto flex-wrap-inherit">
            <nav>
                <ol class="flex flex-wrap pt-1 pl-2 pr-4 mr-12 bg-transparent rounded-lg sm:mr-16">
                    <li class="text-sm capitalize leading-normal before:float-left before:pr-2" aria-current="page">Dashboard
                    </li>
                </ol>
            </nav>
            <div class="flex items-center">
                <a mini-sidenav-burger href="javascript:;"
                    class="hidden p-0 text-white transition-all ease-nav-brand text-sm xl:block" aria-expanded="false">
                    <div class="w-4.5 overflow-hidden">
                        <i
                            class="ease-soft mb-0.75 relative block h-0.5 translate-x-[5px] rounded-sm bg-white transition-all dark:bg-white"></i>
                        <i
                            class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all dark:bg-white"></i>
                        <i
                            class="ease-soft relative block h-0.5 translate-x-[5px] rounded-sm bg-white transition-all dark:bg-white"></i>
                    </div>
                </a>
            </div>
            @include('navigation.header')
        </div>
    </nav>

    <div class="w-full px-6 mx-auto">
        <div
            class="min-h-75 relative mt-0 flex items-center overflow-hidden rounded-sm bg-[url('../../assets/img/curved-images/curved0.jpg')] bg-cover bg-center p-0">
            <span
                class="absolute inset-y-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-purple-700 to-slate-800 opacity-60"></span>
        </div>
        <div
            class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 -mt-16 overflow-hidden break-words border-0 shadow-blur dark:shadow-soft-dark-xl dark:bg-gray-950 rounded-2xl bg-white/80 bg-clip-border backdrop-blur-2xl backdrop-saturate-200">
            <div class="flex flex-wrap -mx-3">
                <div class="flex-none w-auto max-w-full px-3">
                    <div
                        class="text-base ease-soft-in-out h-19 w-19 relative inline-flex items-center justify-center rounded-xl text-white transition-all duration-200">
                        <img src="{{ auth()->user()->profile_photo_url ? auth()->user()->profile_photo_url : 'https://ui-avatars.com/api/?name=' . auth()->user()->name . '&amp;color=7F9CF5&amp;background=EBF4FF' }}"
                            alt="{{ auth()->user()->name }}" class="w-full shadow-soft-sm rounded-xl">
                    </div>
                </div>
                <div class="flex-none w-auto max-w-full px-3 my-auto">
                    <div class="h-full">
                        <h5 class="mb-1 dark:text-white capitalize">{{ auth()->user()->name }}</h5>
                        <p class="mb-0 font-semibold leading-normal text-sm dark:text-white dark:opacity-60">
                            {{ auth()->user()->person_in_charge }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 lg:w-7/12 xl:w-8/12">

                @includeWhen(auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin',
                    'dashboard.fast-btn',
                    ['status' => 'complete']
                )

                <div class="flex flex-wrap mt-6 -mx-3">
                    <div class="w-full max-w-full px-3 flex-0">
                        <div
                            class="widget-calendar border-black/12.5 shadow-soft-xl dark:bg-gray-950 dark:shadow-soft-dark-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                            <div class="p-4 pb-0 rounded-t-2xl">
                                <h6 class="mb-0 dark:text-white">Calendar</h6>
                                <div class="flex">
                                    <div class="mb-0 font-semibold leading-normal widget-calendar-day text-sm"></div>
                                    <div class="mb-1 font-semibold leading-normal widget-calendar-year text-sm"></div>
                                </div>
                            </div>
                            <div class="flex-auto p-4">
                                <div data-toggle="widget-calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 mt-6 lg:flex-0 shrink-0 lg:mt-0 lg:w-5/12 xl:w-4/12">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 sm:flex-0 shrink-0 sm:w-4/12 lg:w-full">
                        <div
                            class="border-black/12.5 shadow-soft-xl dark:bg-gray-950 dark:shadow-soft-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border p-4">
                            <div>
                                <span
                                    class="absolute rounded-xl r top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 opacity-80"></span>
                                <div class="relative z-10 flex-auto h-full p-4">
                                    <h6 class="mb-4 font-bold text-white">Hey <span
                                            class="capitalize">{{ auth()->user()->name }}</span>!</h6>
                                    <p class="mb-4 text-white dark:opacity-60">Wealth creation is an evolutionarily recent
                                        positive-sum game. It is all about who take the opportunity first.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @includeWhen(auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin',
                        'dashboard.summaries',
                        ['status' => 'complete']
                    )
                </div>
            </div>
        </div>
        @livewire('table-filter-date', ['data' => 'order'])
    </div>

    <div class="w-full p-6 mx-auto">
        @if (auth()->user()->company && auth()->user()->company->lastProjects)
            <section>
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 mr-auto md:flex-0 shrink-0 md:w-8/12">
                        <h5 class="dark:text-white">Lastest Projects</h5>
                    </div>
                </div>
                <div class="flex flex-wrap mt-2 -mx-3 lg:mt-6">
                    @foreach (auth()->user()->company->lastProjects as $project)
                        <a href="{{ route('project.show', $project->id) }}?v=1"
                            class="w-full max-w-full px-3 mb-6 md:flex-0 shrink-0 md:w-6/12 lg:w-3/12">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                                <div class="flex-auto p-4">
                                    <div class="flex">
                                        <div class="my-auto ml-4">
                                            <h6 class="dark:text-white">{{ $project->name }}</h6>
                                        </div>
                                    </div>
                                    <p class="mt-4 leading-normal text-sm">
                                        {!! $project->customer_name ? $project->customer_name : '<br>' !!}<br>{{ $project->customer_address }}</p>
                                    <hr
                                        class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-6/12 max-w-full px-3 flex-0">
                                            <h6 class="mb-0 leading-normal text-sm">{{ $project->status }}</h6>
                                            <p class="mb-0 font-semibold leading-normal text-sm text-slate-400"> </p>
                                        </div>
                                        <div class="w-6/12 max-w-full px-3 text-right flex-0">
                                            <h6 class="mb-0 leading-normal text-sm">
                                                {{ $project->created_at->format('d.m.y') }}</h6>
                                            <p class="mb-0 font-semibold leading-normal text-sm text-slate-400">Created at
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @include('navigation.footer')
    </div>
@endsection

@section('scripts')
    <script src="{{ url('assets/js/fullcalendar.min.js') }}"></script>
    <!-- <script src="{{ url('assets/js/full-calendar.js') }}"></script> -->
    <script>
        if (document.querySelector('[data-toggle="widget-calendar"]')) {
            var calendarEl = document.querySelector('[data-toggle="widget-calendar"]');
            var today = new Date();
            var mYear = today.getFullYear();
            var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var mDay = weekday[today.getDay()];

            var m = today.getMonth();
            var d = today.getDate();
            document.getElementsByClassName("widget-calendar-year")[0].innerHTML = mYear;
            document.getElementsByClassName("widget-calendar-day")[0].innerHTML = mDay;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                contentHeight: "auto",
                initialView: "dayGridMonth",
                selectable: true,
                headerToolbar: false,
                eventClick: function(info) {
                    var eventObj = info.event;

                    if (eventObj.url) {
                        // alert(
                        // 'Clicked ' + eventObj.title + '.\n' +
                        // 'Will open ' + eventObj.url + ' in a new tab'
                        // );

                        window.open(eventObj.url);
                        info.jsEvent.preventDefault(); // prevents browser from following link in current tab.
                    } else {
                        alert('Clicked ' + eventObj.title);
                    }
                },
                events: @json($event)
            });
            calendar.render();
        }
    </script>
@endsection

<!-- // events: [
//     {
//         title: "Call with Dave",
//         start: "2022-12-18",
//         end: "2022-12-18",
//         className: "bg-gradient-to-tl from-red-600 to-rose-400",
//         url: 'https://www.google.com/',
//     },
//     {
//         title: "Lunch meeting",
//         start: "2022-12-21",
//         end: "2022-12-22",
//         className: "bg-gradient-to-tl from-red-500 to-yellow-400",
//     },
//     {
//         title: "All day conference",
//         start: "2022-12-29",
//         end: "2022-12-29",
//         className: "bg-gradient-to-tl from-green-600 to-lime-400",
//     }"{!! json_encode($event) !!}"
// ], -->
