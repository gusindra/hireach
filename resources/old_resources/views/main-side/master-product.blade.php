@extends('layouts.side-menu')

@section('title', 'Product Master')

@section('header')
<link href="{{ url('assets/css/datatable.css.css') }}" type="text/css" rel="stylesheet">
@endsection

@section('sidebar')
@parent
<p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <nav class="absolute z-20 flex flex-wrap items-center justify-between w-full px-6 py-2 text-white transition-all shadow-none duration-250 ease-soft-in lg:flex-nowrap lg:justify-start" navbar-profile navbar-scroll="true">
        <div class="flex items-center justify-between w-full px-6 py-1 mx-auto flex-wrap-inherit">
            <nav>
                <ol class="flex flex-wrap pt-1 pr-4 mr-12 bg-transparent rounded-lg sm:mr-16">
                    <li class="text-sm pl-2 capitalize leading-normal before:float-left before:pr-2" aria-current="page">Master Products</li>
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
            @include('navigation.header')
        </div>
    </nav>

    <div class="w-full px-6 mx-auto">
        <div class="min-h-75 relative mt-0 flex items-center overflow-hidden rounded-sm bg-cover bg-center p-0">
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
                        <h5 class="mb-1 dark:text-white">{{auth()->user()->company?auth()->user()->company->name:''}}</h5>
                        <p class="mb-0 font-semibold leading-normal text-sm dark:text-white dark:opacity-60">{{auth()->user()->name}}</p>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mr-0 md:w-1/2 md:flex-none lg:w-4/12">
                    <div class="relative right-0">
                        <ul class="relative flex p-1 list-none bg-transparent rounded-xl" role="list">
                            <li class="z-30 flex-auto text-center">
                                <a class="{{app('request')->input ('display') == 'table'?'':'dark:text-white border'}} border-current z-30 block w-full px-1 py-1 mb-0 transition-all rounded-lg ease-soft-in-out bg-inherit text-slate-700" nav-link active href="{{route('project')}}?v=1" role="tab" aria-selected="true">
                                    <svg class="text-slate-700" width="16px" height="16px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                <g transform="translate(1716.000000, 291.000000)">
                                                    <g transform="translate(603.000000, 0.000000)">
                                                        <path class="fill-slate-800 dark:fill-white" d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z"></path>
                                                        <path class="fill-slate-800 dark:fill-white" d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z" opacity="0.7"></path>
                                                        <path class="fill-slate-800 dark:fill-white" d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z" opacity="0.7"></path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="ml-1 text-sx">Project</span>
                                </a>
                            </li>
                            <li class="z-30 flex-auto text-center">
                                <a class="{{app('request')->input('display') == 'table'?'dark:text-white border':''}} border-current z-30 block w-full px-1 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700" nav-link href="{{route('project')}}?v=1&display=table" role="tab" aria-selected="false">
                                    <svg class="text-slate-700" width="16px" height="16px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <title>table</title>
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                <g transform="translate(1716.000000, 291.000000)">
                                                    <g transform="translate(154.000000, 300.000000)">
                                                        <path class="fill-slate-800 dark:fill-white" d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z" opacity="0.603585379"></path>
                                                        <path class="fill-slate-800 dark:fill-white" d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z"></path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="ml-1 text-sx">Table</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 flex-0">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0 mb-2 pr-1">
                        <div class="lg:flex">
                            <div>
                                <h5 class="mb-0 dark:text-white">All Products</h5>
                                <!-- <p class="mb-0 leading-normal text-sm"> A lightweight, extendable, dependency-free javascript HTML table plugin. </p> -->
                            </div>
                            <div class="my-auto mt-6 ml-auto lg:mt-0">
                                <div class="my-auto ml-auto">

                                    <div
                                        class="px-8 py-2 m-0 text-xs font-bold text-center text-white uppercase align-middle border-0 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                        @livewire('commercial.item.add')</div>
                                    <!-- <button type="button" data-toggle="modal" data-target="#import"
                                        class="inline-block px-8 py-2 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer active:opacity-85 leading-pro text-xs ease-soft-in tracking-tight-soft bg-150 bg-x-25 hover:scale-102 active:shadow-soft-xs border-fuchsia-500 text-fuchsia-500 hover:text-fuchsia-500 hover:opacity-75 hover:shadow-none active:scale-100 active:border-fuchsia-500 active:bg-fuchsia-500 active:text-white hover:active:border-fuchsia-500 hover:active:bg-transparent hover:active:text-fuchsia-500 hover:active:opacity-75">Import</button> -->

                                    <div class="fixed top-0 left-0 hidden w-full h-full overflow-x-hidden overflow-y-auto transition-opacity ease-linear opacity-0 z-sticky outline-0 ps"
                                        id="import" aria-hidden="true">
                                        <div
                                            class="relative w-auto m-2 sm:m-7 pointer-events-none sm:max-w-125 sm:mx-auto lg:mt-48 transition-transform duration-300 ease-soft-out -translate-y-13">
                                            <div
                                                class="relative flex flex-col w-full bg-white border border-solid pointer-events-auto dark:bg-gray-950 bg-clip-padding border-black/20 rounded-xl outline-0">
                                                <div
                                                    class="flex items-center justify-between p-4 border-b border-solid shrink-0 border-slate-100 rounded-t-xl">
                                                    <h5 class="mb-0 leading-normal dark:text-white" id="ModalLabel">
                                                        Import CSV</h5>
                                                    <i class="ml-4 fas fa-upload" aria-hidden="true"></i>
                                                    <button type="button" data-toggle="modal" data-target="#import"
                                                        class="fa fa-close w-4 h-4 ml-auto box-content p-2 text-black dark:text-white border-0 rounded-1.5 opacity-50 cursor-pointer -m-2 "
                                                        data-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                <div class="relative flex-auto p-4">
                                                    <p>You can browse your computer for a file.</p>
                                                    <input type="text" placeholder="Browse file..."
                                                        class="dark:bg-gray-950 mb-4 focus:shadow-soft-primary-outline dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                                    <div class="min-h-6 pl-7 mb-0.5 block">
                                                        <input
                                                            class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                            type="checkbox" value="" id="importCheck" checked="">
                                                        <label
                                                            class="inline-block mb-2 ml-1 font-bold cursor-pointer select-none text-xs text-slate-700 dark:text-white/80"
                                                            for="importCheck">I accept the terms and conditions</label>
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-wrap items-center justify-end p-3 border-t border-solid shrink-0 border-slate-100 rounded-b-xl">
                                                    <button type="button" data-toggle="modal" data-target="#import"
                                                        class="inline-block px-8 py-2 m-1 mb-4 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-to-tl from-slate-600 to-slate-300 shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">Close</button>
                                                    <button type="button"
                                                        class="inline-block px-8 py-2 m-1 mb-4 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">Upload</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                        </div>
                                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="flex-auto p-6 px-0 pb-0">
                        <div class="overflow-x-auto table-responsive ps">
                            <div
                                class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                <div class="dataTable-top">
                                    <div class="dataTable-dropdown"><label><select class="dataTable-selector">
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                            </select> entries per page</label></div>
                                    <div class="dataTable-search"><input
                                            class="dataTable-input focus:shadow-soft-primary-outline dark:text-white/80 ease-soft focus:outline-none focus:transition-shadow"
                                            placeholder="Search..." type="text"></div>
                                </div>
                                <div class="dataTable-container">
                                    <table class="table dataTable-table" datatable="" id="products-list">
                                        <thead class="thead-light">
                                            <tr>
                                                <th data-sortable="" style="width: 39.4692%;"><a href="#"
                                                        class="dataTable-sorter">Product</a></th>
                                                <th data-sortable="" style="width: 10.1884%;"><a href="#"
                                                        class="dataTable-sorter">Category</a></th>
                                                <th data-sortable="" style="width: 7.87671%;"><a href="#"
                                                        class="dataTable-sorter">Price</a></th>
                                                <th data-sortable="" style="width: 10.274%;"><a href="#"
                                                        class="dataTable-sorter">SKU</a></th>
                                                <th data-sortable="" style="width: 8.47603%;"><a href="#"
                                                        class="dataTable-sorter">Quantity</a></th>
                                                <th data-sortable="" style="width: 12.5856%;"><a href="#"
                                                        class="dataTable-sorter">Status</a></th>
                                                <th data-sortable="" style="width: 11.2158%;"><a href="#"
                                                        class="dataTable-sorter">Action</a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="flex">
                                                        <div class="my-auto block min-h-6 pl-7">
                                                            <input
                                                                class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                                type="checkbox" id="customCheck1" checked="">
                                                        </div>
                                                        <img class="ml-4 w-1/10"
                                                            src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/adidas-hoodie.jpg"
                                                            alt="hoodie">
                                                        <h6 class="my-auto ml-4 dark:text-white">BKLGO Full Zip Hoodie
                                                        </h6>
                                                    </div>
                                                </td>
                                                <td class="leading-normal text-sm">Clothing</td>
                                                <td class="leading-normal text-sm">$1,321</td>
                                                <td class="leading-normal text-sm">243598234</td>
                                                <td class="leading-normal text-sm">0</td>
                                                <td>
                                                    <span
                                                        class="py-1.8 px-3 text-xxs rounded-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-red-700 bg-red-200">Out
                                                        of Stock</span>
                                                </td>
                                                <td class="leading-normal text-sm">
                                                    <a href="javascript:;">
                                                        <i class="fas fa-eye text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;" class="mx-4">
                                                        <i class="fas fa-user-edit text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;">
                                                        <i class="fas fa-trash text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flex">
                                                        <div class="my-auto block min-h-6 pl-7">
                                                            <input
                                                                class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                                type="checkbox" id="customCheck2" checked="">
                                                        </div>
                                                        <img class="ml-4 w-1/10"
                                                            src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/macbook-pro.jpg"
                                                            alt="mac">
                                                        <h6 class="my-auto ml-4 dark:text-white">MacBook Pro</h6>
                                                    </div>
                                                </td>
                                                <td class="leading-normal text-sm">Electronics</td>
                                                <td class="leading-normal text-sm">$1,869</td>
                                                <td class="leading-normal text-sm">877712</td>
                                                <td class="leading-normal text-sm">0</td>
                                                <td>
                                                    <span
                                                        class="py-1.8 px-3 text-xxs rounded-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-red-700 bg-red-200">Out
                                                        of Stock</span>
                                                </td>
                                                <td class="leading-normal text-sm">
                                                    <a href="javascript:;">
                                                        <i class="fas fa-eye text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;" class="mx-4">
                                                        <i class="fas fa-user-edit text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;">
                                                        <i class="fas fa-trash text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flex">
                                                        <div class="my-auto block min-h-6 pl-7">
                                                            <input
                                                                class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                                type="checkbox" id="customCheck3">
                                                        </div>
                                                        <img class="ml-4 w-1/10"
                                                            src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/metro-chair.jpg"
                                                            alt="metro-chair">
                                                        <h6 class="my-auto ml-4 dark:text-white">Metro Bar Stool</h6>
                                                    </div>
                                                </td>
                                                <td class="leading-normal text-sm">Furniture</td>
                                                <td class="leading-normal text-sm">$99</td>
                                                <td class="leading-normal text-sm">0134729</td>
                                                <td class="leading-normal text-sm">978</td>
                                                <td>
                                                    <span
                                                        class="py-1.8 px-3 text-xxs rounded-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-lime-600 bg-lime-200">in
                                                        Stock</span>
                                                </td>
                                                <td class="leading-normal text-sm">
                                                    <a href="javascript:;">
                                                        <i class="fas fa-eye text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;" class="mx-4">
                                                        <i class="fas fa-user-edit text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;">
                                                        <i class="fas fa-trash text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flex">
                                                        <div class="my-auto block min-h-6 pl-7">
                                                            <input
                                                                class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                                type="checkbox" id="customCheck10">
                                                        </div>
                                                        <img class="ml-4 w-1/10"
                                                            src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/alchimia-chair.jpg"
                                                            alt="alchimia">
                                                        <h6 class="my-auto ml-4 dark:text-white">Alchimia Chair</h6>
                                                    </div>
                                                </td>
                                                <td class="leading-normal text-sm">Furniture</td>
                                                <td class="leading-normal text-sm">$2,999</td>
                                                <td class="leading-normal text-sm">113213</td>
                                                <td class="leading-normal text-sm">0</td>
                                                <td>
                                                    <span
                                                        class="py-1.8 px-3 text-xxs rounded-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-red-700 bg-red-200">Out
                                                        of Stock</span>
                                                </td>
                                                <td class="leading-normal text-sm">
                                                    <a href="javascript:;">
                                                        <i class="fas fa-eye text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;" class="mx-4">
                                                        <i class="fas fa-user-edit text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;">
                                                        <i class="fas fa-trash text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flex">
                                                        <div class="my-auto block min-h-6 pl-7">
                                                            <input
                                                                class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                                type="checkbox" id="customCheck5">
                                                        </div>
                                                        <img class="ml-4 w-1/10"
                                                            src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/fendi-coat.jpg"
                                                            alt="fendi">
                                                        <h6 class="my-auto ml-4 dark:text-white">Fendi Gradient Coat
                                                        </h6>
                                                    </div>
                                                </td>
                                                <td class="leading-normal text-sm">Clothing</td>
                                                <td class="leading-normal text-sm">$869</td>
                                                <td class="leading-normal text-sm">634729</td>
                                                <td class="leading-normal text-sm">725</td>
                                                <td>
                                                    <span
                                                        class="py-1.8 px-3 text-xxs rounded-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-lime-600 bg-lime-200">in
                                                        Stock</span>
                                                </td>
                                                <td class="leading-normal text-sm">
                                                    <a href="javascript:;">
                                                        <i class="fas fa-eye text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;" class="mx-4">
                                                        <i class="fas fa-user-edit text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;">
                                                        <i class="fas fa-trash text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flex">
                                                        <div class="my-auto block min-h-6 pl-7">
                                                            <input
                                                                class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                                type="checkbox" id="customCheck6">
                                                        </div>
                                                        <img class="ml-4 w-1/10"
                                                            src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/off-white-jacket.jpg"
                                                            alt="off_white">
                                                        <h6 class="my-auto ml-4 dark:text-white">Off White Cotton Bomber
                                                        </h6>
                                                    </div>
                                                </td>
                                                <td class="leading-normal text-sm">Clothing</td>
                                                <td class="leading-normal text-sm">$1,869</td>
                                                <td class="leading-normal text-sm">634729</td>
                                                <td class="leading-normal text-sm">725</td>
                                                <td>
                                                    <span
                                                        class="py-1.8 px-3 text-xxs rounded-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-lime-600 bg-lime-200">in
                                                        Stock</span>
                                                </td>
                                                <td class="leading-normal text-sm">
                                                    <a href="javascript:;">
                                                        <i class="fas fa-eye text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;" class="mx-4">
                                                        <i class="fas fa-user-edit text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;">
                                                        <i class="fas fa-trash text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flex">
                                                        <div class="my-auto block min-h-6 pl-7">
                                                            <input
                                                                class="w-5 h-5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                                                                type="checkbox" id="customCheck7" checked="">
                                                        </div>
                                                        <img class="ml-4 w-1/10"
                                                            src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/yohji-yamamoto.jpg"
                                                            alt="yohji">
                                                        <h6 class="my-auto ml-4 dark:text-white">Y-3 Yohji Yamamoto</h6>
                                                    </div>
                                                </td>
                                                <td class="leading-normal text-sm">Shoes</td>
                                                <td class="leading-normal text-sm">$869</td>
                                                <td class="leading-normal text-sm">634729</td>
                                                <td class="leading-normal text-sm">725</td>
                                                <td>
                                                    <span
                                                        class="py-1.8 px-3 text-xxs rounded-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-lime-600 bg-lime-200">In
                                                        Stock</span>
                                                </td>
                                                <td class="leading-normal text-sm">
                                                    <a href="javascript:;">
                                                        <i class="fas fa-eye text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;" class="mx-4">
                                                        <i class="fas fa-user-edit text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:;">
                                                        <i class="fas fa-trash text-slate-400 dark:text-white/70"
                                                            aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                                <div class="dataTable-bottom">
                                    <div class="dataTable-info">Showing 1 to 7 of 15 entries</div>
                                    <nav class="dataTable-pagination">
                                        <ul class="dataTable-pagination-list">
                                            <li class="pager"><a href="#" data-page="1">‹</a></li>
                                            <li class="active"><a href="#" data-page="1">1</a></li>
                                            <li class=""><a href="#" data-page="2">2</a></li>
                                            <li class=""><a href="#" data-page="3">3</a></li>
                                            <li class="pager"><a href="#" data-page="2">›</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                            </div>
                        </div>
                    </div> -->
                    <div>
                        <livewire:table.commerce-item exportable companyid="{{auth()->user()->team->team->user->company->id}}" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
    </div>
    <div class="ps__rail-y" style="top: 0px; height: 754px; right: 0px;">
        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 627px;"></div>
    </div>
@endsection
