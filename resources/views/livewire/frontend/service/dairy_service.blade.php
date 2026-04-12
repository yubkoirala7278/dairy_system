@extends('livewire.frontend.layouts.master')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">सेवाहरू</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">होम पेज
                    </a></li>
                    <li class="breadcrumb-item"><a href="#">पेजहरू</a></li>
                    <li class="breadcrumb-item active" aria-current="page">सेवाहरू</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">हाम्रा सेवाहरू</p>
                <h1 class="mb-5">उद्यमीहरूको लागि हामीले प्रदान गर्ने सेवाहरू</h1>
            </div>
            <div class="row gy-5 gx-4">
                <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item d-flex h-100">
                        <div class="service-img">
                            <img class="img-fluid" src="{{asset('frontend_assets/img/service-1.jpg')}}" alt="" loading="lazy">
                        </div>
                        <div class="service-text p-5 pt-0">
                            <div class="service-icon">
                                <img class="img-fluid rounded-circle" src="{{asset('frontend_assets/img/service-1.jpg')}}" alt="" loading="lazy">
                            </div>
                            <h5 class="mb-3">उत्तम पशु चयन</h5>
                            <p class="mb-4">उत्तम उत्पादनको लागि स्वस्थ र उपयुक्त पशुको छनोट गरिन्छ। हामी तपाईंलाई गुणस्तरीय, स्वस्थ, 
                            र उच्च उत्पादन क्षमताका पशुहरूको छनोटमा मार्गदर्शन गर्दछौं, जसले तपाईंको व्यवसायलाई उन्नति दिलाउँछ।</p>
                            
                                <a class="btn btn-square rounded-circle" href=""><i
                                        class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item d-flex h-100">
                        <div class="service-img">
                            <img class="img-fluid" src="{{asset('frontend_assets/img/service-2.jpg')}}" alt="" loading="lazy">
                        </div>
                        <div class="service-text p-5 pt-0">
                            <div class="service-icon">
                                <img class="img-fluid rounded-circle" src="{{asset('frontend_assets/img/service-2.jpg')}}" alt="" loading="lazy">
                            </div>
                            <h5 class="mb-3">प्रजनन र पशु उपचार सेवा</h5>
                            <p class="mb-4">स्वस्थ र उन्नत प्रजननको लागि विशेषज्ञ प्रजनन सेवा र नियमित पशु स्वास्थ्य जाँच। हामी तपाईंका 
                            पशुहरूको सम्पूर्ण स्वास्थ्य र उत्पादनशीलता सुनिश्चित गर्न उच्च गुणस्तरको पशु उपचार र परामर्श सेवा प्रदान गर्छौं।</p>
                            
                            <a class="btn btn-square rounded-circle" href=""><i
                                    class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item d-flex h-100">
                        <div class="service-img">
                            <img class="img-fluid" src="{{asset('frontend_assets/img/service-3.jpg')}}" alt="" loading="lazy">
                        </div>
                        <div class="service-text p-5 pt-0">
                            <div class="service-icon">
                                <img class="img-fluid rounded-circle" src="{{asset('frontend_assets/img/service-3.jpg')}}" alt="" loading="lazy">
                            </div>
                            <h5 class="mb-3">हेरचाह र दुहुन सेवा</h5>
                            <p class="mb-4">पशुको उचित हेरचाह र स्वस्थ दुहुन प्रक्रियाका लागि हाम्रो विशेष सेवा। हामी सुनिश्चित गर्छौं कि 
                            दूध उत्पादन स्वस्थ, स्वच्छ, र उच्च गुणस्तरको होस्, जसले तपाईंको व्यवसायलाई लाभदायक बनाउँछ।</p>
                            
                            <a class="btn btn-square rounded-circle" href=""><i
                                    class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Features Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title bg-white text-start text-primary pe-3">किन हाम्रो सेवा छान्ने?</p>
                    <h1 class="mb-4">केहि कारणहरू, जसले गर्दा हामीलाई रोज्नुभयो!</h1>
                    <p class="mb-4">हाम्रो सेवाले समयको बचत, उच्च गुणस्तर, र व्यवसायमा सफलता दिलाउँछ। हामी विश्वसनीय र गुणस्तरीय समाधानहरू प्रदान गर्छौं जसले तपाईंको कामलाई अझ सरल र प्रभावकारी बनाउँछ।</p>
                    <p><i class="fa fa-check text-primary me-3"></i>उच्च गुणस्तरीय सेवा र परामर्श</p>
                    <p><i class="fa fa-check text-primary me-3"></i>समयमै सेवा र विश्वासिलो सहयोग</p>
                    <p><i class="fa fa-check text-primary me-3"></i>उद्यमशीलता र नविन प्रविधिको प्रयोग</p>
                    <a class="btn btn-secondary rounded-pill py-3 px-5 mt-3" href="">थप जान्नुहोस्</a>
                </div>
                <div class="col-lg-6">
                    <div class="rounded overflow-hidden">
                        <div class="row g-0">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <div class="text-center bg-primary py-5 px-4">
                                    <img class="img-fluid mb-4" src="{{asset('frontend_assets/img/experience.png')}}" alt="" loading="lazy">
                                    <h1 class="display-6 text-white" data-toggle="counter-up">25</h1>
                                    <span class="fs-5 fw-semi-bold text-secondary">वर्षको अनुभव</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="text-center bg-secondary py-5 px-4">
                                    <img class="img-fluid mb-4" src="{{asset('frontend_assets/img/award.png')}}" alt="" loading="lazy">
                                    <h1 class="display-6" data-toggle="counter-up">183</h1>
                                    <span class="fs-5 fw-semi-bold text-primary">पुरस्कार प्राप्त</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="text-center bg-secondary py-5 px-4">
                                    <img class="img-fluid mb-4" src="{{asset('frontend_assets/img/animal.png')}}" alt="" loading="lazy">
                                    <h1 class="display-6" data-toggle="counter-up">2619</h1>
                                    <span class="fs-5 fw-semi-bold text-primary">कुल पशु संख्या</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <div class="text-center bg-primary py-5 px-4">
                                    <img class="img-fluid mb-4" src="{{asset('frontend_assets/img/client.png')}}" alt="" loading="lazy">
                                    <h1 class="display-6 text-white" data-toggle="counter-up">51940</h1>
                                    <span class="fs-5 fw-semi-bold text-secondary">खुसी ग्राहकहरू</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->
@endsection
