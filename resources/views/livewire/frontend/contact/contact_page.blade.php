@extends('livewire.frontend.layouts.master')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" wire:ignore>
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">सम्पर्क</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">होम पेज</a></li>
                    <li class="breadcrumb-item"><a href="#">पेजहरू</a></li>
                    <li class="breadcrumb-item active" aria-current="page">सम्पर्क</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-xxl py-5" wire:ignore>
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">सम्पर्क गर्नुहोस्</p>
                <h1 class="mb-5">तपाईंलाई कुनै पनि जिज्ञासा भएमा, कृपया हामीसँग सम्पर्क गर्नुहोस्।</h1>

            </div>
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h3 class="mb-4">हामीसँग सहज र द्रुत सम्पर्क गर्न चाहनुहुन्छ?</h3>
                    <p class="mb-4">हाम्रो सम्पर्क फारमले तपाईंलाई छिटो र सजिलै हाम्रो सम्पर्कमा ल्याउँछ। तपाईंको
                        सन्देशलाई हामीलाई
                        तुरुन्तै पुर्‍याउनको लागि यो फारम प्रयोग गर्नुहोस् र हामी तपाईलाई चाँडै प्रतिक्रिया दिनेछौं। यो सरल,
                        प्रभावकारी र सहज हुनेछ। <a href="https://htmlcodex.com/contact-form">अहिले डाउनलोड गर्नुहोस्</a> र
                        आफ्नो सन्देश पठाउने प्रक्रिया अझ सजिलो बनाउनुहोस्।</p>

                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" placeholder="तपाईंको नाम">
                                    <label for="name">तपाईंको नाम</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="तपाईंको इमेल">
                                    <label for="email">तपाईंको इमेल</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="subject" placeholder="विषय">
                                    <label for="subject">विषय</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="यहाँ सन्देश लेख्नुहोस्" id="message" style="height: 250px"></textarea>
                                    <label for="message">सन्देश</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-secondary rounded-pill py-3 px-5" type="submit">सन्देश
                                    पठाउनुहोस्</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <h3 class="mb-4">सम्पर्क विवरण</h3>
                    <div class="d-flex border-bottom pb-3 mb-3">
                        <div class="flex-shrink-0 btn-square bg-secondary rounded-circle">
                            <i class="fa fa-map-marker-alt text-body"></i>
                        </div>
                        <div class="ms-3">
                            <h6>हाम्रो कार्यालय</h6>
                            <span>महुली, सप्तरी, नेपाल</span>
                        </div>
                    </div>
                    <div class="d-flex border-bottom pb-3 mb-3">
                        <div class="flex-shrink-0 btn-square bg-secondary rounded-circle">
                            <i class="fa fa-phone-alt text-body"></i>
                        </div>
                        <div class="ms-3">
                            <h6>हामीलाई कल गर्नुहोस्</h6>
                            <span>+०१२ ३४५ ६७८९०</span>
                        </div>
                    </div>
                    <div class="d-flex border-bottom-0 pb-3 mb-3">
                        <div class="flex-shrink-0 btn-square bg-secondary rounded-circle">
                            <i class="fa fa-envelope text-body"></i>
                        </div>
                        <div class="ms-3">
                            <h6>हामीलाई इमेल गर्नुहोस्</h6>
                            <span>info@example.com</span>
                        </div>
                    </div>

                   
                    <iframe class="w-100 rounded"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2380.0958542068424!2d86.81929271138009!3d26.644818955612834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1731411463943!5m2!1sen!2snp"
                        style="min-height: 300px; border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" frameborder="0" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact End -->
@endsection
