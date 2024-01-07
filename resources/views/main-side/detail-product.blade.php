@extends('layouts.side-menu')

@section('title', 'Project Details')

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
                <li class="leading-normal text-sm">
                    <a class="text-white opacity-50" href="javascript:;">User</a>
                </li>
                <li class="text-sm pl-2 capitalize leading-normal before:float-left before:pr-2 before:content-['/']"
                    aria-current="page">Project</li>
            </ol>
            <h6 class="mb-2 ml-2 font-bold text-white capitalize">Details</h6>
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
</div>

<div class="w-full p-6 mx-auto">
    <div class="flex flex-wrap -mx-3 my-3 pb-3">
        <div class="w-full max-w-full px-3 shrink-0 lg:flex-0 lg:w-6/12">
            <h4 class="dark:text-white">{{$data->name}}</h4>
        </div>
        <div class="flex flex-col justify-center w-full max-w-full px-3 text-right shrink-0 lg:flex-0 lg:w-6/12">
            @livewire('view-log', ['id'=>$data->id, 'model'=>'Stock'])
        </div>
    </div>
    <div>
        @livewire('commercial.item.edit', ['code'=>$data->id, 'theme'=>1])
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ url('assets/js/multisteps-form.js') }}"></script>
@endsection
