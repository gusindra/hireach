@extends('layouts.side-menu')

@section('title', 'Dashboard')

@section('sidebar')
@parent

<p>This is appended to the master sidebar.</p>
@endsection

@section('content')
<nav class="absolute z-20 flex flex-wrap items-center justify-between w-full px-6 py-2 text-white transition-all shadow-none duration-250 ease-soft-in lg:flex-nowrap lg:justify-start" navbar-profile navbar-scroll="true">
    <div class="flex items-center justify-between w-full px-6 py-1 mx-auto flex-wrap-inherit">
        <nav>
            <ol class="flex flex-wrap pt-1 pl-2 pr-4 mr-12 bg-transparent rounded-lg sm:mr-16">
                <li class="leading-normal text-sm">
                    <a class="text-white opacity-50" href="javascript:;">User</a>
                </li>
                <li class="text-sm pl-2 capitalize leading-normal before:float-left before:pr-2 before:content-['/']" aria-current="page">Project</li>
            </ol>
            <h6 class="mb-2 ml-2 font-bold text-white capitalize">List</h6>
        </nav>
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
                    <h5 class="mb-1 dark:text-white">{{auth()->user()->name}}</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm dark:text-white dark:opacity-60">{{auth()->user()->person_in_charge}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full p-6 py-4 mx-auto my-4">
    <div class="flex flex-wrap mb-12 -mx-3">
        <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 lg:w-3/12">
            <div class="sticky flex flex-col min-w-0 break-words bg-white border-0 top-1/100 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                <ul class="flex flex-col flex-wrap p-4 mb-0 list-none rounded-xl">

                    <li class="pt-2">
                        <a href="#basic-info" class="block px-4 py-2 transition-colors rounded-lg ease-soft-in-out text-slate-500 hover:bg-gray-200">
                            <div class="inline-block mr-2 text-black fill-current h-4 w-4 stroke-none">
                                <svg class="mb-1 text-dark" width="16px" height="16px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>document</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(154.000000, 300.000000)">
                                                    <path class="fill-slate-800" d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z" opacity="0.603585379"></path>
                                                    <path class="fill-slate-800" d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="leading-normal text-sm dark:text-slate-600">Basic Info</span>
                        </a>
                    </li>
                    <li class="pt-2">
                        <a href="#password" class="block px-4 py-2 transition-colors rounded-lg ease-soft-in-out text-slate-500 hover:bg-gray-200">
                            <div class="inline-block mr-2 text-black fill-current h-4 w-4 stroke-none">
                                <svg class="mb-1 text-dark" width="16px" height="16px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>box-3d-50</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(603.000000, 0.000000)">
                                                    <path class="fill-slate-800" d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z"></path>
                                                    <path class="fill-slate-800" d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z" opacity="0.7"></path>
                                                    <path class="fill-slate-800" d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z" opacity="0.7"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="leading-normal text-sm dark:text-slate-600">Change Password</span>
                        </a>
                    </li>
                    <li class="pt-2">
                        <a href="#2FA" class="block px-4 py-2 transition-colors rounded-lg ease-soft-in-out text-slate-500 hover:bg-gray-200">
                            <div class="inline-block mr-2 text-black fill-current h-4 w-4 stroke-none">
                                <svg class="mb-1 text-dark" width="16px" height="16px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>switches</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1870.000000, -440.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(154.000000, 149.000000)">
                                                    <path class="fill-slate-800" d="M10,20 L30,20 C35.4545455,20 40,15.4545455 40,10 C40,4.54545455 35.4545455,0 30,0 L10,0 C4.54545455,0 0,4.54545455 0,10 C0,15.4545455 4.54545455,20 10,20 Z M10,3.63636364 C13.4545455,3.63636364 16.3636364,6.54545455 16.3636364,10 C16.3636364,13.4545455 13.4545455,16.3636364 10,16.3636364 C6.54545455,16.3636364 3.63636364,13.4545455 3.63636364,10 C3.63636364,6.54545455 6.54545455,3.63636364 10,3.63636364 Z" opacity="0.6"></path>
                                                    <path class="fill-slate-800" d="M30,23.6363636 L10,23.6363636 C4.54545455,23.6363636 0,28.1818182 0,33.6363636 C0,39.0909091 4.54545455,43.6363636 10,43.6363636 L30,43.6363636 C35.4545455,43.6363636 40,39.0909091 40,33.6363636 C40,28.1818182 35.4545455,23.6363636 30,23.6363636 Z M30,40 C26.5454545,40 23.6363636,37.0909091 23.6363636,33.6363636 C23.6363636,30.1818182 26.5454545,27.2727273 30,27.2727273 C33.4545455,27.2727273 36.3636364,30.1818182 36.3636364,33.6363636 C36.3636364,37.0909091 33.4545455,40 30,40 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="leading-normal text-sm dark:text-slate-600">2FA</span>
                        </a>
                    </li>

                    <li class="pt-2">
                        <a href="#notifications" class="block px-4 py-2 transition-colors rounded-lg ease-soft-in-out text-slate-500 hover:bg-gray-200">
                            <div class="inline-block mr-2 text-black fill-current h-4 w-4 stroke-none">
                                <svg class="mb-1 text-dark" width="16px" height="16px" viewBox="0 0 44 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>megaphone</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-2168.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(452.000000, 300.000000)">
                                                    <path class="fill-slate-800" d="M35.7958333,0.273166667 C35.2558424,-0.0603712374 34.5817509,-0.0908856664 34.0138333,0.1925 L19.734,7.33333333 L9.16666667,7.33333333 C4.10405646,7.33333333 0,11.4373898 0,16.5 C0,21.5626102 4.10405646,25.6666667 9.16666667,25.6666667 L19.734,25.6666667 L34.0138333,32.8166667 C34.5837412,33.1014624 35.2606401,33.0699651 35.8016385,32.7334768 C36.3426368,32.3969885 36.6701539,31.8037627 36.6666942,31.1666667 L36.6666942,1.83333333 C36.6666942,1.19744715 36.3370375,0.607006911 35.7958333,0.273166667 Z"></path>
                                                    <path class="fill-slate-800" d="M38.5,11 L38.5,22 C41.5375661,22 44,19.5375661 44,16.5 C44,13.4624339 41.5375661,11 38.5,11 Z" opacity="0.601050967"></path>
                                                    <path class="fill-slate-800" d="M18.5936667,29.3333333 L10.6571667,29.3333333 L14.9361667,39.864 C15.7423448,41.6604248 17.8234451,42.4993948 19.6501416,41.764381 C21.4768381,41.0293672 22.3968823,38.982817 21.7341667,37.1286667 L18.5936667,29.3333333 Z" opacity="0.601050967"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="leading-normal text-sm dark:text-slate-600">Notifications</span>
                        </a>
                    </li>
                    <li class="pt-2">
                        <a href="#sessions" class="block px-4 py-2 transition-colors rounded-lg ease-soft-in-out text-slate-500 hover:bg-gray-200">
                            <div class="inline-block mr-2 text-black fill-current h-4 w-4 stroke-none">
                                <svg class="mb-1 text-dark" width="16px" height="16px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>settings</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(304.000000, 151.000000)">
                                                    <polygon class="fill-slate-800" opacity="0.596981957" points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"></polygon>
                                                    <path class="fill-slate-800" d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z" opacity="0.596981957"></path>
                                                    <path class="fill-slate-800" d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="leading-normal text-sm dark:text-slate-600">Sessions</span>
                        </a>
                    </li>
                    <li class="pt-2">
                        <a href="#delete" class="block px-4 py-2 transition-colors rounded-lg ease-soft-in-out text-slate-500 hover:bg-gray-200">
                            <div class="inline-block mr-2 text-black fill-current h-4 w-4 stroke-none">
                                <svg class="mb-1 text-dark" width="16px" height="16px" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>shop</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(0.000000, 148.000000)">
                                                    <path class="fill-slate-800" d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z" opacity="0.598981585"></path>
                                                    <path class="fill-gray-900" d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="leading-normal text-sm dark:text-slate-600">Delete Account</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 lg:w-9/12">
            <div class="relative flex flex-col min-w-0 mt-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border" id="basic-info">

                <div class="flex-auto p-6 pt-0">
                    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                        @livewire('profile.update-profile-information-form')
                    @endif
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border" id="password">
                <div class="flex-auto p-6 pt-0">
                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.update-password-form')
                        </div>
                    @endif
                    <p class="mb-2 text-slate-500 dark:text-white/60">Please follow this guide for a strong password:</p>
                    <ul class="float-left pl-6 mb-0 list-disc text-slate-500">
                        <li>
                            <span class="leading-normal text-sm">One special characters</span>
                        </li>
                        <li>
                            <span class="leading-normal text-sm">Min 6 characters</span>
                        </li>
                        <li>
                            <span class="leading-normal text-sm">One number (2 are recommended)</span>
                        </li>
                        <li>
                            <span class="leading-normal text-sm">Change it often</span>
                        </li>
                    </ul>
                    <!-- <button href="javascript:;" class="inline-block float-right px-8 py-2 mt-16 mb-0 font-bold text-right text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 hover:shadow-soft-xs dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 bg-gradient-to-tl from-gray-900 to-slate-800 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25">Update Password</button> -->
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border" id="2FA">
                <div class="flex-auto p-6">
                    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.two-factor-authentication-form')
                        </div>
                    @endif
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border" id="notifications">
                <div class="p-6 rounded-t-2xl">
                    <h5 class="dark:text-white">Notifications [beta]</h5>
                    <p class="leading-normal text-sm dark:text-white/60">Choose how you receive notifications. These notification settings apply to the things you’re watching.</p>
                </div>
                <div class="flex-auto p-6 pt-0">
                    <div class="overflow-x-auto ps">
                        <table class="w-full mb-0 align-top border-gray-200 text-slate-500 dark:border-white/40">
                            <thead class="align-bottom">
                                <tr>
                                    <th colspan="4" class="px-6 py-3 pl-1 font-semibold capitalize align-middle bg-transparent border-b border-solid shadow-none tracking-none whitespace-nowrap border-b-gray-200 dark:border-white/40 dark:text-white">
                                        <p class="mb-0 dark:text-white/60">Activity</p>
                                    </th>
                                    <th class="px-6 py-3 font-semibold text-center capitalize align-middle bg-transparent border-b border-solid shadow-none tracking-none whitespace-nowrap border-b-gray-200 dark:border-white/40 dark:text-white">
                                        <p class="mb-0 dark:text-white/60">Email</p>
                                    </th>
                                    <th class="px-6 py-3 font-semibold text-center capitalize align-middle bg-transparent border-b border-solid shadow-none tracking-none whitespace-nowrap border-b-gray-200 dark:border-white/40 dark:text-white">
                                        <p class="mb-0 dark:text-white/60">Push</p>
                                    </th>
                                    <th class="px-6 py-3 font-semibold text-center capitalize align-middle bg-transparent border-b border-solid shadow-none tracking-none whitespace-nowrap border-b-gray-200 dark:border-white/40 dark:text-white">
                                        <p class="mb-0 dark:text-white/60">SMS</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-2 pl-1 align-top border-b whitespace-nowrap dark:border-white/40 dark:text-white" colspan="4">
                                        <div class="my-auto">
                                            <span class="block leading-normal text-sm text-slate-700 dark:text-white">Mentions</span>
                                            <span class="font-normal leading-tight text-xs dark:text-white/60">Notify when another user mentions you in a comment</span>
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input checked="" class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-2 pl-1 align-top border-b whitespace-nowrap dark:border-white/40 dark:text-white" colspan="4">
                                        <div class="my-auto">
                                            <span class="block leading-normal text-sm text-slate-700 dark:text-white">Comments</span>
                                            <span class="font-normal leading-tight text-xs dark:text-white/60">Notify when another user comments your item.</span>
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input checked="" class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input checked="" class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-2 pl-1 align-top border-b whitespace-nowrap dark:border-white/40 dark:text-white" colspan="4">
                                        <div class="my-auto">
                                            <span class="block leading-normal text-sm text-slate-700 dark:text-white">Follows</span>
                                            <span class="font-normal leading-tight text-xs dark:text-white/60">Notify when another user follows you.</span>
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input checked="" class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-2 pl-1 align-top border-b-0 whitespace-nowrap dark:border-white/40 dark:text-white" colspan="4">
                                        <div class="my-auto">
                                            <p class="mb-0 leading-normal text-sm dark:text-white/60">Log in from a new device</p>
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b-0 whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input checked="" class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b-0 whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input checked="" class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                    <td class="p-2 align-top bg-transparent border-b-0 whitespace-nowrap dark:border-white/40 dark:text-white">
                                        <div class="flex items-center justify-center pl-12 mb-0 min-h-6">
                                            <input checked="" class="rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.3 h-5 mt-0.5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border" id="sessions">
                <div class="flex-auto p-6 pt-4">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border" id="delete">

                <div class="flex-auto p-6 pt-4">
                    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())

                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.delete-user-form')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('navigation.footer')
</div>
@endsection
