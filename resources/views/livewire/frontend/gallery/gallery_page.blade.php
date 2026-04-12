@extends('livewire.frontend.layouts.master')
@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" wire:ignore>
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">ग्यालरी</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">होम पेज
                    </a></li>
                    <li class="breadcrumb-item"><a href="#">पेजहरू</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ग्यालरी</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Gallery Start -->
    <div class="container-xxl py-5" wire:ignore>
        <div class="container">
            <div class="text-center mx-auto pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">ग्यालरी</p>
                <h1 class="mb-5">हाम्रो डेरी फार्म ग्यालरी अन्वेषण गर्नुहोस्</h1>
            </div>
            <div class="row g-0">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row g-0">
                        <div class="col-12">
                            <a class="d-block" href="{{asset('frontend_assets/img/gallery-5.jpg')}}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{asset('frontend_assets/img/gallery-5.jpg')}}" alt="" loading="lazy">
                            </a>
                        </div>
                        <div class="col-12">
                            <a class="d-block" href="{{asset('frontend_assets/img/gallery-1.jpg')}}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{asset('frontend_assets/img/gallery-1.jpg')}}" alt="" loading="lazy">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="row g-0">
                        <div class="col-12">
                            <a class="d-block" href="{{asset('frontend_assets/img/gallery-2.jpg')}}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{asset('frontend_assets/img/gallery-2.jpg')}}" alt="" loading="lazy">
                            </a>
                        </div>
                        <div class="col-12">
                            <a class="d-block" href="{{asset('frontend_assets/img/gallery-6.jpg')}}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{asset('frontend_assets/img/gallery-6.jpg')}}" alt="" loading="lazy">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row g-0">
                        <div class="col-12">
                            <a class="d-block" href="{{asset('frontend_assets/img/gallery-7.jpg')}}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{asset('frontend_assets/img/gallery-7.jpg')}}" alt="" loading="lazy">
                            </a>
                        </div>
                        <div class="col-12">
                            <a class="d-block" href="{{asset('frontend_assets/img/gallery-3.jpg')}}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{asset('frontend_assets/img/gallery-3.jpg')}}" alt="" loading="lazy">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="row g-0">
                        <div class="col-12">
                            <a class="d-block" href="{{asset('frontend_assets/img/gallery-4.jpg')}}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{asset('frontend_assets/img/gallery-4.jpg')}}" alt="" loading="lazy">
                            </a>
                        </div>
                        <div class="col-12">
                            <a class="d-block" href="{{asset('frontend_assets/img/gallery-8.jpg')}}" data-lightbox="gallery">
                                <img class="img-fluid" src="{{asset('frontend_assets/img/gallery-8.jpg')}}" alt="" loading="lazy">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery End -->
    @endsection


    