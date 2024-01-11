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
                    <a class="text-white opacity-50" href="javascript:;">Data</a>
                </li>
                <li class="text-sm pl-2 capitalize leading-normal before:float-left before:pr-2 before:content-['/']" aria-current="page">Report</li>
            </ol>
            <h6 class="mb-2 ml-2 font-bold text-white capitalize">Bulk SMS</h6>
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
                    <livewire:table.sms-blast-table searchable="{{auth()->user()->super->first()->role == 'superadmin' ? 'user_id, status, created_at':'status, msisdn, created_at, message_content'" exportable />
                </div>
            </div>
        </div>
    </div>
    @include('navigation.footer')
</div>
@endsection
