@extends('layouts.side-menu')

@section('title', 'Users')

@section('header')

@endsection

@section('sidebar')
@parent
@endsection

@section('content')
<nav navbar-main="" class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 mt-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-scroll="true">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        <nav>

            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                <li class="leading-normal text-sm breadcrumb-item">
                    <a class="text-slate-700 opacity-30 dark:text-white" href="{{ route('dashboard') }}?v=1">
                        <svg width="12px" height="12px" class="mb-1" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>Dashboard</title>
                            <g class="dark:fill-white" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g class="dark:fill-white" transform="translate(-1716.000000, -439.000000)" fill="#252f40" fill-rule="nonzero">
                                    <g class="dark:fill-white" transform="translate(1716.000000, 291.000000)">
                                        <g class="dark:fill-white" transform="translate(0.000000, 148.000000)">
                                            <path d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                                            <path d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
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
                <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/'] dark:text-white dark:before:text-white" aria-current="page">Users</li>
            </ol>
            <h6 class="mb-0 font-bold capitalize dark:text-white">List</h6>
        </nav>
        <div class="flex items-center">
            <a mini-sidenav-burger="" href="javascript:;" class="hidden p-0 transition-all ease-nav-brand text-sm text-slate-500 xl:block" aria-expanded="false">
                <div class="w-4.5 overflow-hidden">
                    <i class="ease-soft mb-0.75 relative block h-0.5 translate-x-[5px] rounded-sm bg-slate-500 transition-all dark:bg-white"></i>
                    <i class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-slate-500 transition-all dark:bg-white"></i>
                    <i class="ease-soft relative block h-0.5 translate-x-[5px] rounded-sm bg-slate-500 transition-all dark:bg-white"></i>
                </div>
            </a>
        </div>
        @include('navigation.header')
    </div>
</nav>

<div class="w-full p-6 mx-auto">
    <section class="py-4">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 mr-auto md:flex-0 shrink-0 md:w-8/12">
                <!-- <h5 class="dark:text-white">Some of Our Awesome Projects</h5> -->
                <!-- <p>This is the paragraph where you can write more details about your projects. Keep you user engaged by providing meaningful information.</p> -->
            </div>
        </div>
        <div class="justify-between sm:flex">
            <div class="inline-block px-6 py-3 mb-4 font-bold text-center text-white uppercase align-middle border-0 rounded-lg cursor-pointer bg-gradient-to-tl from-gray-900 to-slate-800 text-xs shadow-soft-md bg-150 bg-x-25">
                @livewire('user.add')
            </div>
            <!-- <div class="flex">
                <div class="relative inline">
                    <a href="javascript:;" dropdown-trigger="" class="inline-block px-6 py-3 mb-4 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer select-auto hover:scale-102 leading-pro text-xs ease-soft-in tracking-tight-soft active:opacity-85 active:shadow-soft-xs border-slate-700 text-slate-700 hover:border-slate-700 hover:bg-transparent hover:opacity-75 active:border-slate-700 active:bg-slate-700 active:text-white" aria-expanded="false">
                        Filters
                    </a>
                    <ul dropdown-menu="" class="z-100 min-w-44 text-sm shadow-soft-3xl duration-250 transform-dropdown before:duration-350 before:font-awesome before:ease-soft before:text-5.5 dark:bg-gray-950 pointer-events-none absolute top-1.5 right-2 left-auto m-0 mt-2 block origin-top cursor-pointer list-none rounded-lg border-0 border-solid border-transparent bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all will-change-transform before:absolute before:top-0 before:right-5 before:left-auto before:z-40 before:text-white before:transition-all before:content-['\f0d8'] sm:-mr-6">
                        <li class="relative"><a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg px-4 font-normal text-slate-500 transition-colors hover:bg-gray-200 hover:text-slate-700 focus:bg-gray-200 focus:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:duration-300" href="javascript:;">Status: Paid</a></li>
                        <li class="relative"><a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg px-4 font-normal text-slate-500 transition-colors hover:bg-gray-200 hover:text-slate-700 focus:bg-gray-200 focus:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:duration-300" href="javascript:;">Status: Refunded</a></li>
                        <li class="relative"><a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg px-4 font-normal text-slate-500 transition-colors hover:bg-gray-200 hover:text-slate-700 focus:bg-gray-200 focus:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:duration-300" href="javascript:;">Status: Canceled</a></li>
                        <li class="relative">
                            <hr class="h-px my-2 bg-gradient-to-r from-transparent via-black/40 to-transparent">
                        </li>
                        <li class="relative"><a class="py-1.2 text-danger lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg px-4 font-normal text-red-600 transition-colors hover:bg-gray-200 focus:bg-gray-200 dark:hover:bg-gray-200/80 lg:duration-300" href="javascript:;">Remove Filter</a></li>
                    </ul>
                </div>
                <button data-type="csv" type="button" export-button-list="" class="inline-block px-6 py-3 mb-4 ml-2 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer hover:scale-102 leading-pro text-xs ease-soft-in tracking-tight-soft active:opacity-85 active:shadow-soft-xs border-slate-700 text-slate-700 hover:border-slate-700 hover:bg-transparent hover:opacity-75 active:border-slate-700 active:bg-slate-700 active:text-white">
                    <span>
                        <i class="ni leading-none ni-archive-2"></i>
                    </span>
                    <span>Export CSV</span>
                </button>
            </div> -->
        </div>
        <livewire:table.client-company-table companyid="{{ app('request')->input('companyid') }}" searchable="name" exportable />
    </section>

    @include('navigation.footer')

</div>
@endsection
