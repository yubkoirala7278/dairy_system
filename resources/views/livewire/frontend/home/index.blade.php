@extends('livewire.frontend.layouts.master')
@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid px-0 mb-5" wire:ignore>
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('frontend_assets/img/carousel-1.jpg') }}" alt="Image" >
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-8 text-start">
                                    <p class="fs-4 text-white">हाम्रो डेरी फार्ममा स्वागत छ</p>
                                    <h1 class="display-1 text-white mb-5 animated slideInRight">डेरी उत्पादनहरूको फार्म
                                    </h1>
                                    <a href=""
                                        class="btn btn-secondary rounded-pill py-3 px-5 animated slideInRight">अधिक
                                        हेर्नुहोस्</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('frontend_assets/img/carousel-2.jpg') }}" alt="Image"
                        >
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-end">
                                <div class="col-lg-8 text-end">
                                    <p class="fs-4 text-white">हाम्रो डेरी फार्ममा स्वागत छ</p>
                                    <h1 class="display-1 text-white mb-5 animated slideInRight">सबैभन्दा राम्रो
                                        अर्ग्यानिक डेरी उत्पादनहरू</h1>
                                    <a href=""
                                        class="btn btn-secondary rounded-pill py-3 px-5 animated slideInLeft">अधिक
                                        हेर्नुहोस्</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-xxl py-5" wire:ignore>
        <div class="container">
            <div class="row g-5 align-items-end">
                <div class="col-lg-6">
                    <div class="row g-2">
                        <div class="col-6 position-relative wow fadeIn" data-wow-delay="0.7s">
                            <div class="about-experience bg-secondary rounded">
                                <h1 class="display-1 mb-0">२५</h1>
                                <small class="fs-5 fw-bold">वर्षको अनुभव</small>
                            </div>
                        </div>
                        <div class="col-6 wow fadeIn" data-wow-delay="0.1s">
                            <img class="img-fluid rounded" src="{{ asset('frontend_assets/img/service-1.jpg') }}"
                                >
                        </div>
                        <div class="col-6 wow fadeIn" data-wow-delay="0.3s">
                            <img class="img-fluid rounded" src="{{ asset('frontend_assets/img/service-2.jpg') }}"
                                >
                        </div>
                        <div class="col-6 wow fadeIn" data-wow-delay="0.5s">
                            <img class="img-fluid rounded" src="{{ asset('frontend_assets/img/service-3.jpg') }}"
                                >
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <p class="section-title bg-white text-start text-primary pe-3">हाम्रो बारेमा</p>
                    <p class="mb-4">हाम्रो डेरी फार्मको स्थापना २५ वर्ष अघि भएको हो, जहाँ हामी उत्कृष्ट र शुद्ध
                        अर्ग्यानिक डेरी उत्पादनहरू उपलब्ध गराउँदै आएका छौं। हामीप्रति ग्राहकको विश्वास र सन्तुष्टि नै
                        हाम्रो प्रमुख लक्ष्य हो। हाम्रो फार्ममा हाम्रो पालनपोषण गरिएको गायहरू उच्च गुणस्तरको दूध उत्पादन
                        गर्नेछन्, जसले हामीलाई सर्वोत्तम डेरी उत्पादनहरू प्रदान गर्न सक्षम बनाउँछ। हाम्रो इतिहास भनेको
                        निरन्तर प्रयास र साँचो परिश्रमको प्रतीक हो, जसले आज हामीलाई डेरी उद्योगमा सम्मानित स्थानमा
                        पुर्याएको छ।</p>
                    <div class="row g-5 pt-2 mb-5">
                        <div class="col-sm-6">
                            <img class="img-fluid mb-4" src="{{ asset('frontend_assets/img/service.png') }}" alt=""
                                >
                            <h5 class="mb-3">समर्पित सेवा</h5>
                            <span>हामी हाम्रो ग्राहकलाई उत्कृष्ट र शुद्ध अर्ग्यानिक डेरी उत्पादनहरू प्रदान गर्न समर्पित
                                छौं। हाम्रो सेवाले गुणस्तर र विश्वसनीयता सुनिश्चित गर्दछ, जसले ग्राहकलाई सन्तुष्टि र
                                भरपर्दो अनुभव प्रदान गर्दछ।</span>
                        </div>
                        <div class="col-sm-6">
                            <img class="img-fluid mb-4" src="{{ asset('frontend_assets/img/product.png') }}" alt=""
                                >
                            <h5 class="mb-3">अर्ग्यानिक उत्पादनहरू</h5>
                            <span>हामी केवल शुद्ध र प्राकृतिक अर्ग्यानिक डेरी उत्पादनहरू मात्र प्रदान गर्दछौं। हाम्रो
                                उत्पादनमा कुनै रासायनिक तत्वको प्रयोग नगरी, स्वस्थ र पोषक तत्वयुक्त दूध र अन्य डेरी
                                उत्पादनहरू सुनिश्चित गरिएको छ।</span>

                        </div>
                    </div>
                    <a class="btn btn-secondary rounded-pill py-3 px-5" href="">अधिक हेर्नुहोस्</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Features Start -->
    <div class="container-xxl py-5" wire:ignore>
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title bg-white text-start text-primary pe-3">हामीलाई किन चयन गर्ने?</p>
                    <h1 class="mb-4">हामीलाई किन चयन गर्ने केही कारणहरू!</h1>
                    <p class="mb-4">हामीसँग २५ वर्षको अनुभव र शुद्ध अर्ग्यानिक डेरी उत्पादनहरूको लागि समर्पण छ।
                        हाम्रो ग्राहकहरूको सन्तुष्टि र विश्वास नै हाम्रो प्रमुख उद्देश्य हो। हामी निरन्तर उच्च गुणस्तरीय
                        उत्पादन र उत्कृष्ट सेवाको लागि प्रयासरत छौं।</p>
                    <p><i class="fa fa-check text-primary me-3"></i>शुद्ध अर्ग्यानिक उत्पादनहरू</p>
                    <p><i class="fa fa-check text-primary me-3"></i>उच्च गुणस्तर र विश्वसनीयता</p>
                    <p><i class="fa fa-check text-primary me-3"></i>ग्राहकको सन्तुष्टि र विश्वास</p>
                    <a class="btn btn-secondary rounded-pill py-3 px-5 mt-3" href="">अधिक हेर्नुहोस्</a>

                </div>
                <div class="col-lg-6">
                    <div class="rounded overflow-hidden">
                        <div class="row g-0">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <div class="text-center bg-primary py-5 px-4">
                                    <img class="img-fluid mb-4" src="{{ asset('frontend_assets/img/experience.png') }}"
                                        alt="" >
                                    <h1 class="display-6 text-white" data-toggle="counter-up">25</h1>
                                    <span class="fs-5 fw-semi-bold text-secondary">वर्षको अनुभव</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="text-center bg-secondary py-5 px-4">
                                    <img class="img-fluid mb-4" src="{{ asset('frontend_assets/img/award.png') }}"
                                        alt="" >
                                    <h1 class="display-6" data-toggle="counter-up">145</h1>
                                    <span class="fs-5 fw-semi-bold text-primary">पुरस्कार जितेको</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="text-center bg-secondary py-5 px-4">
                                    <img class="img-fluid mb-4" src="{{ asset('frontend_assets/img/animal.png') }}"
                                        alt="" >
                                    <h1 class="display-6" data-toggle="counter-up">153</h1>
                                    <span class="fs-5 fw-semi-bold text-primary">कुल जनावरहरू</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <div class="text-center bg-primary py-5 px-4">
                                    <img class="img-fluid mb-4" src="{{ asset('frontend_assets/img/client.png') }}"
                                        alt="" >
                                    <h1 class="display-6 text-white" data-toggle="counter-up">1345</h1>
                                    <span class="fs-5 fw-semi-bold text-secondary">खुशी ग्राहकहरू</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->


    <!-- Banner Start -->
    <div class="container-fluid banner my-5 py-5" data-parallax="scroll"
        data-image-src="{{ asset('frontend_assets/img/banner.jpg') }}" wire:ignore>
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.3s">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm-4">
                            <img class="img-fluid rounded" src="{{ asset('frontend_assets/img/banner-1.jpg') }}"
                                alt="" >
                        </div>
                        <div class="col-sm-8">
                            <h2 class="text-white mb-3">हामी उत्कृष्ट डेरी उत्पादनहरू बेच्दछौं</h2>
                            <p class="text-white mb-4">हामी शुद्ध र उच्च गुणस्तरीय डेरी उत्पादनहरू प्रदान गर्छौं, जसले
                                तपाईंलाई स्वस्थ र पोषक तत्वयुक्त विकल्प प्रदान गर्दछ।</p>
                            <a class="btn btn-secondary rounded-pill py-2 px-4" href="">थप पढ्नुहोस्</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm-4">
                            <img class="img-fluid rounded" src="{{ asset('frontend_assets/img/banner-2.jpg') }}"
                                alt="" >
                        </div>
                        <div class="col-sm-8">
                            <h2 class="text-white mb-3">हामी नेपालभरि ताजा दूध पुर्याउँछौं</h2>
                            <p class="text-white mb-4">हामी शुद्ध र ताजा दूध प्रदान गर्दछौं, जसले तपाईंलाई उच्च
                                गुणस्तरको दूधको अनुभव दिलाउँछ, जुन तपाईंको स्वास्थ्य र पोषणका लागि उत्तम हो।</p>
                            <a class="btn btn-secondary rounded-pill py-2 px-4" href="">थप पढ्नुहोस्</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->


    <!-- Service Start -->
    <div class="container-xxl py-5" wire:ignore>
        <div class="container">
            <div class="text-center mx-auto pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">हाम्रो सेवाहरू</p>
                <h1 class="mb-5">उद्यमीहरूको लागि हामीले प्रदान गर्ने सेवा</h1>
            </div>
            <div class="row gy-5 gx-4">
                <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item d-flex h-100">
                        <div class="service-img">
                            <img class="img-fluid" src="{{ asset('frontend_assets/img/service-1.jpg') }}" alt=""
                                >
                        </div>
                        <div class="service-text p-5 pt-0">
                            <div class="service-icon">
                                <img class="img-fluid rounded-circle"
                                    src="{{ asset('frontend_assets/img/service-1.jpg') }}" alt=""
                                    >
                            </div>
                            <h5 class="mb-3">सर्वोत्तम जनावर चयन</h5>
                            <p class="mb-4">हामीले उच्च गुणस्तरीय र स्वस्थ जनावरहरूको चयन गरेका छौं, जसले हाम्रो डेरी
                                उत्पादनहरूको गुणस्तरलाई सुनिश्चित गर्दछ।</p>
                            <a class="btn btn-square rounded-circle" href=""><i
                                    class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item d-flex h-100">
                        <div class="service-img">
                            <img class="img-fluid" src="{{ asset('frontend_assets/img/service-2.jpg') }}" alt=""
                                >
                        </div>
                        <div class="service-text p-5 pt-0">
                            <div class="service-icon">
                                <img class="img-fluid rounded-circle"
                                    src="{{ asset('frontend_assets/img/service-2.jpg') }}" alt=""
                                    >
                            </div>
                            <h5 class="mb-3">प्रजनन र पशु चिकित्सक सेवा</h5>
                            <p class="mb-4">हामी प्रजनन प्रक्रियामा उत्कृष्टता र स्वस्थ जनावरहरूको सुनिश्चितता
                                गर्छौं, साथै पशु चिकित्सक सेवाले हाम्रो जनावरहरूको राम्रो स्वास्थ्य र कल्याण सुनिश्चित
                                गर्दछ।</p>
                            <a class="btn btn-square rounded-circle" href=""><i
                                    class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pt-5 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item d-flex h-100">
                        <div class="service-img">
                            <img class="img-fluid" src="{{ asset('frontend_assets/img/service-3.jpg') }}" alt=""
                                >
                        </div>
                        <div class="service-text p-5 pt-0">
                            <div class="service-icon">
                                <img class="img-fluid rounded-circle"
                                    src="{{ asset('frontend_assets/img/service-3.jpg') }}" alt=""
                                    >
                            </div>
                            <h5 class="mb-3">हेरचाह र दुग्ध उत्पादन</h5>
                            <p class="mb-4">हामी हाम्रो जनावरहरूको उत्तम हेरचाह सुनिश्चित गर्दछौं र उच्च गुणवत्ता
                                भएको ताजा दुग्ध उत्पादन गर्न समर्पित छौं।</p>
                            <a class="btn btn-square rounded-circle" href=""><i
                                    class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Testimonial Start -->
    <div class="container-xxl py-5" wire:ignore>
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">साक्षात्कार</p>
                <h1 class="mb-5">हाम्रो डेरी फार्मको बारेमा मानिसहरूले के भनिरहेका छन्</h1>
            </div>
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="testimonial-img">
                        <img class="img-fluid animated pulse infinite"
                            src="{{ asset('frontend_assets/img/testimonial-1.jpg') }}" alt="" >
                        <img class="img-fluid animated pulse infinite"
                            src="{{ asset('frontend_assets/img/testimonial-2.jpg') }}" alt="" >
                        <img class="img-fluid animated pulse infinite"
                            src="{{ asset('frontend_assets/img/testimonial-3.jpg') }}" alt="" >
                        <img class="img-fluid animated pulse infinite"
                            src="{{ asset('frontend_assets/img/testimonial-4.jpg') }}" alt="" >
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="owl-carousel testimonial-carousel">
                        <div class="testimonial-item">
                            <img class="img-fluid mb-3" src="{{ asset('frontend_assets/img/testimonial-1.jpg') }}"
                                alt="" >
                            <p class="fs-5">हामीले यहाँको सेवा प्राप्त गर्दा हाम्रो जीवनमा ठूलो परिवर्तन आएको छ। यस
                                डेरी फार्मले न केवल उत्तम उत्पादन दिन्छ, तर हामीलाई स्वास्थ्य र स्वच्छताको महत्व पनि
                                बुझाएको छ। यहाँका सबै सदस्यहरूको समर्पण र मेहनतको कारण, हामी विश्वास गर्न सक्छौं कि
                                यहाँको उत्पादन सबैभन्दा राम्रो हो।</p>
                            <h5>सारिका शर्मा</h5>
                            <span class="text-primary">ग्राहक</span>
                        </div>
                        <div class="testimonial-item">
                            <img class="img-fluid mb-3" src="{{ asset('frontend_assets/img/testimonial-2.jpg') }}"
                                alt="" >
                            <p class="fs-5">यहाँको सेवा र उत्पादनको गुणस्तर अत्यन्तै राम्रो छ। यो डेरी फार्मले हाम्रो
                                स्वास्थ्य र जीवनशैलीमा सकारात्मक प्रभाव पार्न सफल भएको छ। म सधैं यहाँका उत्पादनलाई
                                प्राथमिकता दिनेछु र अरूसँग पनि सिफारिस गर्नेछु।</p>
                            <h5>प्रकाश यादव</h5>
                            <span class="text-primary">ग्राहक</span>
                        </div>
                        <div class="testimonial-item">
                            <img class="img-fluid mb-3" src="{{ asset('frontend_assets/img/testimonial-3.jpg') }}"
                                alt="" >
                            <p class="fs-5">हामीले यहाँको सेवा र उत्पादनको गुणस्तरको अत्यधिक प्रशंसा गर्छौं। यो डेरी
                                फार्मले उत्कृष्ट दूध र दुग्ध उत्पादन प्रदान गर्दछ, जसले हाम्रो स्वास्थ्यमा सकारात्मक
                                प्रभाव पारेको छ। म यहाँका उत्पादनलाई सबैलाई सिफारिस गर्दछु।</p>
                            <h5>राम बहादुर मगर</h5>
                            <span class="text-primary">ग्राहक</span>
                        </div>
                        <div class="testimonial-item">
                            <img class="img-fluid mb-3" src="{{ asset('frontend_assets/img/testimonial-4.jpg') }}"
                                alt="" >
                            <p class="fs-5">हामीले यहाँको सेवा र उत्पादनको गुणस्तरको अत्यधिक सराहना गर्छौं। डेरी
                                फार्मको उत्पादनले हाम्रो जीवनशैलीमा धेरै सुधार ल्याएको छ र स्वास्थ्यमा सकारात्मक प्रभाव
                                पार्न सफल भएको छ। म यहाँका उत्पादनहरूलाई सबैलाई सिफारिस गर्छु।</p>
                            <h5>शारिका कुमारी</h5>
                            <span class="text-primary">ग्राहक</span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
@endsection

@push('script')
@endpush
