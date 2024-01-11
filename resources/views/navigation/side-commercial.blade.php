<li class="w-full mt-4">
                <h6 class="pl-6 ml-2 font-bold leading-tight uppercase text-xs opacity-60 dark:text-white">Commercial
                </h6>
            </li>

            <li class="mt-0.5 w-full">
                <a collapse_trigger="primary" href="{{ route('commercial.show', ['item']) }}?v=1"
                    class="{{request()->routeIs('commercial.show', ['item'])?'rounded-lg bg-white xl:shadow-soft-xl font-semibold text-slate-700':'font-medium text-slate-500'}} ease-soft-in-out text-sm py-2.7 active after:ease-soft-in-out after:font-awesome-5-free my-0 mx-4 flex items-center whitespace-nowrap px-4 font-medium text-slate-500 shadow-none transition-colors after:ml-auto after:inline-block after:font-bold after:text-slate-800/50 after:antialiased after:transition-all after:duration-200 dark:text-white dark:opacity-80 dark:after:text-white/50 dark:after:text-white"
                    aria-controls="ecommerceExamples" role="button" aria-expanded="false">
                    <div
                        class="{{request()->routeIs('commercial.show', ['item'])?'bg-gradient-to-tl from-gray-900 to-slate-800':''}} stroke-none shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current p-2.5 text-center text-black">
                        <svg class="text-dark" width="12px" height="12px" viewBox="0 0 42 44" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>product master</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1869.000000, -741.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g id="billings" transform="translate(153.000000, 450.000000)">
                                            <path
                                                class="{{request()->routeIs('commercial.show', ['item'])?'':'fill-slate-800'}}"
                                                d="M34.080375,13.125 L27.3748125,1.9490625 C27.1377583,1.53795093 26.6972449,1.28682264 26.222716,1.29218729 C25.748187,1.29772591 25.3135593,1.55890827 25.0860125,1.97535742 C24.8584658,2.39180657 24.8734447,2.89865282 25.1251875,3.3009375 L31.019625,13.125 L10.980375,13.125 L16.8748125,3.3009375 C17.1265553,2.89865282 17.1415342,2.39180657 16.9139875,1.97535742 C16.6864407,1.55890827 16.251813,1.29772591 15.777284,1.29218729 C15.3027551,1.28682264 14.8622417,1.53795093 14.6251875,1.9490625 L7.919625,13.125 L0,13.125 L0,18.375 L42,18.375 L42,13.125 L34.080375,13.125 Z"
                                                opacity="0.595377604"></path>
                                            <path
                                                class="{{request()->routeIs('commercial.show', ['item'])?'':'fill-slate-800'}}"
                                                d="M3.9375,21 L3.9375,38.0625 C3.9375,40.9619949 6.28800506,43.3125 9.1875,43.3125 L32.8125,43.3125 C35.7119949,43.3125 38.0625,40.9619949 38.0625,38.0625 L38.0625,21 L3.9375,21 Z M14.4375,36.75 L11.8125,36.75 L11.8125,26.25 L14.4375,26.25 L14.4375,36.75 Z M22.3125,36.75 L19.6875,36.75 L19.6875,26.25 L22.3125,26.25 L22.3125,36.75 Z M30.1875,36.75 L27.5625,36.75 L27.5625,26.25 L30.1875,26.25 L30.1875,36.75 Z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span
                        class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft {{request()->routeIs('commercial.show', ['item'])?'text-slate-700':''}}">Master
                        Data</span>
                </a>
            </li>