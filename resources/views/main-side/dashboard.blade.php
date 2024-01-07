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
<nav class="absolute z-20 flex flex-wrap items-center justify-between w-full px-6 py-2 text-white transition-all shadow-none duration-250 ease-soft-in lg:flex-nowrap lg:justify-start" navbar-profile navbar-scroll="true">
    <div class="flex items-center justify-between w-full px-6 py-1 mx-auto flex-wrap-inherit">
        <nav>
            <ol class="flex flex-wrap pt-1 pl-2 pr-4 mr-12 bg-transparent rounded-lg sm:mr-16">
                <li class="text-sm capitalize leading-normal before:float-left before:pr-2" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        <div class="flex items-center">
            <a mini-sidenav-burger href="javascript:;" class="hidden p-0 text-white transition-all ease-nav-brand text-sm xl:block" aria-expanded="false">
                <div class="w-4.5 overflow-hidden">
                    <i class="ease-soft mb-0.75 relative block h-0.5 translate-x-[5px] rounded-sm bg-white transition-all dark:bg-white"></i>
                    <i class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all dark:bg-white"></i>
                    <i class="ease-soft relative block h-0.5 translate-x-[5px] rounded-sm bg-white transition-all dark:bg-white"></i>
                </div>
            </a>
        </div>
        @include('navigation.header')
    </div>
</nav>

<div class="w-full px-6 mx-auto">
    <div class="min-h-75 relative mt-0 flex items-center overflow-hidden rounded-sm bg-[url('../../assets/img/curved-images/curved0.jpg')] bg-cover bg-center p-0">
        <span class="absolute inset-y-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-purple-700 to-slate-800 opacity-60"></span>
    </div>
    <div class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 -mt-16 overflow-hidden break-words border-0 shadow-blur dark:shadow-soft-dark-xl dark:bg-gray-950 rounded-2xl bg-white/80 bg-clip-border backdrop-blur-2xl backdrop-saturate-200">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-auto max-w-full px-3">
                <div class="text-base ease-soft-in-out h-19 w-19 relative inline-flex items-center justify-center rounded-xl text-white transition-all duration-200">
                    <img src="{{auth()->user()->profile_photo_url?auth()->user()->profile_photo_url:'https://ui-avatars.com/api/?name='.auth()->user()->name.'&amp;color=7F9CF5&amp;background=EBF4FF'}}" alt="{{auth()->user()->name}}" class="w-full shadow-soft-sm rounded-xl">
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1 dark:text-white capitalize">{{auth()->user()->name}}</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm dark:text-white dark:opacity-60">{{auth()->user()->person_in_charge}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full p-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 lg:w-7/12 xl:w-8/12">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mt-6 sm:flex-0 shrink-0 sm:mt-0 sm:w-6/12">
                    <div class="relative flex flex-col h-full min-w-0 break-words bg-white border border-solid dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl border-slate-100 bg-clip-border dark:border-slate-700">
                        <div class="flex flex-col justify-center flex-auto p-6 text-center">
                            <a href="{{ route('user.index') }}?v=1">
                                <i class="mb-1 leading-normal fa fa-plus text-sm text-slate-400 dark:text-white dark:opacity-80" aria-hidden="true"> </i>
                                <h6 class="text-slate-400 dark:text-white dark:opacity-80">New Client</h6>
                            </a>
                            <!-- <div class="text-slate-400 dark:text-white dark:opacity-80 text-md font-semibold cursor-pointer">
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mt-6 sm:flex-0 shrink-0 sm:mt-0 sm:w-6/12">
                    <div class="relative flex flex-col h-full min-w-0 break-words bg-white border border-solid dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl border-slate-100 bg-clip-border dark:border-slate-700">
                        <div class="flex flex-col justify-center flex-auto p-6 text-center">
                            <a href="{{ route('project') }}?v=1">
                                <i class="mb-1 leading-normal fa fa-plus text-sm text-slate-400 dark:text-white dark:opacity-80" aria-hidden="true"> </i>
                                <h6 class="text-slate-400 dark:text-white dark:opacity-80">New Project</h6>
                            </a>
                            <!-- <div class="text-slate-400 dark:text-white dark:opacity-80 text-md font-semibold cursor-pointer hover:text-black">
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- <div class="w-full max-w-full px-3 mt-6 sm:flex-0 shrink-0 sm:mt-0 sm:w-4/12">
                    <div class="relative flex flex-col h-full min-w-0 break-words bg-white border border-solid dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl border-slate-100 bg-clip-border dark:border-slate-700">
                        <div class="flex flex-col justify-center flex-auto p-6 text-center ">
                            <a href="javascript:;">
                                <i class="mb-1 leading-normal fa fa-plus text-sm text-slate-400 dark:text-white dark:opacity-80" aria-hidden="true"> </i>
                                <h6 class="text-slate-400 dark:text-white dark:opacity-80">New Client</h6>
                            </a>
                            <a href="javascript:;" class="hover:text-black">
                                <div class="text-slate-400 dark:text-white dark:opacity-80 text-md font-semibold cursor-pointer">New Billing</div>
                            </a>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="flex flex-wrap mt-6 -mx-3">
                <div class="w-full max-w-full px-3 flex-0">
                    <div class="widget-calendar border-black/12.5 shadow-soft-xl dark:bg-gray-950 dark:shadow-soft-dark-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
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
                    <div class="border-black/12.5 shadow-soft-xl dark:bg-gray-950 dark:shadow-soft-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border p-4">
                        <div>
                            <span class="absolute rounded-xl r top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 opacity-80"></span>
                            <div class="relative z-10 flex-auto h-full p-4">
                                <h6 class="mb-4 font-bold text-white">Hey <span class="capitalize">{{auth()->user()->name}}</span>!</h6>
                                <p class="mb-4 text-white dark:opacity-60">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 sm:flex-0 shrink-0 sm:w-6/12 lg:w-full">
                    <div class="border-black/12.5 shadow-soft-xl dark:bg-gray-950 dark:shadow-soft-dark-xl relative mt-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                        <div class="p-4 pb-0 rounded-t-4">
                            <h6 class="mb-0 dark:text-white">Summaries</h6>
                        </div>
                        <div class="flex-auto p-4">
                            <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                                <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-lg rounded-xl text-inherit">
                                    <div class="flex items-center">
                                        <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center fill-current stroke-none shadow-soft-2xl bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 rounded-xl">
                                            <svg width="12px" height="12px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="mt-1">
                                                <title>spaceship</title>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-1720.000000, -592.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                        <g transform="translate(1716.000000, 291.000000)">
                                                            <g transform="translate(4.000000, 301.000000)">
                                                                <path d="M39.3,0.706666667 C38.9660984,0.370464027 38.5048767,0.192278529 38.0316667,0.216666667 C14.6516667,1.43666667 6.015,22.2633333 5.93166667,22.4733333 C5.68236407,23.0926189 5.82664679,23.8009159 6.29833333,24.2733333 L15.7266667,33.7016667 C16.2013871,34.1756798 16.9140329,34.3188658 17.535,34.065 C17.7433333,33.98 38.4583333,25.2466667 39.7816667,1.97666667 C39.8087196,1.50414529 39.6335979,1.04240574 39.3,0.706666667 Z M25.69,19.0233333 C24.7367525,19.9768687 23.3029475,20.2622391 22.0572426,19.7463614 C20.8115377,19.2304837 19.9992882,18.0149658 19.9992882,16.6666667 C19.9992882,15.3183676 20.8115377,14.1028496 22.0572426,13.5869719 C23.3029475,13.0710943 24.7367525,13.3564646 25.69,14.31 C26.9912731,15.6116662 26.9912731,17.7216672 25.69,19.0233333 L25.69,19.0233333 Z"></path>
                                                                <path d="M1.855,31.4066667 C3.05106558,30.2024182 4.79973884,29.7296005 6.43969145,30.1670277 C8.07964407,30.6044549 9.36054508,31.8853559 9.7979723,33.5253085 C10.2353995,35.1652612 9.76258177,36.9139344 8.55833333,38.11 C6.70666667,39.9616667 0,40 0,40 C0,40 0,33.2566667 1.855,31.4066667 Z"></path>
                                                                <path d="M17.2616667,3.90166667 C12.4943643,3.07192755 7.62174065,4.61673894 4.20333333,8.04166667 C3.31200265,8.94126033 2.53706177,9.94913142 1.89666667,11.0416667 C1.5109569,11.6966059 1.61721591,12.5295394 2.155,13.0666667 L5.47,16.3833333 C8.55036617,11.4946947 12.5559074,7.25476565 17.2616667,3.90166667 L17.2616667,3.90166667 Z" opacity="0.598539807"></path>
                                                                <path d="M36.0983333,22.7383333 C36.9280725,27.5056357 35.3832611,32.3782594 31.9583333,35.7966667 C31.0587397,36.6879974 30.0508686,37.4629382 28.9583333,38.1033333 C28.3033941,38.4890431 27.4704606,38.3827841 26.9333333,37.845 L23.6166667,34.53 C28.5053053,31.4496338 32.7452344,27.4440926 36.0983333,22.7383333 L36.0983333,22.7383333 Z" opacity="0.598539807"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">Clients</h6>
                                            <span class="leading-tight text-xs">{{$stat['client']}} client, <span class="font-semibold">46 reseller</span></span>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <button class="group ease-soft-in leading-pro text-xs rounded-3.5xl p-1.2 h-6 w-6 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white"><i class="ni ease-bounce text-3xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                                <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-xl text-inherit">
                                    <div class="flex items-center">
                                        <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center fill-current stroke-none shadow-soft-2xl bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 rounded-xl">
                                            <svg width="12px" height="12px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="mt-1">
                                                <title>settings</title>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                        <g transform="translate(1716.000000, 291.000000)">
                                                            <g transform="translate(304.000000, 151.000000)">
                                                                <polygon opacity="0.596981957" points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"></polygon>
                                                                <path d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z" opacity="0.596981957"></path>
                                                                <path d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">Projects</h6>
                                            <span class="leading-tight text-xs">{{$stat['project']}} closed, <span class="font-semibold">15 open</span></span>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <button class="group ease-soft-in leading-pro text-xs rounded-3.5xl p-1.2 h-6 w-6 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white"><i class="ni ease-bounce text-3xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                                <li class="relative flex justify-between py-2 pr-4 border-0 rounded-b-lg rounded-xl text-inherit">
                                    <div class="flex items-center">
                                        <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center fill-current stroke-none shadow-soft-2xl bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 rounded-xl">
                                            <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="mt-1">
                                                <title>box-3d-50</title>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                        <g transform="translate(1716.000000, 291.000000)">
                                                            <g transform="translate(603.000000, 0.000000)">
                                                                <path d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z"></path>
                                                                <path d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z" opacity="0.7"></path>
                                                                <path d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z" opacity="0.7"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">Orders</h6>
                                            <span class="leading-tight text-xs">{{$stat['order']}} is active, <span class="font-semibold">40 closed</span></span>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <button class="group ease-soft-in leading-pro text-xs rounded-3.5xl p-1.2 h-6 w-6 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white"><i class="ni ease-bounce text-3xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                                <li class="relative flex justify-between py-2 pr-4 border-0 rounded-b-lg rounded-xl text-inherit">
                                    <div class="flex items-center">
                                        <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center fill-current stroke-none shadow-soft-2xl bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 rounded-xl">
                                            <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="mt-1">
                                                <title>box-3d-50</title>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                        <g transform="translate(1716.000000, 291.000000)">
                                                            <g transform="translate(603.000000, 0.000000)">
                                                                <path d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z"></path>
                                                                <path d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z" opacity="0.7"></path>
                                                                <path d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z" opacity="0.7"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">Products</h6>
                                            <span class="leading-tight text-xs">{{$stat['product']}} in stock, <span class="font-semibold">346+ sold</span></span>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <button class="group ease-soft-in leading-pro text-xs rounded-3.5xl p-1.2 h-6 w-6 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white"><i class="ni ease-bounce text-3xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 sm:flex-0 shrink-0 sm:w-6/12 lg:w-full">
                    <div class="border-black/12.5 shadow-soft-xl dark:bg-gray-950 dark:shadow-soft-dark-xl relative mt-6 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-8/12 max-w-full px-3 my-auto flex-0">
                                    <p class="font-semibold leading-normal text-sm text-slate-500 dark:text-white dark:opacity-60">Unread message from Martina.</p>
                                </div>
                                <div class="w-4/12 max-w-full px-3 flex-0">
                                    <a class="inline-block px-8 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 hover:shadow-soft-xs active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25" href="javascript:;">Reply</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('table-filter-date', ['data'=>'order'])
</div>

<div class="w-full p-6 mx-auto">
    @if(auth()->user()->company && auth()->user()->company->lastProjects)
        <section>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mr-auto md:flex-0 shrink-0 md:w-8/12">
                    <h5 class="dark:text-white">Lastest Projects</h5>
                </div>
            </div>
            <div class="flex flex-wrap mt-2 -mx-3 lg:mt-6">
                @foreach(auth()->user()->company->lastProjects as $project)
                    <a href="{{route('project.show', $project->id)}}?v=1" class="w-full max-w-full px-3 mb-6 md:flex-0 shrink-0 md:w-6/12 lg:w-3/12">
                        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex">
                                    <div class="my-auto ml-4">
                                        <h6 class="dark:text-white">{{$project->name}}</h6>
                                    </div>
                                </div>
                                <p class="mt-4 leading-normal text-sm">{!!$project->customer_name?$project->customer_name:'<br>'!!}<br>{{$project->customer_address}}</p>
                                <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-6/12 max-w-full px-3 flex-0">
                                        <h6 class="mb-0 leading-normal text-sm">{{$project->status}}</h6>
                                        <p class="mb-0 font-semibold leading-normal text-sm text-slate-400"> </p>
                                    </div>
                                    <div class="w-6/12 max-w-full px-3 text-right flex-0">
                                        <h6 class="mb-0 leading-normal text-sm">{{$project->created_at->format('d.m.y')}}</h6>
                                        <p class="mb-0 font-semibold leading-normal text-sm text-slate-400">Created at</p>
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
