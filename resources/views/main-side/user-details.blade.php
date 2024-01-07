@extends('layouts.side-menu')

@section('title', 'Users')

@section('header')

@endsection

@section('sidebar')
@parent
@endsection

@section('content')
<nav navbar-main=""
    class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 mt-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start"
    navbar-scroll="true">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        <nav>
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                <li class="leading-normal text-sm breadcrumb-item">
                    <a class="text-slate-700 opacity-30 dark:text-white" href="{{ route('dashboard') }}?v=1">
                        <svg width="12px" height="12px" class="mb-1" viewBox="0 0 45 40" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>Dashboard</title>
                            <g class="dark:fill-white" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g class="dark:fill-white" transform="translate(-1716.000000, -439.000000)"
                                    fill="#252f40" fill-rule="nonzero">
                                    <g class="dark:fill-white" transform="translate(1716.000000, 291.000000)">
                                        <g class="dark:fill-white" transform="translate(0.000000, 148.000000)">
                                            <path
                                                d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z">
                                            </path>
                                            <path
                                                d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a>
                </li>
                <!-- <li class="text-sm pl-2 leading-normal before:float-left before:pr-2 before:text-gray-600 before:content-['/']">
                    <a class="opacity-50 text-slate-700 dark:text-white" href="javascript:;">Pages</a>
                </li> -->
                <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/'] dark:text-white dark:before:text-white"
                    aria-current="page">User</li>
            </ol>
            <h6 class="mb-0 font-bold capitalize dark:text-white">Details</h6>
        </nav>
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
                    <img src="{{$user->profile_photo_url?$user->profile_photo_url:'https://ui-avatars.com/api/?name='.$user->name.'&amp;color=7F9CF5&amp;background=EBF4FF'}}"
                        alt="{{$user->name}}" class="w-full shadow-soft-sm rounded-xl">
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1 dark:text-white">{{$user->name}}</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm dark:text-white dark:opacity-60">
                        {{$user->person_in_charge}}</p>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mr-0 md:w-1/2 md:flex-none lg:w-4/12">
                <div class="relative right-0">
                    <ul class="relative flex p-1 list-none bg-transparent rounded-xl" role="list">
                        <li class="z-30 flex-auto text-center">
                            <a class="{{app('request')->has('display')?'':'dark:text-white border'}} border-current z-30 block w-full px-1 py-1 mb-0 transition-all rounded-lg ease-soft-in-out bg-inherit text-slate-700"
                                nav-link active href="{{route('user.show', $user->id)}}?v=1" role="tab"
                                aria-selected="true">
                                <svg class="text-slate-700" width="16px" height="16px" viewBox="0 0 42 42" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(603.000000, 0.000000)">
                                                    <path
                                                        class="fill-slate-800 {{app('request')->has('display') != 'billing'?'dark:fill-white':''}}"
                                                        d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z">
                                                    </path>
                                                    <path
                                                        class="fill-slate-800 {{app('request')->has('display') != 'billing'?'dark:fill-white':''}}"
                                                        d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z"
                                                        opacity="0.7"></path>
                                                    <path
                                                        class="fill-slate-800 {{app('request')->has('display') != 'billing'?'dark:fill-white':''}}"
                                                        d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z"
                                                        opacity="0.7"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <span class="ml-1 text-sx">Profile</span>
                            </a>
                        </li>
                        @if($user->company)
                        <li class="z-30 flex-auto text-center">
                            <a class="{{app('request')->input('display') == 'company'?'dark:text-white border':''}} border-current z-30 block w-full px-1 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700"
                                nav-link href="{{route('user.show', $user->id)}}?v=1&display=company" role="tab"
                                aria-selected="false">
                                <svg width="14px" height="14px" viewBox="0 0 45 40" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>dashboard</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(0.000000, 148.000000)">
                                                    <path
                                                        class="fill-slate-800 {{app('request')->input('display') == 'company'?'dark:fill-white':''}}"
                                                        d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"
                                                        opacity="0.598981585"></path>
                                                    <path
                                                        class="fill-slate-800 {{app('request')->input('display') == 'company'?'dark:fill-white':''}}"
                                                        d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <span class="ml-1 text-sx">Company</span>
                            </a>
                        </li>
                        <li class="z-30 flex-auto text-center">
                            <a class="{{app('request')->input('display') == 'billing'?'dark:text-white border':''}} border-current z-30 block w-full px-1 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700"
                                nav-link href="{{route('user.show', $user->id)}}?v=1&display=billing" role="tab"
                                aria-selected="false">
                                <svg class="text-slate-700" width="16px" height="16px" viewBox="0 0 40 44" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>table</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF"
                                            fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(154.000000, 300.000000)">
                                                    <path
                                                        class="fill-slate-800 {{app('request')->input('display') == 'billing'?'dark:fill-white':''}}"
                                                        d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z"
                                                        opacity="0.603585379"></path>
                                                    <path
                                                        class="fill-slate-800 {{app('request')->input('display') == 'billing'?'dark:fill-white':''}}"
                                                        d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <span class="ml-1 text-sx">Billing</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="w-full p-6 mx-auto pt-0">
    <div class="flex flex-wrap -mx-3">
        @if(app('request')->input('display') == 'company')
        <div class="w-full p-6 mx-auto">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mt-6 flex-0 lg:mt-0 lg:w-4/12">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                        <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-4 pb-0">
                            <div class="flex flex-wrap -mx-3">
                                <div class="flex w-8/12 max-w-full px-3 flex-0">
                                    <div>
                                        @if($user->company && $user->company->img_logo)
                                            <img src="https://telixcel.s3.ap-southeast-1.amazonaws.com/{{$user->company->img_logo->file}}" class="inline-flex items-center justify-center mr-2 text-white transition-all duration-200 text-sm ease-soft-in-out w-auto h-10 rounded-sm">
                                        @endif
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-0 leading-normal text-sm dark:text-white">{{$user->company->name}}</h6>
                                        <!-- <p class="leading-tight text-xs dark:text-white/60">2h ago</p> -->
                                    </div>
                                </div>
                                <!-- <div class="w-4/12 max-w-full px-3 flex-0">
                                    <span
                                        class="bg-gradient-to-tl from-blue-600 to-cyan-400 py-2.2 px-3.6 text-xs rounded-1.8 float-right ml-auto inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Recommendation</span>
                                </div> -->
                            </div>
                        </div>
                        <div class="flex-auto p-4 pt-1">
                            <h6 class="dark:text-white">{{$user->company->name}}</h6>
                            <p class="leading-normal text-sm dark:text-white/60">Tech company who provide tool to assist Project Management and Billing.</p>
                            <!-- <div class="flex p-4 rounded-xl bg-gray-50 dark:bg-gray-600">
                                <h4 class="my-auto dark:text-white"><span
                                        class="mr-1 leading-normal text-sm text-slate-400 dark:text-white/80">$</span>3,000<span
                                        class="ml-1 leading-normal text-sm text-slate-400 dark:text-white/80">/ month
                                    </span></h4>
                                <a href="javascript:;"
                                    class="inline-block px-6 py-3 mb-0 ml-auto font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in tracking-tight-soft active:opacity-85 active:shadow-soft-xs hover:scale-102 border-slate-700 text-slate-700 hover:border-slate-700 hover:bg-transparent hover:opacity-75 active:border-slate-700 active:bg-slate-700 active:text-white">APPLY</a>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 flex-0 lg:w-8/12">
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full max-w-full px-3 mt-6 flex-0 md:w-6/12 lg:mt-0 lg:w-4/12">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                                <div class="flex-auto p-4">
                                    <div class="flex">
                                        <div>
                                            <div
                                                class="inline-block w-12 h-12 text-center text-black bg-center rounded-lg fill-current bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 stroke-none">
                                                <i class="ni leading-none fa fa-user text-lg relative top-3.5 text-white opacity-100"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div>
                                                <p
                                                    class="mb-0 font-semibold leading-normal capitalize text-sm dark:text-white/60">
                                                    today's users</p>
                                                <h5 class="mb-0 font-bold dark:text-white">
                                                    2,300
                                                    <span
                                                        class="font-bold leading-normal text-sm text-lime-500">+3%</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                                <div class="flex-auto p-4">
                                    <div class="flex">
                                        <div>
                                            <div
                                                class="inline-block w-12 h-12 text-center text-black bg-center rounded-lg fill-current bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 stroke-none">
                                                <i
                                                    class="ni leading-none fa fa-sign text-lg relative top-3.5 text-white opacity-100"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div>
                                                <p
                                                    class="mb-0 font-semibold leading-normal capitalize text-sm dark:text-white/60">
                                                    sign-ups</p>
                                                <h5 class="mb-0 font-bold dark:text-white">
                                                    348
                                                    <span
                                                        class="font-bold leading-normal text-sm text-lime-500">+12%</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full max-w-full px-3 mt-6 flex-0 md:w-6/12 lg:mt-0 lg:w-4/12">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                                <div class="flex-auto p-4">
                                    <div class="flex">
                                        <div>
                                            <div
                                                class="inline-block w-12 h-12 text-center text-black bg-center rounded-lg fill-current bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 stroke-none">
                                                <i class="ni leading-none fa fa-money text-lg relative top-3.5 text-white opacity-100"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div>
                                                <p
                                                    class="mb-0 font-semibold leading-normal capitalize text-sm dark:text-white/60">
                                                    Today's money</p>
                                                <h5 class="mb-0 font-bold dark:text-white">Rp53,000</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                                <div class="flex-auto p-4">
                                    <div class="flex">
                                        <div>
                                            <div
                                                class="inline-block w-12 h-12 text-center text-black bg-center rounded-lg fill-current bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 stroke-none">
                                                <i class="ni leading-none fa fa-clock text-lg relative top-3.5 text-white opacity-100"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div>
                                                <p
                                                    class="mb-0 font-semibold leading-normal capitalize text-sm dark:text-white/60">
                                                    Sessions</p>
                                                <h5 class="mb-0 font-bold dark:text-white">
                                                    9,600
                                                    <span
                                                        class="font-bold leading-normal text-sm text-lime-500">+15%</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full max-w-full px-3 flex-0 lg:w-4/12">
                            <div data-tilt=""
                                class="after:bg-gradient-to-tl after:from-blue-600 after:to-cyan-400 after:opacity-85 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl after:z-1 relative flex h-full min-w-0 flex-col items-center break-words rounded-2xl border-0 bg-white bg-clip-border after:absolute after:top-0 after:left-0 after:block after:h-full after:w-full after:rounded-2xl after:bg-black/40 after:content-['']"
                                style="transform-style: preserve-3d; will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1);">
                                <div class="mb-7 absolute h-full w-full rounded-2xl"></div>
                                <div class="relative flex-auto p-3 text-center text-white z-2">
                                    <h2
                                        class="mt-2 mb-0 text-white transition-all duration-500 [transform:scale(.7)_translateZ(50px)]">
                                        Earnings</h2>
                                    <h1
                                        class="mb-0 text-white transition-all duration-500 [transform:scale(.7)_translateZ(50px)]">
                                        Rp15,800</h1>
                                    <!-- <span
                                        class="py-3.4 px-5.5 text-xs rounded-1.8 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 bg-gradient-to-tl from-gray-900 to-slate-800 mb-2 block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white transition-all duration-500 [transform:scale(.7)_translateZ(50px)]">+15%
                                        since last week</span> -->
                                    <a href="javascript:;"
                                        class="leading-pro text-xs ease-soft-in tracking-tight-soft active:opacity-85 active:shadow-soft-xs mb-2 inline-block cursor-pointer rounded-lg border border-solid border-white/75 bg-white/10 px-12 py-3 text-center align-middle font-bold uppercase text-white shadow-none transition-all duration-500 [transform:scale(.7)_translateZ(50px)] hover:border-white hover:bg-transparent hover:opacity-75 active:border-white active:bg-white active:text-black">View
                                        more</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="flex flex-wrap mt-6 -mx-3">
                <div class="w-full max-w-full px-3 flex-0 lg:w-8/12">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                        <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-4">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full max-w-full px-3 md:flex-0 shrink-0 md:w-6/12">
                                    <h6 class="mb-0 dark:text-white">To do list</h6>
                                </div>
                                <div
                                    class="flex items-center justify-end w-full max-w-full px-3 md:flex-0 shrink-0 md:w-6/12">
                                    <small>23 - 30 March 2020</small>
                                </div>
                            </div>
                            <hr
                                class="h-px mx-0 my-4 mb-0 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent">
                        </div>
                        <div class="flex-auto p-4 pt-0">
                            <ul class="flex flex-col pl-0 mb-0 rounded-none">
                                <li
                                    class="border-black/12.5 rounded-t-inherit relative mb-4 block flex-col items-center border-0 border-solid px-4 py-0 pl-0 text-inherit">
                                    <div
                                        class="before:w-0.75 before:rounded-1 ml-4 pl-2 before:absolute before:top-0 before:left-0 before:h-full before:bg-fuchsia-500 before:content-['']">
                                        <div class="flex items-center">
                                            <div class="min-h-6 pl-7 mb-0.5 block">
                                                <input
                                                    class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-[0.67rem] after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                    type="checkbox">
                                            </div>
                                            <h6
                                                class="mb-0 font-semibold leading-normal text-sm text-slate-700 dark:text-white">
                                                Check status</h6>
                                            <div class="relative pr-0 ml-auto lg:float-right">
                                                <a href="javascript:;" class="cursor-pointer" dropdown-trigger=""
                                                    aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h text-slate-400 dark:text-white/80"
                                                        aria-hidden="true"></i>
                                                </a>
                                                <p class="hidden transform-dropdown-show"></p>
                                                <ul dropdown-menu=""
                                                    class="dark:shadow-soft-dark-xl z-100 dark:bg-gray-950 text-sm lg:shadow-soft-3xl duration-250 min-w-44 right-5.5 absolute -top-12 left-auto m-0 mt-2 -ml-12 list-none rounded-lg border-0 border-solid border-transparent bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 transition-all sm:-ml-6 opacity-0 pointer-events-none transform-dropdown">
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Action</a>
                                                    </li>
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Something else here</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="flex items-center pl-1 mt-4 ml-6">
                                            <div>
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Date</p>
                                                <span class="font-bold leading-tight text-xs">24 March 2019</span>
                                            </div>
                                            <div class="ml-auto">
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Project</p>
                                                <span class="font-bold leading-tight text-xs">2414_VR4sf3#</span>
                                            </div>
                                            <div class="mx-auto">
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Company</p>
                                                <span class="font-bold leading-tight text-xs">Creative Tim</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr
                                        class="h-px mx-0 my-6 mb-0 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent">
                                </li>
                                <li
                                    class="border-black/12.5 rounded-t-inherit relative mb-4 block flex-col items-center border-0 border-solid px-4 py-0 pl-0 text-inherit">
                                    <div
                                        class="before:w-0.75 before:rounded-1 ml-4 pl-2 before:absolute before:top-0 before:left-0 before:h-full before:bg-slate-700 before:content-['']">
                                        <div class="flex items-center">
                                            <div class="min-h-6 pl-7 mb-0.5 block">
                                                <input
                                                    class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                    type="checkbox" checked="">
                                            </div>
                                            <h6
                                                class="mb-0 font-semibold leading-normal text-sm text-slate-700 dark:text-white">
                                                Management discussion</h6>
                                            <div class="relative pr-0 ml-auto lg:float-right">
                                                <a href="javascript:;" class="cursor-pointer" dropdown-trigger=""
                                                    aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h text-slate-400 dark:text-white/80"
                                                        aria-hidden="true"></i>
                                                </a>
                                                <p class="hidden transform-dropdown-show"></p>
                                                <ul dropdown-menu=""
                                                    class="dark:shadow-soft-dark-xl z-100 dark:bg-gray-950 text-sm lg:shadow-soft-3xl duration-250 min-w-44 right-5.5 absolute -top-12 left-auto m-0 mt-2 -ml-12 list-none rounded-lg border-0 border-solid border-transparent bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 transition-all sm:-ml-6 opacity-0 pointer-events-none transform-dropdown">
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Action</a>
                                                    </li>
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Something else here</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="flex items-center pl-1 mt-4 ml-6">
                                            <div>
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Date</p>
                                                <span class="font-bold leading-tight text-xs">24 March 2019</span>
                                            </div>
                                            <div class="ml-auto">
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Project</p>
                                                <span class="font-bold leading-tight text-xs">4411_8sIsdd23</span>
                                            </div>
                                            <div class="mx-auto">
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Company</p>
                                                <span class="font-bold leading-tight text-xs">Apple</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr
                                        class="h-px mx-0 my-6 mb-0 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent">
                                </li>
                                <li
                                    class="border-black/12.5 rounded-t-inherit relative mb-4 block flex-col items-center border-0 border-solid px-4 py-0 pl-0 text-inherit">
                                    <div
                                        class="before:w-0.75 before:rounded-1 ml-4 pl-2 before:absolute before:top-0 before:left-0 before:h-full before:bg-yellow-400 before:content-['']">
                                        <div class="flex items-center">
                                            <div class="min-h-6 pl-7 mb-0.5 block">
                                                <input
                                                    class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                    type="checkbox" checked="">
                                            </div>
                                            <h6
                                                class="mb-0 font-semibold leading-normal text-sm text-slate-700 dark:text-white">
                                                New channel distribution</h6>
                                            <div class="relative pr-0 ml-auto lg:float-right">
                                                <a href="javascript:;" class="cursor-pointer" dropdown-trigger=""
                                                    aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h text-slate-400 dark:text-white/80"
                                                        aria-hidden="true"></i>
                                                </a>
                                                <p class="hidden transform-dropdown-show"></p>
                                                <ul dropdown-menu=""
                                                    class="dark:shadow-soft-dark-xl z-100 dark:bg-gray-950 text-sm lg:shadow-soft-3xl duration-250 min-w-44 transform-dropdown right-5.5 pointer-events-none absolute -top-12 left-auto m-0 mt-2 -ml-12 list-none rounded-lg border-0 border-solid border-transparent bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all sm:-ml-6">
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Action</a>
                                                    </li>
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Something else here</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="flex items-center pl-1 mt-4 ml-6">
                                            <div>
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Date</p>
                                                <span class="font-bold leading-tight text-xs">25 March 2019</span>
                                            </div>
                                            <div class="ml-auto">
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Project</p>
                                                <span class="font-bold leading-tight text-xs">827d_kdl33D1s</span>
                                            </div>
                                            <div class="mx-auto">
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Company</p>
                                                <span class="font-bold leading-tight text-xs">Slack</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr
                                        class="h-px mx-0 my-6 mb-0 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent">
                                </li>
                                <li
                                    class="border-black/12.5 rounded-t-inherit relative mb-4 block flex-col items-center border-0 border-solid px-4 py-0 pl-0 text-inherit">
                                    <div
                                        class="before:w-0.75 before:rounded-1 ml-4 pl-2 before:absolute before:top-0 before:left-0 before:h-full before:bg-lime-500 before:content-['']">
                                        <div class="flex items-center">
                                            <div class="min-h-6 pl-7 mb-0.5 block">
                                                <input
                                                    class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                    type="checkbox">
                                            </div>
                                            <h6
                                                class="mb-0 font-semibold leading-normal text-sm text-slate-700 dark:text-white">
                                                IOS App development</h6>
                                            <div class="relative pr-0 ml-auto lg:float-right">
                                                <a href="javascript:;" class="cursor-pointer" dropdown-trigger=""
                                                    aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h text-slate-400 dark:text-white/80"
                                                        aria-hidden="true"></i>
                                                </a>
                                                <p class="hidden transform-dropdown-show"></p>
                                                <ul dropdown-menu=""
                                                    class="dark:shadow-soft-dark-xl z-100 dark:bg-gray-950 text-sm lg:shadow-soft-3xl duration-250 min-w-44 transform-dropdown right-5.5 pointer-events-none absolute -top-12 left-auto m-0 mt-2 -ml-12 list-none rounded-lg border-0 border-solid border-transparent bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all sm:-ml-6">
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Action</a>
                                                    </li>
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Another action</a>
                                                    </li>
                                                    <li>
                                                        <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300"
                                                            href="javascript:;">Something else here</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="flex items-center pl-1 mt-4 ml-6">
                                            <div>
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Date</p>
                                                <span class="font-bold leading-tight text-xs">26 March 2019</span>
                                            </div>
                                            <div class="ml-auto">
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Project</p>
                                                <span class="font-bold leading-tight text-xs">88s1_349DA2sa</span>
                                            </div>
                                            <div class="mx-auto">
                                                <p
                                                    class="mb-0 font-semibold leading-tight text-xs text-slate-400 dark:text-white/80">
                                                    Company</p>
                                                <span class="font-bold leading-tight text-xs">Facebook</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mt-6 flex-0 lg:mt-0 lg:w-4/12">
                    <div class="relative flex flex-col min-w-0 overflow-hidden break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                        <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-4">
                            <div class="flex items-center">
                                <div
                                    class="inline-block w-12 h-12 text-center text-black bg-center rounded-lg fill-current bg-gradient-to-tl from-blue-600 to-cyan-400 stroke-none shadow-soft-2xl">
                                    <i
                                        class="ni leading-none fa fa-calendar text-lg relative top-3.5 text-white"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="mb-0 font-semibold leading-normal capitalize text-sm">Tasks</p>
                                    <h5 class="mb-0 font-bold dark:text-white">480</h5>
                                </div>
                                <div class="w-1/4 ml-auto">
                                    <div>
                                        <div>
                                            <span class="font-semibold leading-tight text-xs">60%</span>
                                        </div>
                                    </div>
                                    <div class="h-0.75 text-xs flex overflow-visible rounded-lg bg-gray-200">
                                        <div
                                            class="transition-width duration-600 ease-soft rounded-1 -mt-0.4 bg-gradient-to-tl from-blue-600 to-cyan-400 -ml-px flex h-1.5 w-3/5 flex-col justify-center overflow-hidden whitespace-nowrap text-center text-white">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="relative flex flex-col min-w-0 mt-6 overflow-hidden break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 lg:w-5/12">
                                    <div class="flex items-center">
                                        <div
                                            class="inline-block w-12 h-12 text-center text-black bg-center rounded-lg fill-current bg-gradient-to-tl from-blue-600 to-cyan-400 stroke-none shadow-soft-2xl">
                                            <i class="ni leading-none fa fa-send text-lg relative top-3.5 text-white"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="mb-0 font-semibold leading-normal capitalize text-sm">Projects</p>
                                            <h5 class="mb-0 font-bold dark:text-white">115</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-1/4 ml-auto">
                                    <div>
                                        <div>
                                            <span class="font-semibold leading-tight text-xs">60%</span>
                                        </div>
                                    </div>
                                    <div class="h-0.75 text-xs flex overflow-visible rounded-lg bg-gray-200">
                                        <div
                                            class="transition-width duration-600 ease-soft rounded-1 -mt-0.4 bg-gradient-to-tl from-blue-600 to-cyan-400 -ml-px flex h-1.5 w-3/5 flex-col justify-center overflow-hidden whitespace-nowrap text-center text-white">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif(app('request')->input('display') == 'billing')
        <div>
            <div class="w-full p-6 py-4 mx-auto my-4">
                <div class="flex flex-wrap -mx-3">
                    <div class="max-w-full px-3 lg:w-2/3 lg:flex-none">
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 mb-4 xl:mb-0 xl:w-1/2 xl:flex-none">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-transparent border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border">
                                    <div class="relative overflow-hidden rounded-2xl"
                                        style="background-image: url('../../../assets/img/curved-images/curved14.jpg')">
                                        <span
                                            class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 opacity-80"></span>
                                        <div class="relative z-10 flex-auto p-4">
                                            <i class="p-2 text-white fas fa-wifi" aria-hidden="true"></i>
                                            <p class="pb-2 mt-6 mb-12 text-white dark:text-white">
                                                {{$user->company->clientCompany->client->uuid}}
                                            </p>
                                            <div class="flex">
                                                <div class="flex">
                                                    <div class="mr-6">
                                                        <p class="mb-0 leading-normal text-white text-sm opacity-80">
                                                            User Account</p>
                                                        <h6 class="mb-0 text-white dark:text-white capitalize">
                                                            {{$user->name}}</h6>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 leading-normal text-white text-sm opacity-80">
                                                            Expires</p>
                                                        <h6 class="mb-0 text-white dark:text-white">2024</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 xl:w-1/2 xl:flex-none">
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 md:w-full md:flex-none">
                                        <div
                                            class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                                            <div
                                                class="p-4 mx-6 mb-0 text-center border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                                                <div
                                                    class="w-auto h-16 text-center bg-center icon bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl rounded-xl">
                                                    <i class="relative text-white opacity-100 fas fa fa-money text-xl top-31/100"
                                                        aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="flex-auto p-4 pt-0 text-center">
                                                <h6 class="mb-0 text-center dark:text-white">Balance</h6>
                                                <span class="leading-tight text-xs">@foreach(estimationSaldo() as
                                                    $product)
                                                    <span class="capitalize">{{$product->name}}
                                                        ({{number_format(balance($user)/$product->unit_price)}}
                                                        SMS)</span>
                                                    @endforeach</span>
                                                <hr
                                                    class="h-px my-4 bg-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent">
                                                <h5 class="mb-0 dark:text-white">Rp {{number_format(balance($user))}}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="w-full max-w-full px-3 mt-6 md:mt-0 md:w-1/2 md:flex-none">
                                        <div
                                            class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                                            <div
                                                class="p-4 mx-6 mb-0 text-center border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                                                <div
                                                    class="w-16 h-16 text-center bg-center icon bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl rounded-xl">
                                                    <i class="relative text-white opacity-100 fab fa-paypal text-xl top-31/100"
                                                        aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="flex-auto p-4 pt-0 text-center">
                                                <h6 class="mb-0 text-center dark:text-white">Paypal</h6>
                                                <span class="leading-tight text-xs">Freelance Payment</span>
                                                <hr
                                                    class="h-px my-4 bg-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent">
                                                <h5 class="mb-0 dark:text-white">$455.00</h5>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="max-w-full px-3 mb-4 lg:mb-0 lg:w-full lg:flex-none">
                                <div
                                    class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 border-transparent border-solid dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                                    <div class="p-4 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                                        <div class="flex flex-wrap -mx-3">
                                            <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                                                <h6 class="mb-0 dark:text-white">Topup</h6>
                                            </div>
                                            <div class="flex-none w-1/2 max-w-full px-3 text-right">
                                                <div
                                                    class=" px-6 py-3 font-bold text-center text-white uppercase align-middle bg-transparent rounded-lg cursor-pointer text-xs shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 bg-x-25">
                                                    @livewire('saldo.topup', ['user' => $user])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="max-w-full px-3 mb-4 lg:mb-0 lg:w-full lg:flex-none">
                                <div
                                    class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 border-transparent border-solid dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                                    <div
                                        class="p-4 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                                        <div class="flex flex-wrap -mx-3">
                                            <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                                                <h6 class="mb-0 dark:text-white">Payment Method</h6>
                                            </div>
                                            <div class="flex-none w-1/2 max-w-full px-3 text-right">
                                                <a class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 hover:shadow-soft-xs active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25"
                                                    href="javascript:;"> <i class="fas fa-plus" aria-hidden="true">
                                                    </i>&nbsp;&nbsp;Add New Card</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap -mx-3">
                                            <div class="max-w-full px-3 mb-6 md:mb-0 md:w-1/2 md:flex-none">
                                                <div
                                                    class="relative flex flex-row items-center flex-auto min-w-0 p-6 break-words bg-transparent border border-solid shadow-none rounded-xl border-slate-100 bg-clip-border dark:border-slate-700">
                                                    <img class="mb-0 mr-4 w-1/10"
                                                        src="../../../assets/img/logos/mastercard.png" alt="logo">
                                                    <h6 class="mb-0 dark:text-white">
                                                        ****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;7852
                                                    </h6>
                                                    <i class="ml-auto cursor-pointer fas fa-pencil-alt text-slate-700"
                                                        data-target="tooltip_trigger" aria-hidden="true"></i>
                                                    <div class="hidden px-2 py-1 text-white bg-black rounded-lg text-sm"
                                                        id="tooltip" role="tooltip" data-popper-placement="top"
                                                        style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(636.8px, -206.4px, 0px);">
                                                        Edit Card
                                                        <div class="invisible absolute h-2 w-2 bg-inherit before:visible before:absolute before:h-2 before:w-2 before:rotate-45 before:bg-inherit before:content-['']"
                                                            data-popper-arrow=""
                                                            style="position: absolute; left: 0px; transform: translate3d(0px, 0px, 0px);">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="max-w-full px-3 md:w-1/2 md:flex-none">
                                                <div
                                                    class="relative flex flex-row items-center flex-auto min-w-0 p-6 break-words bg-transparent border border-solid shadow-none rounded-xl border-slate-100 bg-clip-border dark:border-slate-700">
                                                    <img class="mb-0 mr-4 w-1/10"
                                                        src="../../../assets/img/logos/visa.png" alt="logo">
                                                    <h6 class="mb-0 dark:text-white">
                                                        ****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;5248
                                                    </h6>
                                                    <i class="ml-auto cursor-pointer fas fa-pencil-alt text-slate-700"
                                                        data-target="tooltip_trigger" aria-hidden="true"></i>
                                                    <div class="hidden px-2 py-1 text-white bg-black rounded-lg text-sm"
                                                        id="tooltip" role="tooltip" data-popper-placement="top"
                                                        style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(1017.6px, -206.4px, 0px);">
                                                        Edit Card
                                                        <div class="invisible absolute h-2 w-2 bg-inherit before:visible before:absolute before:h-2 before:w-2 before:rotate-45 before:bg-inherit before:content-['']"
                                                            data-popper-arrow=""
                                                            style="position: absolute; left: 0px; transform: translate3d(0px, 0px, 0px);">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 lg:w-1/3 lg:flex-none">
                        <div
                            class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 border-transparent border-solid dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="p-4 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                                <div class="flex flex-wrap -mx-3">
                                    <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                                        <h6 class="mb-0 dark:text-white">Invoices</h6>
                                    </div>
                                    <div class="flex-none w-1/2 max-w-full px-3 text-right">
                                        <button
                                            class="inline-block px-8 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointe leading-pro ease-soft-in text-xs bg-150 active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 border-fuchsia-500 text-fuchsia-500 hover:opacity-75">View
                                            All</button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-auto p-4 pb-0">
                                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                                    <li
                                        class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 rounded-t-inherit text-inherit rounded-xl">
                                        <div class="flex flex-col">
                                            <h6
                                                class="mb-1 font-semibold leading-normal text-sm text-slate-700 dark:text-white">
                                                March, 01, 2020</h6>
                                            <span class="leading-tight text-xs">#MS-415646</span>
                                        </div>
                                        <div class="flex items-center leading-normal text-sm">
                                            $180
                                            <button
                                                class="inline-block px-0 py-3 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer ease-soft-in bg-150 text-sm active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 text-slate-700 dark:text-white"><i
                                                    class="mr-1 fas fa-file-pdf text-lg" aria-hidden="true"></i>
                                                PDF</button>
                                        </div>
                                    </li>
                                    <li
                                        class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 rounded-xl text-inherit">
                                        <div class="flex flex-col">
                                            <h6
                                                class="mb-1 font-semibold leading-normal text-sm text-slate-700 dark:text-white">
                                                February, 10, 2021</h6>
                                            <span class="leading-tight text-xs">#RV-126749</span>
                                        </div>
                                        <div class="flex items-center leading-normal text-sm">
                                            $250
                                            <button
                                                class="inline-block px-0 py-3 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer ease-soft-in bg-150 text-sm active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 text-slate-700 dark:text-white"><i
                                                    class="mr-1 fas fa-file-pdf text-lg" aria-hidden="true"></i>
                                                PDF</button>
                                        </div>
                                    </li>
                                    <li
                                        class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 rounded-xl text-inherit">
                                        <div class="flex flex-col">
                                            <h6
                                                class="mb-1 font-semibold leading-normal text-sm text-slate-700 dark:text-white">
                                                April, 05, 2020</h6>
                                            <span class="leading-tight text-xs">#FB-212562</span>
                                        </div>
                                        <div class="flex items-center leading-normal text-sm">
                                            $560
                                            <button
                                                class="inline-block px-0 py-3 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer ease-soft-in bg-150 text-sm active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 text-slate-700 dark:text-white"><i
                                                    class="mr-1 fas fa-file-pdf text-lg" aria-hidden="true"></i>
                                                PDF</button>
                                        </div>
                                    </li>
                                    <li
                                        class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 rounded-xl text-inherit">
                                        <div class="flex flex-col">
                                            <h6
                                                class="mb-1 font-semibold leading-normal text-sm text-slate-700 dark:text-white">
                                                June, 25, 2019</h6>
                                            <span class="leading-tight text-xs">#QW-103578</span>
                                        </div>
                                        <div class="flex items-center leading-normal text-sm">
                                            $120
                                            <button
                                                class="inline-block px-0 py-3 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer ease-soft-in bg-150 text-sm active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 text-slate-700 dark:text-white"><i
                                                    class="mr-1 fas fa-file-pdf text-lg" aria-hidden="true"></i>
                                                PDF</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 mt-6 md:flex-none">
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="p-6 px-4 pb-0 mb-0 border-b-0 rounded-t-2xl">
                                <h6 class="mb-0 dark:text-white">Billing Information</h6>
                            </div>
                            <div class="flex-auto p-4 pt-6">
                                <livewire:table.balance user="{{$user->id}}" exportable />
                                <!-- <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                                    <li
                                        class="relative flex p-6 mb-2 border-0 rounded-t-inherit rounded-xl bg-gray-50 dark:bg-transparent">
                                        <div class="flex flex-col">
                                            <h6 class="mb-4 leading-normal text-sm dark:text-white">Oliver Liam</h6>
                                            <span class="mb-2 leading-tight text-xs">Company Name: <span
                                                    class="font-semibold text-slate-700 dark:text-white sm:ml-2">Viking
                                                    Burrito</span></span>
                                            <span class="mb-2 leading-tight text-xs">Email Address: <span
                                                    class="font-semibold text-slate-700 dark:text-white sm:ml-2">oliver@burrito.com</span></span>
                                            <span class="leading-tight text-xs">VAT Number: <span
                                                    class="font-semibold text-slate-700 dark:text-white sm:ml-2">FRB1235476</span></span>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <a class="relative z-10 inline-block px-4 py-3 mb-0 font-bold text-center text-transparent uppercase align-middle transition-all border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 active:opacity-85 bg-x-25 bg-clip-text"
                                                href="javascript:;"><i
                                                    class="mr-2 far fa-trash-alt bg-150 bg-gradient-to-tl from-red-600 to-rose-400 bg-x-25 bg-clip-text"
                                                    aria-hidden="true"></i>Delete</a>
                                            <a class="inline-block px-4 py-3 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 hover:scale-102 active:opacity-85 bg-x-25 text-slate-700 dark:text-white"
                                                href="javascript:;"><i class="mr-2 fas fa-pencil-alt text-slate-700"
                                                    aria-hidden="true"></i>Edit</a>
                                        </div>
                                    </li>
                                    <li
                                        class="relative flex p-6 mt-4 mb-2 border-0 rounded-xl bg-gray-50 dark:bg-transparent">
                                        <div class="flex flex-col">
                                            <h6 class="mb-4 leading-normal text-sm dark:text-white">Lucas Harper</h6>
                                            <span class="mb-2 leading-tight text-xs">Company Name: <span
                                                    class="font-semibold text-slate-700 dark:text-white sm:ml-2">Stone
                                                    Tech Zone</span></span>
                                            <span class="mb-2 leading-tight text-xs">Email Address: <span
                                                    class="font-semibold text-slate-700 dark:text-white sm:ml-2">lucas@stone-tech.com</span></span>
                                            <span class="leading-tight text-xs">VAT Number: <span
                                                    class="font-semibold text-slate-700 dark:text-white sm:ml-2">FRB1235476</span></span>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <a class="relative z-10 inline-block px-4 py-3 mb-0 font-bold text-center text-transparent uppercase align-middle transition-all border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 active:opacity-85 bg-x-25 bg-clip-text"
                                                href="javascript:;"><i
                                                    class="mr-2 far fa-trash-alt bg-150 bg-gradient-to-tl from-red-600 to-rose-400 bg-x-25 bg-clip-text"
                                                    aria-hidden="true"></i>Delete</a>
                                            <a class="inline-block px-4 py-3 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 hover:scale-102 active:opacity-85 bg-x-25 text-slate-700 dark:text-white"
                                                href="javascript:;"><i class="mr-2 fas fa-pencil-alt text-slate-700"
                                                    aria-hidden="true"></i>Edit</a>
                                        </div>
                                    </li>
                                    <li
                                        class="relative flex p-6 mt-4 mb-2 border-0 rounded-b-inherit rounded-xl bg-gray-50 dark:bg-transparent">
                                        <div class="flex flex-col">
                                            <h6 class="mb-4 leading-normal text-sm dark:text-white">Ethan James</h6>
                                            <span class="mb-2 leading-tight text-xs">Company Name: <span
                                                    class="font-semibold text-slate-700 dark:text-white sm:ml-2">Fiber
                                                    Notion</span></span>
                                            <span class="mb-2 leading-tight text-xs">Email Address: <span
                                                    class="font-semibold text-slate-700 dark:text-white sm:ml-2">ethan@fiber.com</span></span>
                                            <span class="leading-tight text-xs">VAT Number: <span
                                                    class="font-semibold text-slate-700 dark:text-white sm:ml-2">FRB1235476</span></span>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <a class="relative z-10 inline-block px-4 py-3 mb-0 font-bold text-center text-transparent uppercase align-middle transition-all border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 active:opacity-85 bg-x-25 bg-clip-text"
                                                href="javascript:;"><i
                                                    class="mr-2 far fa-trash-alt bg-150 bg-gradient-to-tl from-red-600 to-rose-400 bg-x-25 bg-clip-text"
                                                    aria-hidden="true"></i>Delete</a>
                                            <a class="inline-block px-4 py-3 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 hover:scale-102 active:opacity-85 bg-x-25 text-slate-700 dark:text-white"
                                                href="javascript:;"><i class="mr-2 fas fa-pencil-alt text-slate-700"
                                                    aria-hidden="true"></i>Edit</a>
                                        </div>
                                    </li>
                                </ul> -->
                            </div>
                        </div>
                    </div>
                    <!-- <div class="w-full max-w-full px-3 mt-6 md:w-5/12 md:flex-none">
                        <div
                            class="relative flex flex-col h-full min-w-0 mb-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="p-6 px-4 pb-0 mb-0 border-b-0 rounded-t-2xl">
                                <div class="flex flex-wrap -mx-3">
                                    <div class="max-w-full px-3 md:w-1/2 md:flex-none">
                                        <h6 class="mb-0 dark:text-white">Your Transactions</h6>
                                    </div>
                                    <div class="flex items-center justify-end max-w-full px-3 md:w-1/2 md:flex-none">
                                        <i class="mr-2 far fa-calendar-alt" aria-hidden="true"></i>
                                        <small>23 - 30 March 2020</small>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-auto p-4 pt-6">
                                <h6 class="mb-4 font-bold leading-tight uppercase text-xs text-slate-500">Newest</h6>
                                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                                    <li
                                        class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 rounded-t-inherit text-inherit rounded-xl">
                                        <div class="flex items-center">
                                            <button
                                                class="leading-pro ease-soft-in text-xs bg-150 w-6 h-6 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-red-600 border-transparent bg-transparent text-center align-middle font-bold uppercase text-red-600 transition-all hover:opacity-75"><i
                                                    class="fas fa-arrow-down text-3xs" aria-hidden="true"></i></button>
                                            <div class="flex flex-col">
                                                <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">
                                                    Netflix</h6>
                                                <span class="leading-tight text-xs">27 March 2020, at 12:30 PM</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center justify-center">
                                            <p
                                                class="relative z-10 inline-block m-0 font-semibold leading-normal text-transparent bg-gradient-to-tl from-red-600 to-rose-400 text-sm bg-clip-text">
                                                - $ 2,500</p>
                                        </div>
                                    </li>
                                    <li
                                        class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 border-t-0 rounded-b-inherit text-inherit rounded-xl">
                                        <div class="flex items-center">
                                            <button
                                                class="leading-pro ease-soft-in text-xs bg-150 w-6 h-6 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-lime-500 border-transparent bg-transparent text-center align-middle font-bold uppercase text-lime-500 transition-all hover:opacity-75"><i
                                                    class="fas fa-arrow-up text-3xs" aria-hidden="true"></i></button>
                                            <div class="flex flex-col">
                                                <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">
                                                    Apple</h6>
                                                <span class="leading-tight text-xs">27 March 2020, at 04:30 AM</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center justify-center">
                                            <p
                                                class="relative z-10 inline-block m-0 font-semibold leading-normal text-transparent bg-gradient-to-tl from-green-600 to-lime-400 text-sm bg-clip-text">
                                                + $ 2,000</p>
                                        </div>
                                    </li>
                                </ul>
                                <h6 class="my-4 font-bold leading-tight uppercase text-xs text-slate-500">Yesterday</h6>
                                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                                    <li
                                        class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 rounded-t-inherit text-inherit rounded-xl">
                                        <div class="flex items-center">
                                            <button
                                                class="leading-pro ease-soft-in text-xs bg-150 w-6 h-6 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-lime-500 border-transparent bg-transparent text-center align-middle font-bold uppercase text-lime-500 transition-all hover:opacity-75"><i
                                                    class="fas fa-arrow-up text-3xs" aria-hidden="true"></i></button>
                                            <div class="flex flex-col">
                                                <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">
                                                    Stripe</h6>
                                                <span class="leading-tight text-xs">26 March 2020, at 13:45 PM</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center justify-center">
                                            <p
                                                class="relative z-10 inline-block m-0 font-semibold leading-normal text-transparent bg-gradient-to-tl from-green-600 to-lime-400 text-sm bg-clip-text">
                                                + $ 750</p>
                                        </div>
                                    </li>
                                    <li
                                        class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 border-t-0 text-inherit rounded-xl">
                                        <div class="flex items-center">
                                            <button
                                                class="leading-pro ease-soft-in text-xs bg-150 w-6 h-6 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-lime-500 border-transparent bg-transparent text-center align-middle font-bold uppercase text-lime-500 transition-all hover:opacity-75"><i
                                                    class="fas fa-arrow-up text-3xs" aria-hidden="true"></i></button>
                                            <div class="flex flex-col">
                                                <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">
                                                    HubSpot</h6>
                                                <span class="leading-tight text-xs">26 March 2020, at 12:30 PM</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center justify-center">
                                            <p
                                                class="relative z-10 inline-block m-0 font-semibold leading-normal text-transparent bg-gradient-to-tl from-green-600 to-lime-400 text-sm bg-clip-text">
                                                + $ 1,000</p>
                                        </div>
                                    </li>
                                    <li
                                        class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 border-t-0 text-inherit rounded-xl">
                                        <div class="flex items-center">
                                            <button
                                                class="leading-pro ease-soft-in text-xs bg-150 w-6 h-6 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-lime-500 border-transparent bg-transparent text-center align-middle font-bold uppercase text-lime-500 transition-all hover:opacity-75"><i
                                                    class="fas fa-arrow-up text-3xs" aria-hidden="true"></i></button>
                                            <div class="flex flex-col">
                                                <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">
                                                    Creative Tim</h6>
                                                <span class="leading-tight text-xs">26 March 2020, at 08:30 AM</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center justify-center">
                                            <p
                                                class="relative z-10 items-center inline-block m-0 font-semibold leading-normal text-transparent bg-gradient-to-tl from-green-600 to-lime-400 text-sm bg-clip-text">
                                                + $ 2,500</p>
                                        </div>
                                    </li>
                                    <li
                                        class="relative flex justify-between px-4 py-2 pl-0 mb-2 border-0 border-t-0 rounded-b-inherit text-inherit rounded-xl">
                                        <div class="flex items-center">
                                            <button
                                                class="leading-pro ease-soft-in text-xs bg-150 w-6 h-6 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-slate-700 border-transparent bg-transparent text-center align-middle font-bold uppercase text-slate-700 transition-all hover:opacity-75"><i
                                                    class="fas fa-exclamation text-3xs" aria-hidden="true"></i></button>
                                            <div class="flex flex-col">
                                                <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">
                                                    Webflow</h6>
                                                <span class="leading-tight text-xs">26 March 2020, at 05:00 AM</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center justify-center">
                                            <p
                                                class="flex items-center m-0 font-semibold leading-normal text-sm text-slate-700">
                                                Pending</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        @else
        <div class="mt-6 w-full flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 xl:w-4/12">
                <div
                    class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 border-b-0 rounded-t-2xl">
                        <h6 class="mb-0 dark:text-white">Platform Settings</h6>
                    </div>
                    <div class="flex-auto p-4">
                        <h6 class="font-bold leading-tight uppercase text-xs text-slate-500">Account</h6>
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            <li class="relative block px-0 py-2 border-0 rounded-t-lg text-inherit">
                                <div class="min-h-6 mb-0.5 block pl-0">
                                    <input
                                        class="mt-0.5 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                        type="checkbox" "="" checked="">
                                    <label class=" w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer text-sm
                                        text-ellipsis whitespace-nowrap text-slate-500 dark:text-white/80"
                                        for="flexSwitchCheckDefault">Email me when
                                    someone follows me</label>
                                </div>
                            </li>
                            <li class="relative block px-0 py-2 border-0 text-inherit">
                                <div class="min-h-6 mb-0.5 block pl-0">
                                    <input
                                        class="mt-0.5 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                        type="checkbox">
                                    <label
                                        class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer text-sm text-ellipsis whitespace-nowrap text-slate-500 dark:text-white/80"
                                        for="flexSwitchCheckDefault1">Email me when someone answers on my post</label>
                                </div>
                            </li>
                            <li class="relative block px-0 py-2 border-0 rounded-b-lg text-inherit">
                                <div class="min-h-6 mb-0.5 block pl-0">
                                    <input
                                        class="mt-0.5 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                        type="checkbox" checked="">
                                    <label
                                        class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer text-sm text-ellipsis whitespace-nowrap text-slate-500 dark:text-white/80"
                                        for="flexSwitchCheckDefault2">Email me when someone mentions me</label>
                                </div>
                            </li>
                        </ul>
                        <h6 class="mt-6 font-bold leading-tight uppercase text-xs text-slate-500">Application</h6>
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            <li class="relative block px-0 py-2 border-0 rounded-t-lg text-inherit">
                                <div class="min-h-6 mb-0.5 block pl-0">
                                    <input
                                        class="mt-0.5 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                        type="checkbox">
                                    <label
                                        class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer text-sm text-ellipsis whitespace-nowrap text-slate-500 dark:text-white/80"
                                        for="flexSwitchCheckDefault3">New launches and projects</label>
                                </div>
                            </li>
                            <li class="relative block px-0 py-2 border-0 text-inherit">
                                <div class="min-h-6 mb-0.5 block pl-0">
                                    <input
                                        class="mt-0.5 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                        type="checkbox" checked="">
                                    <label
                                        class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer text-sm text-ellipsis whitespace-nowrap text-slate-500 dark:text-white/80"
                                        for="flexSwitchCheckDefault4">Monthly product updates</label>
                                </div>
                            </li>
                            <li class="relative block px-0 py-2 pb-0 border-0 rounded-b-lg text-inherit">
                                <div class="min-h-6 mb-0.5 block pl-0">
                                    <input
                                        class="mt-0.5 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                        type="checkbox">
                                    <label
                                        class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer text-sm text-ellipsis whitespace-nowrap text-slate-500 dark:text-white/80"
                                        for="flexSwitchCheckDefault5">Subscribe to newsletter</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 lg-max:mt-6 xl:w-4/12">
                <div
                    class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 border-b-0 rounded-t-2xl">
                        <div class="flex flex-wrap -mx-3">
                            <div class="flex items-center w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-none">
                                <h6 class="mb-0 dark:text-white">Profile Information</h6>
                            </div>
                            <div class="w-full max-w-full px-3 text-right shrink-0 md:w-4/12 md:flex-none">
                                <a href="{{route('user.show.profile', [$user->id])}}" data-target="tooltip_trigger">
                                    <i class="leading-normal fas fa-user-edit text-sm text-slate-400 dark:text-white dark:opacity-80"
                                        aria-hidden="true"></i>
                                </a>
                                <div class="hidden px-2 py-1 text-center text-white bg-black rounded-lg text-sm"
                                    id="tooltip" data-popper-placement="top"
                                    style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(1042.4px, -328.8px, 0px);">
                                    Edit Profile
                                    <div class="invisible absolute h-2 w-2 bg-inherit before:visible before:absolute before:h-2 before:w-2 before:rotate-45 before:bg-inherit before:content-['']"
                                        data-popper-arrow=""
                                        style="position: absolute; left: 0px; transform: translate3d(0px, 0px, 0px);">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-auto p-4">
                        <p class="leading-normal text-sm dark:text-white dark:opacity-60">Hi, I’m {{$user->nick}},
                            Decisions:
                            If you can’t decide, the answer is no. If two equally difficult paths, choose the one more
                            painful in the short term (pain avoidance is creating an illusion of equality).</p>
                        <hr class="h-px my-6 bg-transparent bg-gradient-to-r from-transparent via-white to-transparent">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            <li
                                class="relative block px-4 py-2 pt-0 pl-0 leading-normal border-0 rounded-t-lg text-sm text-inherit">
                                <strong class="text-slate-700 dark:text-white">Full Name:</strong> &nbsp;
                                {{$user->name}}
                            </li>
                            <li
                                class="relative block px-4 py-2 pl-0 leading-normal border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700 dark:text-white">Mobile:</strong> &nbsp;
                                {{$user->phone_no}}
                            </li>
                            <li
                                class="relative block px-4 py-2 pl-0 leading-normal border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700 dark:text-white">Email:</strong> &nbsp; {{$user->email}}
                            </li>
                            <li
                                class="relative block px-4 py-2 pl-0 leading-normal border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700 dark:text-white">Location:</strong> &nbsp; Indonesia
                            </li>
                            <li
                                class="relative block px-4 py-2 pb-0 pl-0 border-0 border-t-0 rounded-b-lg text-inherit">
                                <strong class="leading-normal text-sm text-slate-700 dark:text-white">Social:</strong>
                                &nbsp;
                                <a class="inline-block py-0 pl-1 pr-2 mb-0 font-bold text-center text-blue-800 align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-none"
                                    href="javascript:;">
                                    <i class="fab fa-facebook fa-lg" aria-hidden="true"></i>
                                </a>
                                <a class="inline-block py-0 pl-1 pr-2 mb-0 font-bold text-center align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-none text-sky-600"
                                    href="javascript:;">
                                    <i class="fab fa-twitter fa-lg" aria-hidden="true"></i>
                                </a>
                                <a class="inline-block py-0 pl-1 pr-2 mb-0 font-bold text-center align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-none text-sky-900"
                                    href="javascript:;">
                                    <i class="fab fa-instagram fa-lg" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 lg-max:mt-6 xl:w-4/12">
                <div
                    class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 border-b-0 rounded-t-2xl">
                        <h6 class="mb-0 dark:text-white">Connection</h6>
                    </div>
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            <li class="relative flex items-center px-0 py-2 mb-2 border-0 rounded-t-lg text-inherit">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 mr-4 text-white transition-all duration-200 text-base ease-soft-in-out rounded-xl">
                                    <img src="../../../assets/img/kal-visuals-square.jpg" alt="kal"
                                        class="w-full shadow-soft-2xl rounded-xl">
                                </div>
                                <div class="flex flex-col items-start justify-center">
                                    <h6 class="mb-0 leading-normal text-sm dark:text-white">Sophie B.</h6>
                                    <p class="mb-0 leading-tight text-xs dark:text-white dark:opacity-60">Hi! I need
                                        more
                                        information..</p>
                                </div>
                                <a class="inline-block py-3 pl-0 pr-4 mb-0 ml-auto font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in hover:scale-102 hover:active:scale-102 active:opacity-85 text-fuchsia-500 hover:text-fuchsia-800 hover:shadow-none active:scale-100"
                                    href="javascript:;">Reply</a>
                            </li>
                            <li class="relative flex items-center px-0 py-2 mb-2 border-0 border-t-0 text-inherit">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 mr-4 text-white transition-all duration-200 text-base ease-soft-in-out rounded-xl">
                                    <img src="../../../assets/img/marie.jpg" alt="kal"
                                        class="w-full shadow-soft-2xl rounded-xl">
                                </div>
                                <div class="flex flex-col items-start justify-center">
                                    <h6 class="mb-0 leading-normal text-sm dark:text-white">Anne Marie</h6>
                                    <p class="mb-0 leading-tight text-xs dark:text-white dark:opacity-60">Awesome work,
                                        can
                                        you..</p>
                                </div>
                                <a class="inline-block py-3 pl-0 pr-4 mb-0 ml-auto font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in hover:scale-102 hover:active:scale-102 active:opacity-85 text-fuchsia-500 hover:text-fuchsia-800 hover:shadow-none active:scale-100"
                                    href="javascript:;">Reply</a>
                            </li>
                            <li class="relative flex items-center px-0 py-2 mb-2 border-0 border-t-0 text-inherit">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 mr-4 text-white transition-all duration-200 text-base ease-soft-in-out rounded-xl">
                                    <img src="../../../assets/img/ivana-square.jpg" alt="kal"
                                        class="w-full shadow-soft-2xl rounded-xl">
                                </div>
                                <div class="flex flex-col items-start justify-center">
                                    <h6 class="mb-0 leading-normal text-sm dark:text-white">Ivanna</h6>
                                    <p class="mb-0 leading-tight text-xs dark:text-white dark:opacity-60">About files I
                                        can..</p>
                                </div>
                                <a class="inline-block py-3 pl-0 pr-4 mb-0 ml-auto font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in hover:scale-102 hover:active:scale-102 active:opacity-85 text-fuchsia-500 hover:text-fuchsia-800 hover:shadow-none active:scale-100"
                                    href="javascript:;">Reply</a>
                            </li>
                            <li class="relative flex items-center px-0 py-2 mb-2 border-0 border-t-0 text-inherit">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 mr-4 text-white transition-all duration-200 text-base ease-soft-in-out rounded-xl">
                                    <img src="../../../assets/img/team-4.jpg" alt="kal"
                                        class="w-full shadow-soft-2xl rounded-xl">
                                </div>
                                <div class="flex flex-col items-start justify-center">
                                    <h6 class="mb-0 leading-normal text-sm dark:text-white">Peterson</h6>
                                    <p class="mb-0 leading-tight text-xs dark:text-white dark:opacity-60">Have a great
                                        afternoon..</p>
                                </div>
                                <a class="inline-block py-3 pl-0 pr-4 mb-0 ml-auto font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in hover:scale-102 hover:active:scale-102 active:opacity-85 text-fuchsia-500 hover:text-fuchsia-800 hover:shadow-none active:scale-100"
                                    href="javascript:;">Reply</a>
                            </li>
                            <li
                                class="relative flex items-center px-0 py-2 border-0 border-t-0 rounded-b-lg text-inherit">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 mr-4 text-white transition-all duration-200 text-base ease-soft-in-out rounded-xl">
                                    <img src="../../../assets/img/team-3.jpg" alt="kal"
                                        class="w-full shadow-soft-2xl rounded-xl">
                                </div>
                                <div class="flex flex-col items-start justify-center">
                                    <h6 class="mb-0 leading-normal text-sm dark:text-white">Nick Daniel</h6>
                                    <p class="mb-0 leading-tight text-xs dark:text-white dark:opacity-60">Hi! I need
                                        more
                                        information..</p>
                                </div>
                                <a class="inline-block py-3 pl-0 pr-4 mb-0 ml-auto font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in hover:scale-102 hover:active:scale-102 active:opacity-85 text-fuchsia-500 hover:text-fuchsia-800 hover:shadow-none active:scale-100"
                                    href="javascript:;">Reply</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex-none w-full max-w-full px-3 mt-6">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 rounded-t-2xl">
                        <h6 class="mb-1 dark:text-white">Team & Task</h6>
                    </div>
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap -mx-3 gap-1">
                            @if($user->listTeams)
                            @foreach($user->listTeams as $team)
                            <div class="w-full max-w-full p-3 mb-6 md:w-6/12 md:flex-none xl:mb-0 xl:w-3/12">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-slate-900 border-0 shadow-none dark:shadow-soft-dark-xl rounded-2xl bg-clip-border">

                                    <div class="flex-auto px-4 pt-6">
                                        <p
                                            class="relative z-10 mb-2 leading-normal text-transparent bg-gradient-to-tl from-gray-900 to-slate-800 text-sm bg-clip-text dark:text-white dark:opacity-80">
                                            Team #{{$team->team_id}}</p>
                                        <a href="javascript:;">
                                            <h5 class="dark:text-white">{{$team->team->name}}</h5>
                                        </a>
                                        <p class="mb-6 leading-normal text-sm dark:text-white dark:opacity-60"></p>
                                        <div class="text-center pb-4">
                                            <button type="button"
                                                class="inline-block px-8 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in text-xs hover:scale-102 active:shadow-soft-xs tracking-tight-soft border-fuchsia-500 text-fuchsia-500 hover:border-fuchsia-500 hover:bg-transparent hover:text-fuchsia-500 hover:opacity-75 hover:shadow-none active:bg-fuchsia-500 active:text-white active:hover:bg-transparent active:hover:text-fuchsia-500">View
                                                Team</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($team->team->listProjects)
                            @foreach($team->team->listProjects as $project)
                            <div class="w-full max-w-full p-3 mb-6 md:w-6/12 md:flex-none xl:mb-0 xl:w-3/12">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-slate-900 border-0 shadow-none dark:shadow-soft-dark-xl rounded-2xl bg-clip-border">

                                    <div class="flex-auto px-4 pt-6">
                                        <p
                                            class="relative z-10 mb-2 leading-normal text-transparent bg-gradient-to-tl from-gray-900 to-slate-800 text-sm bg-clip-text dark:text-white dark:opacity-80">
                                            Project #{{$project->id}}</p>
                                        <a href="javascript:;">
                                            <h5 class="dark:text-white">{{$project->name}}</h5>
                                        </a>
                                        <p class="mb-6 leading-normal text-sm dark:text-white dark:opacity-60"></p>
                                        <div class="text-center pb-4">
                                            <button type="button"
                                                class="inline-block px-8 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in text-xs hover:scale-102 active:shadow-soft-xs tracking-tight-soft border-fuchsia-500 text-fuchsia-500 hover:border-fuchsia-500 hover:bg-transparent hover:text-fuchsia-500 hover:opacity-75 hover:shadow-none active:bg-fuchsia-500 active:text-white active:hover:bg-transparent active:hover:text-fuchsia-500">View
                                                Project</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @endforeach
                            @endif

                            @if($user->listRoles)
                            @foreach($user->listRoles as $role)
                            <div class="w-full max-w-full p-3 mb-6 md:w-6/12 md:flex-none xl:mb-0 xl:w-3/12">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-slate-900 border-0 shadow-none dark:shadow-soft-dark-xl rounded-2xl bg-clip-border">

                                    <div class="flex-auto px-4 pt-6">
                                        <p
                                            class="relative z-10 mb-2 leading-normal text-transparent bg-gradient-to-tl from-gray-900 to-slate-800 text-sm bg-clip-text dark:text-white dark:opacity-80">
                                            Project #1</p>
                                        <a href="javascript:;">
                                            <h5 class="dark:text-white">{{$role}}</h5>
                                        </a>
                                        <p class="mb-6 leading-normal text-sm dark:text-white dark:opacity-60"></p>
                                        <div class="text-center pb-4">
                                            <button type="button"
                                                class="inline-block px-8 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in text-xs hover:scale-102 active:shadow-soft-xs tracking-tight-soft border-fuchsia-500 text-fuchsia-500 hover:border-fuchsia-500 hover:bg-transparent hover:text-fuchsia-500 hover:opacity-75 hover:shadow-none active:bg-fuchsia-500 active:text-white active:hover:bg-transparent active:hover:text-fuchsia-500">View
                                                Role</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
