<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>HiReach - We Reach to All Channel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Telixcel by MGI" />
    <meta name="keywords" content="Chat Templating CMS" />
    <meta name="author" content="Gusindra" />
    <link rel="icon" type="image/png" href="/frontend/images/favicon.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.min.css?v=26112021">
    <link rel="stylesheet" href="frontend/css/cookieconsent.css" media="print" onload="this.media='all'">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black" data-spy="scroll" data-target="#ftco-navbar" data-offset="200">
    
    @if(app('request')->input('page')=='landingpage') 
    <!-- END nav -->
    <video class="w-full fixed top-0 grayscale brightness-50" autoplay muted loop id="myVideo">
        <source src="frontend/images/preview2.mp4" type="video/mp4">
    </video>
    
    <section class="ftco-cover1 ftco-slant1" id="section-home">
        <div class="container">
            <div class="row align-items-center justify-content-center items-center text-center ftc1o-vh-100 mt-48">
                <div class="col-md-12"><div class="text-3xl text-white uppercase">Welcome to</div></div>
                <div class="col-md-12 flex justify-center items-bottom text-center mx-auto mb-20">
                    <img class="logo-white w-64 h-auto" src="https://hireach.archeeshop.com/frontend/images/logo-trans.png" title="HiReach" style="filter: brightness(1000%);">
                </div>
                <div class="col-md-12">
                    <div class="visible" id="ftco-nav">
                        <ul class="navbar-nav1 ml-auto lg:flex  justify-center gap-10">
                            <li class="nav-item text-white"><a href="{{url('/')}}" class="nav-link text-lg hover:bg-white hover:text-black rounded-sm border-4 border-white hover:font-bold px-8">Website</a></li>  
                            <li class="nav-item text-white"><a href="{{url('/api/documentation')}}" class="nav-link text-lg hover:bg-white hover:text-black rounded-sm border-4 border-white hover:font-bold px-8">API Documentation</a></li>
                            @if(auth()->user())
                            <li class="nav-item text-white"><a href="{{url('/dashboard')}}" class="nav-link text-lg hover:bg-white hover:text-black rounded-sm border-4 border-white hover:font-bold px-8">Dashboard</a></li>
                            @else
                            <li class="nav-item text-white"><a href="{{url('/login')}}" class="nav-link text-lg hover:bg-white hover:text-black rounded-sm border-4 border-white hover:font-bold px-8">Login</a></li> 
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @else
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container1 flex">
            <a class="navbar-brand" href="/">
                <img class="logo-white w-50" src="https://hireach.archeeshop.com/frontend/images/logo-trans.png" title="HiReach">
                <img class="logo w-50 hidden" src="https://hireach.archeeshop.com/frontend/images/logo.png" title="HiReach">
            </a>
            <button class="navbar-toggler lg:hidden flex p-1 mt-2" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <svg style="height: 20px;width: 20px;" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <div class="sm:block" style="margin-top: 2px;">Menu</div>
            </button>
        </div>
        <div class="collapse navbar-collapse visible" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="#section-home" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#section-features" class="nav-link">Features</a></li>
                <!-- <li class="nav-item"><a href="#section-pricing" class="nav-link">Pricing</a></li> -->
                <li class="nav-item"><a href="#section-contact" class="nav-link">Contact</a></li>
                <li class="nav-item"><a href="#section-about" class="nav-link">About</a></li>
                <li class="nav-item"><a href="#section-counter" class="nav-link">Services</a></li>
                @if(auth()->user())
                <li class="nav-item"><a href="{{url('/dashboard')}}" class="btn btn-sm btn-outline-white text-slate-100 hover:text-slate-900">Dashboard</a></li>
                @else
                <li class="nav-item"><a href="{{url('/login')}}" class="nav-link">Login</a></li>
                @endif
            </ul>
        </div>
    </nav>
    <!-- END nav -->
    <video class="w-full fixed top-0 grayscale brightness-50" autoplay muted loop id="myVideo">
        <source src="testfrontend/images/preview2.mp4" type="video/mp4">
    </video>
    
    <section class="ftco-cover ftco-slant" style="background-image: url(frontend/images/bg_81.jpg);" id="section-home">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center ftco-vh-100">
                <div class="col-md-12">
                    <h1 class="title-text-2" style="display: none;">REACH OUT TO YOUR CUSTOMERS GLOBALLY ON THEIR PREFERRED CONVERSATION CHANNEL.</h1>
                    <h1 class="title-text-1" style="display: none;">THE BEST TOOLS FOR INSTANT REACH TO BILLION WHATSAPP USERS.</h1>
                    <h1 id="aksen" class="ftco-heading ftco-animate text-right"></h1>
                    <!-- <h2 class="h5 ftco-subheading mb-5 ftco-animate">A free template by <a href="#">Free-Template.co</a></h2> -->
                    <br><br><br>
                    <p class="text-right"><a href="/register" class="btn btn-primary ftco-animate text-center">Get Started</a></p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light  ftco-slant ftco-slant-white" id="section-features">
        <div class="container">

            <div class="row">
                <div class="col-md-12 text-center mb-5 ftco-animate">
                    <h2 class="text-uppercase ftco-uppercase">How it works </h2>
                    <!-- <div class="row justify-content-center">
              <div class="col-md-7">
                <p class="lead">Reach out to your customers globally on their preferred conversation channel across digital devices.</p>
              </div>
            </div> -->
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="media d-block mb-4 text-center ftco-media p-md-5 p-4 ftco-animate">
                        <div class="ftco-icon mb-3 flex justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0">Notification</h5>
                            <small class="mb-5">Alert, Reminders, Ticketing, Digital receipts, Delivery locations.</small>
                            <!-- <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Learn More</a></p> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="media d-block mb-4 text-center ftco-media p-md-5 p-4 ftco-animate">
                        <div class="ftco-icon mb-3 flex justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0">Customer Support</h5>
                            <small class="mb-5">Live chat support, Chat commerce.</small>
                            <!-- <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Learn More</a></p> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="media d-block mb-4 text-center ftco-media p-md-5 p-4 ftco-animate">
                        <div class="ftco-icon mb-3 flex justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0">Authentication</h5>
                            <small class="mb-5">Second Factor of Authentication (2FA).</small>
                            <!-- <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Learn More</a></p> -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="media d-block mb-4 text-center ftco-media p-md-5 p-4 ftco-animate">
                        <div class="ftco-icon mb-3 flex justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0">Educational</h5>
                            <small class="mb-5">Videos, Quizzes, Live chat tutorials.</small>
                            <!-- <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Learn More</a></p> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="media d-block mb-4 text-center ftco-media p-md-5 p-4 ftco-animate">
                        <div class="ftco-icon mb-3 flex justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0">Entertainment</h5>
                            <small class="mb-5">Images, Video trailers, Audio files.</small>
                            <!-- <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Learn More</a></p> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="media d-block mb-4 text-center ftco-media p-md-5 p-4 ftco-animate">
                        <div class="ftco-icon mb-3 flex justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0">Enterprise</h5>
                            <small class="mb-5">Information and Documentation sharing.</small>
                            <!-- <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Learn More</a></p> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="media d-block mb-4 text-center ftco-media p-md-5 p-4 ftco-animate">
                        <div class="ftco-icon mb-3 flex justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3h5m0 0v5m0-5l-6 6M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"></path>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0">Emergency Service</h5>
                            <small class="mb-5">Share real time location.</small>
                            <!-- <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Learn More</a></p> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="media d-block mb-4 text-center ftco-media p-md-5 p-4 ftco-animate">
                        <div class="ftco-icon mb-3 flex justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0">Customization</h5>
                            <small class="mb-5">Other needs.</small>
                            <!-- <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Learn More</a></p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END section -->

    <!-- <section class="ftco-section ftco-slant" id="section-services">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center ftco-animate">
            <h2 class="text-uppercase ftco-uppercase">Services</h2>
            <div class="row justify-content-center mb-5">
              <div class="col-md-7">
                <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 mb-5 ftco-animate">
            <figure><img src="images/img_2.jpg" alt="Free Template by Free-Template.co" class="img-fluid"></figure>
            <div class="p-3">
              <h3 class="h4">Title of Service here</h3>
              <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <ul class="list-unstyled ftco-list-check text-left">
                <li class="d-flex mb-2"><span class="oi oi-check mr-3 text-primary"></span> <span>Free template for designer and developers</span></li>
                <li class="d-flex mb-2"><span class="oi oi-check mr-3 text-primary"></span> <span>Vokalia and consonantia blind texts</span></li>
                <li class="d-flex mb-2"><span class="oi oi-check mr-3 text-primary"></span> <span>Behind the word mountains blind texts</span></li>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 mb-5 ftco-animate">
            <figure><img src="images/img_1.jpg" alt="Free Template by Free-Template.co" class="img-fluid"></figure>
            <div class="p-3">
              <h3 class="h4">Title of Service here</h3>
              <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <ul class="list-unstyled ftco-list-check text-left">
                <li class="d-flex mb-2"><span class="oi oi-check mr-3 text-primary"></span> <span>Free template for designer and developers</span></li>
                <li class="d-flex mb-2"><span class="oi oi-check mr-3 text-primary"></span> <span>Vokalia and consonantia blind texts</span></li>
                <li class="d-flex mb-2"><span class="oi oi-check mr-3 text-primary"></span> <span>Behind the word mountains blind texts</span></li>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 mb-5 ftco-animate">
            <figure><img src="images/img_3.jpg" alt="Free Template by Free-Template.co" class="img-fluid"></figure>
            <div class="p-3">
              <h3 class="h4">Title of Service here</h3>
              <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <ul class="list-unstyled ftco-list-check text-left">
                <li class="d-flex mb-2"><span class="oi oi-check mr-3 text-primary"></span> <span>Free template for designer and developers</span></li>
                <li class="d-flex mb-2"><span class="oi oi-check mr-3 text-primary"></span> <span>Vokalia and consonantia blind texts</span></li>
                <li class="d-flex mb-2"><span class="oi oi-check mr-3 text-primary"></span> <span>Behind the word mountains blind texts</span></li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </section> -->

    <!-- PRICEING -->
    <!-- <section class="ftco-section bg-light ftco-slant ftco-slant-white" id="section-pricing">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center ftco-animate">
            <h2 class="text-uppercase ftco-uppercase">Pricing</h2>
            <div class="row justify-content-center mb-5">
              <div class="col-md-7">
                <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md bg-white p-5 m-2 text-center mb-2 ftco-animate">
            <div class="ftco-pricing">
              <h2>Standard</h2>
              <p class="ftco-price-per text-center"><sup>$</sup><strong>25</strong><span>/mo</span></p>
              <ul class="list-unstyled mb-5">
                <li>Far far away behind the word mountains</li>
                <li>Even the all-powerful Pointing has no control</li>
                <li>When she reached the first hills</li>
              </ul>
              <p><a href="#" class="btn btn-secondary btn-sm">Get Started</a></p>
            </div>
          </div>
          <div class="col-md bg-white p-5 m-2 text-center mb-2 ftco-animate">
            <div class="ftco-pricing">
              <h2>Professional</h2>
              <p class="ftco-price-per text-center"><sup>$</sup><strong>75</strong><span>/mo</span></p>
              <ul class="list-unstyled mb-5">
                <li>Far far away behind the word mountains</li>
                <li>Even the all-powerful Pointing has no control</li>
                <li>When she reached the first hills</li>
              </ul>
              <p><a href="#" class="btn btn-secondary btn-sm">Get Started</a></p>
            </div>
          </div>
          <div class="w-100 clearfix d-xl-none"></div>
          <div class="col-md bg-white  ftco-pricing-popular p-5 m-2 text-center mb-2 ftco-animate">
            <span class="popular-text">Popular</span>
            <div class="ftco-pricing">
              <h2>Silver</h2>
              <p class="ftco-price-per text-center"><sup>$</sup><strong class="text-primary">135</strong><span>/mo</span></p>
              <ul class="list-unstyled mb-5">
                <li>Far far away behind the word mountains</li>
                <li>Even the all-powerful Pointing has no control</li>
                <li>When she reached the first hills</li>
              </ul>
              <p><a href="#" class="btn btn-primary btn-sm">Get Started</a></p>
            </div>
          </div>
          <div class="col-md bg-white p-5 m-2 text-center mb-2 ftco-animate">
            <div class="ftco-pricing">
              <h2>Platinum</h2>
              <p class="ftco-price-per text-center"><sup>$</sup><strong>215</strong><span>/mo</span></p>
              <ul class="list-unstyled mb-5">
                <li>Far far away behind the word mountains</li>
                <li>Even the all-powerful Pointing has no control</li>
                <li>When she reached the first hills</li>
              </ul>
              <p><a href="#" class="btn btn-secondary btn-sm">Get Started</a></p>
            </div>
          </div>
        </div>
      </div>
    </section> -->

    <!-- <section class="ftco-section ftco-slant ftco-slant-light">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center ftco-animate">
            <h2 class="text-uppercase ftco-uppercase">More Features</h2>
            <div class="row justify-content-center mb-5">
              <div class="col-md-7">
                <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="owl-carousel ftco-owl">

              <div class="item ftco-animate">
                <div class="media d-block text-left ftco-media p-md-5 p-4">
                  <div class="ftco-icon mb-3"><span class="oi oi-pencil display-4"></span></div>
                  <div class="media-body">
                    <h5 class="mt-0">Easy to Customize</h5>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                  </div>
                </div>
              </div>

              <div class="item ftco-animate">
                <div class="media d-block text-left ftco-media p-md-5 p-4">
                  <div class="ftco-icon mb-3"><span class="oi oi-monitor display-4"></span></div>
                  <div class="media-body">
                    <h5 class="mt-0">Web Development</h5>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                  </div>
                </div>
              </div>

              <div class="item ftco-animate">
                <div class="media d-block text-left ftco-media p-md-5 p-4">
                  <div class="ftco-icon mb-3"><span class="oi oi-location display-4"></span></div>
                  <div class="media-body">
                    <h5 class="mt-0">Free Bootstrap 4</h5>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                  </div>
                </div>
              </div>

              <div class="item ftco-animate">
                <div class="media d-block text-left ftco-media p-md-5 p-4">
                  <div class="ftco-icon mb-3"><span class="oi oi-person display-4"></span></div>
                  <div class="media-body">
                    <h5 class="mt-0">For People Like You</h5>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section> -->

    <!-- <section class="ftco-section ftco-slant ftco-slant-light  bg-light ftco-slant ftco-slant-white" id="section-faq">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12 text-center ftco-animate">
            <h2 class="text-uppercase ftco-uppercase">FAQ</h2>
            <div class="row justify-content-center mb-5">
              <div class="col-md-7">
                <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-5 ftco-animate">
            <h3 class="h5 mb-4">What is {{ env('APP_NAME')}}?</h3>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <small class="mb-5"><a href="#">Learn More</a></p>
          </div>
          <div class="col-md-6 mb-5 ftco-animate">
            <h3 class="h5 mb-4">Can I upgrade?</h3>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <small class="mb-5"><a href="#">Learn More</a></p>
          </div>
          <div class="col-md-6 mb-5 ftco-animate">
            <h3 class="h5 mb-4">Can I have more than 5 users?</h3>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <small class="mb-5"><a href="#">Learn More</a></p>
          </div>
          <div class="col-md-6 mb-5 ftco-animate">
            <h3 class="h5 mb-4">If I need support who do I contact?</h3>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <small class="mb-5"><a href="#">Learn More</a></p>
          </div>
        </div>
      </div>
    </section> 

    <section class="ftco-section bg-white ftco-slant" id="section-contact">
        <div class="container">
            <div class="row">

                <div class="col-md-3 text-center ftco-animate">
                    <h2 class="text-uppercase text-left ftco-uppercase">Support</h2>
                </div>
                <div class="col-md-9 pr-md-5 mb-5 ftco-animate">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="sr-only">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Name" onchange="myName(this.value)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="sr-only">Phone</label>
                                    <input type="text" class="form-control" id="email" placeholder="Phone" onchange="myContact(this.value)">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="sr-only">Message</label>
                            <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Write your message" onchange="myMessage(this.value)"></textarea>
                        </div>
                        <div class="form-group">
                            <a id="contact_support" class="btn btn-primary" href="mailto:support@telixcel.com?subject=Support%20Telixcel%20from%20Website&body=Name:%0d%0aPhone:%0d%0aMessage:%0d%0a">
                                Send
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section> -->

    <section class="ftco-section bg-light ftco-slant ftco-slant-white" id="section-about">
        <div class="container">

            <div class="row mb-5">
                <div class="col-md-3 text-left ftco-animate">
                    <h2 class="text-uppercase ftco-uppercase">About Us</h2>
                </div>
                <div class="col-md-9 text-center ftco-animate">
                    <div class="rext-right mb-5">
                        <div class="text-left">
                            <p class="lead">HiReach is a Communication Bussiness Solution provider. </p>
                            <br>
                            <p>Vision</p>
                            <ul class="list-disc ml-4">
                                <li>To be the most trusted partner in providing reliable business solutions that adds value to our customers.</li>
                            </ul>
                            <br>
                            <p>Mission</p>
                            <ul class="list-disc ml-4">
                                <li>To provide total solution of Customer Experience Management</li>
                                <li>To add values to client's business</li>
                                <li>To bring tangible benefits to clients</li>
                                <li>To be preferred partner and good place to work</li>
                            </ul>
                            <br>
                            Feel free to send us an email to <a href="mailto:hireach@firmapps.ai">hireach@firmapps.ai </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END row -->

            <!--
        <div class="row no-gutters align-items-center ftco-animate">
          <div class="col-md-6 mb-md-0 mb-5">
            <img src="images/bg_3.jpg" alt="Free Template by Free-Template.co" class="img-fluid">
          </div>
          <div class="col-md-6 p-md-5">
            <h3 class="h3 mb-4">Far far away, behind the word mountains</h3>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <small class="mb-5"><a href="#">Learn More</a></p>
          </div>
        </div>
        <div class="row no-gutters align-items-center ftco-animate">
          <div class="col-md-6 order-md-3 mb-md-0 mb-5">
            <img src="images/bg_1.jpg" alt="Free Template by Free-Template.co" class="img-fluid">
          </div>
          <div class="col-md-6 p-md-5 order-md-1">
            <h3 class="h3 mb-4">Far from the countries Vokalia and Consonantia</h3>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <small class="mb-5"><a href="#">Learn More</a></p>
          </div>
        </div> -->

        </div>
    </section>

    <section class="ftco-section ftco-slant1 ftco-slant-dark1" id="section-counter">
        <div class="container">
            <div class="lg:flex justify-center">
                <div class=" text-center ftco-animate">
                    <h5 class="text-uppercase ftco-uppercase text-white">The Best tool for</h5>
                </div>
                <div class=" text-center ftco-animate w-full lg:w-2/5">
                    <div class="row justify-content-center mb-5">
                        <div class="col-md-7">
                            <h1 class="tool-1" style="display: none;">E-Commerce.</h1>
                            <h1 class="tool-2" style="display: none;">Customer Service.</h1>
                            <h1 class="text-4xl text-white"  id="best"></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END row -->
            <div class="row">
              <div class="col-md ftco-animate">
                <div class="ftco-counter text-center">
                  <span class="ftco-number text-white" data-number="34146">0</span>
                  <span class="ftco-label">Notification Sent</span>
                </div>
              </div>
              <div class="col-md ftco-animate">
                <div class="ftco-counter text-center">
                  <span class="ftco-number text-white" data-number="1239">0</span>
                  <span class="ftco-label">Number of Chat</span>
                </div>
              </div>
              <div class="col-md ftco-animate">
                <div class="ftco-counter text-center">
                  <span class="ftco-number text-white" data-number="124">0</span>
                  <span class="ftco-label">Number of Clients</span>
                </div>
              </div>
            </div> 
        </div>
    </section>



    <footer class="ftco-footer ftco-bg-dark bg-black">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 hidden">
                    <div class="row">
                        <div class="col-md text-center">
                            <div class="ftco-footer-widget mb-4">
                                <h2 class="ftco-heading-2 mb-2 text-white">Our Company</h2>
                                <ul class="list-unstyled text-xs">
                                    <li><a href="#" class="py-2 d-block text-gray-100">Who we are</a></li>
                                    <li><a href="#" class="py-2 d-block">Carrer</a></li>
                                    <li><a href="#" class="py-2 d-block">Polices</a></li>
                                    <li><a href="#" class="py-2 d-block">Hero</a></li>
                                    <li><a href="#" class="py-2 d-block">Stay Safe</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md text-center">
                            <div class="ftco-footer-widget mb-4 ">
                                <h2 class="ftco-heading-2 mb-2 text-white">Our Contact</h2>
                                <ul class="list-unstyled text-xs">
                                    <li><a href="mailto:hireach@firmapps.ai" class="py-2 d-block">Support</a></li>
                                    <li><a href="https://goo.gl/maps/X67teAF98m9YZFhN7" class="py-2 d-block">Offices</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md text-center">
                            <div class="ftco-footer-widget mb-4">
                                <h2 class="ftco-heading-2 mb-2 text-white">Our Matter</h2>
                                <ul class="list-unstyled text-xs">
                                    <li><a href="{{ url('/') }}" class="py-2 d-block">Event</a></li>
                                    <li><a href="{{ url('/') }}" class="py-2 d-block">News</a></li>

                                    @if (Route::has('login'))
                                    @auth
                                    <li><a href="{{ url('/dashboard') }}" class="py-2 d-block">Account</a></li>
                                    @else
                                    <li><a href="{{ route('login') }}" class="py-2 d-block">Log in</a></li>

                                    @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}" class="py-2 d-block">Register</a></li>
                                    @endif
                                    @endauth
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="ftco-footer-widget mb-4 text-center mt-4"> 
                        <h1 class="ftco-heading-21 text-white navbar-brand">
                            <img src="https://hireach.archeeshop.com/frontend/images/logo-trans.png" title="{{ env('APP_NAME')}}" style="width: 200px;-webkit-filter: brightness(1000%); /* Safari 6.0 - 9.0 */
  filter: brightness(1000%);" />
                        </h1>
                        <p class=" text-white">&copy; {{ env('APP_NAME')}} {{date('Y')}}. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @endif
    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#4586ff" />
        </svg></div>


    <script src="https://telixcel.s3.ap-southeast-1.amazonaws.com/frontend/all.js"></script>
    <script defer src="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.8.9/dist/cookieconsent.js"></script>
    <script defer src="frontend/js/cookieconsent-init.js"></script>
    <script src="frontend/js/typeit.js"></script>
    <script>
        var app = document.getElementById('aksen');

        var typewriter1 = new TypeIt(app, {
            loop: true,
            strings: [$('.title-text-1').text(), $('.title-text-2').text()],
            speed: 85,
            nextStringDelay: [1000, 5000],
            startDelay: 1000,
            breakLines: false,
            loopDelay: false,
            cursor: true,
        });

        var tool = document.getElementById('best');

        var typewriter2 = new TypeIt(tool, {
            loop: true,
            strings: [$('.tool-1').text(), $('.tool-2').text()],
            speed: 85,
            nextStringDelay: [1000, 5000],
            startDelay: 1000,
            breakLines: false,
            loopDelay: false,
            cursor: true,
        });

        function myName(val) {
            var url = $('#contact_support').attr('href');
            var new_url = url.replace("Name:", "Name: " + val);
            $('#contact_support').attr('href', new_url);

        }

        function myContact(val) {
            var url = $('#contact_support').attr('href');
            var new_url = url.replace("Phone:", "Phone: " + val);
            $('#contact_support').attr('href', new_url);
        }

        function myMessage(val) {
            var url = $('#contact_support').attr('href');
            var new_url = url.replace("Message:", "Message: " + val);
            $('#contact_support').attr('href', new_url);
        }
    </script>
</body>

</html>
