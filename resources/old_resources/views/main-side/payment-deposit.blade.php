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
        <div class="flex items-center">
            <a mini-sidenav-burger href="javascript:;" class="hidden p-0 text-white transition-all ease-nav-brand text-sm xl:block" aria-expanded="false">
                <div class="w-4.5 overflow-hidden">
                    <i class="ease-soft mb-0.75 relative block h-0.5 translate-x-[5px] rounded-sm bg-white transition-all dark:bg-white"></i>
                    <i class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all dark:bg-white"></i>
                    <i class="ease-soft relative block h-0.5 translate-x-[5px] rounded-sm bg-white transition-all dark:bg-white"></i>
                </div>
            </a>
        </div>
        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
                <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease-soft">
                    <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </span>
                    <input type="text" class="pl-9 text-sm focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Type here..." />
                </div>
            </div>
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                <li class="flex items-center pl-4 xl:hidden">
                    <a href="javascript:;" class="block p-0 text-white transition-all ease-soft-in-out text-sm" sidenav-trigger>
                        <div class="w-4.5 overflow-hidden">
                            <i class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                            <i class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                            <i class="ease-soft relative block h-0.5 rounded-sm bg-white transition-all"></i>
                        </div>
                    </a>
                </li>
                <li class="flex items-center px-4">
                    <a href="javascript:;" class="p-0 text-white transition-all text-sm ease-soft-in-out">
                        <i fixed-plugin-button-nav class="cursor-pointer fa fa-cog" aria-hidden="true"></i>

                    </a>
                </li>

                <li class="relative flex items-center pr-2">
                    <p class="hidden transform-dropdown-show"></p>
                    <a dropdown-trigger href="javascript:;" class="block p-0 text-white transition-all text-sm ease-nav-brand dark:text-white" aria-expanded="false">
                        <i class="cursor-pointer fa fa-bell" aria-hidden="true"></i>
                    </a>
                    <ul dropdown-menu class="text-sm transform-dropdown before:font-awesome before:leading-default before:duration-350 before:ease-soft lg:shadow-soft-3xl duration-250 min-w-44 before:sm:right-7 before:text-5.5 dark:bg-gray-950 pointer-events-none absolute right-0 top-0 z-50 origin-top list-none rounded-lg border-0 border-solid border-transparent bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all before:absolute before:right-2 before:left-auto before:top-0 before:z-50 before:inline-block before:font-normal before:text-white before:antialiased before:transition-all before:content-['\f0d8'] sm:-mr-6 lg:absolute lg:right-0 lg:left-auto lg:mt-2 lg:block lg:cursor-pointer">

                        <li class="relative mb-2">
                            <a class="group ease-soft py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 dark:hover:bg-gray-200/80 lg:transition-colors" href="javascript:;">
                                <div class="flex py-1">
                                    <div class="my-auto">
                                        <img src="../../../assets/img/team-2.jpg" class="inline-flex items-center justify-center mr-4 text-white text-sm h-9 w-9 max-w-none rounded-xl" />
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-1 font-normal leading-normal text-sm group-hover:text-slate-700 dark:text-white"><span class="font-semibold">New message</span> from Laur</h6>
                                        <p class="mb-0 leading-tight text-xs text-slate-400 group-hover:text-slate-700 dark:text-white dark:opacity-80">
                                            <i class="mr-1 fa fa-clock" aria-hidden="true"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="relative mb-2">
                            <a class="group ease-soft py-1.2 clear-both block w-full whitespace-nowrap rounded-lg px-4 transition-colors duration-300 hover:bg-gray-200 hover:text-slate-700 dark:hover:bg-gray-200/80" href="javascript:;">
                                <div class="flex py-1">
                                    <div class="my-auto">
                                        <img src="../../../assets/img/small-logos/logo-spotify.svg" class="inline-flex items-center justify-center mr-4 text-white text-sm bg-gradient-to-tl from-gray-900 to-slate-800 dark:bg-gradient-to-tl dark:from-slate-850 dark:to-gray-850 h-9 w-9 max-w-none rounded-xl" />
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-1 font-normal leading-normal text-sm group-hover:text-slate-700 dark:text-white"><span class="font-semibold">New album</span> by Travis Scott</h6>
                                        <p class="mb-0 leading-tight text-xs text-slate-400 group-hover:text-slate-700 dark:text-white dark:opacity-80">
                                            <i class="mr-1 fa fa-clock" aria-hidden="true"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="relative">
                            <a class="group ease-soft py-1.2 clear-both block w-full whitespace-nowrap rounded-lg px-4 transition-colors duration-300 hover:bg-gray-200 hover:text-slate-700 dark:hover:bg-gray-200/80" href="javascript:;">
                                <div class="flex py-1">
                                    <div class="inline-flex items-center justify-center my-auto mr-4 text-white transition-all duration-200 ease-nav-brand text-sm bg-gradient-to-tl from-slate-600 to-slate-300 h-9 w-9 rounded-xl">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                            <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-1 font-normal leading-normal text-sm group-hover:text-slate-700 dark:text-white">Payment successfully completed</h6>
                                        <p class="mb-0 leading-tight text-xs text-slate-400 group-hover:text-slate-700 dark:text-white dark:opacity-80">
                                            <i class="mr-1 fa fa-clock" aria-hidden="true"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
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
                    <a href="{{route('profile.show')}}"><img src="{{auth()->user()->profile_photo_url?auth()->user()->profile_photo_url:'https://ui-avatars.com/api/?name='.auth()->user()->name.'&amp;color=7F9CF5&amp;background=EBF4FF'}}" alt="{{auth()->user()->name}}" class="w-full shadow-soft-sm rounded-xl"></a>
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1 dark:text-white">{{auth()->user()->name}}</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm dark:text-white dark:opacity-60">{{auth()->user()->person_in_charge}}</p>
                </div>
            </div>
            <div class="max-w-full px-3 mr-auto md:flex-0 shrink-0">
                <div class=" mx-auto py-3 px-4 sm:px-6 lg:px-8">
                    <div class="font-semibold text-xl text-gray-800 dark:text-slate-300 leading-tight flex justify-between">
                        <a href="#">{{ __('Balance') }} : <span class="capitalize">Rp {{number_format(balance(auth()->user()))}}</span></a>
                        <a  href="{{route('payment.topup')}}" class="ml-3 border text-xs bg-green-400 rounded text-slate-700 dark:text-slate-300 border-gray-200 align-middle p-1">Top-up</a>
                    </div>

                    @if(balance(auth()->user())!=0)
                    <p>
                        <small>
                            {{ __('Estimation') }} :
                            @foreach(estimationSaldo() as $product)
                                <span class="capitalize text-xs">{{$product->name}} ({{number_format(balance(auth()->user())/$product->unit_price)}} SMS)</span>
                            @endforeach
                        </small>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full p-6 py-4 mx-auto my-4">
    <div class="flex flex-wrap mb-12 -mx-3">
        <div class="w-full max-w-full px-3 lg:flex-0 shrink-0">
            <div class="py-4">
                <div class="lg:mt-6">
                    <livewire:table.balance user="{{auth()->user()->id}}" exportable />
                </div>
            </div>
        </div>
    </div>
    @include('navigation.footer')
</div>
@endsection
