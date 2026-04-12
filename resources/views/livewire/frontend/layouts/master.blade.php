<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>आदर्श डेरी</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">


    <!-- Favicon -->
    <link href="{{ asset('backend_assets/img/logo.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Open+Sans:wght@400;500;600&display=swap"
        rel="stylesheet"> --}}

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('frontend_assets/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend_assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend_assets/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend_assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('frontend_assets/css/style.css') }}" rel="stylesheet">

    {{-- nelify --}}
    <script src="https://unpkg.com/nepalify"></script>
    {{-- style --}}
    <link rel="stylesheet" href="{{ asset('backend_assets/css/style.css') }}">

    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @toastifyCss
    @yield('custom-style')
    <style>
        .modal-backdrop {
            background-color: transparent !important;
            z-index: 0;
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div wire:ignore id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-dark px-0" wire:ignore>
        <div class="row g-0 d-none d-lg-flex">
            <div class="col-lg-6 ps-5 text-start">
                <div class="h-100 d-inline-flex align-items-center text-light">
                    <span class="me-2">सम्पर्क नम्बर : </span>
                    {{-- <a class="btn btn-link text-light" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-instagram"></i></a> --}}
                    <span>९८०४७२६६४०</span>
                </div>
            </div>
            <div class="col-lg-6 text-end">
                <div class="h-100 bg-secondary d-inline-flex align-items-center text-dark py-2 px-4">
                    <span class="me-2 fw-semi-bold"><i class="fa fa-user me-2"></i>कृषकको नाम:</span>
                    <span>{{ Auth::user()->owner_name }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg  navbar-light sticky-top px-4 px-lg-5"
        style="background-color: #F7FCFF !important">
        <a href="{{ route('frontend.home') }}" class="navbar-brand d-flex align-items-center">
            <h1 class="m-0">आदर्श डेरी</h1>
        </a>
        <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0 align-items-center">
                <a href="{{ route('frontend.home') }}"
                    class="nav-item nav-link {{ $page == 'home' ? 'active' : '' }}">होम
                    पेज</a>
                <a href="{{ route('frontend.service') }}"
                    class="nav-item nav-link {{ $page == 'service' ? 'active' : '' }}">सेवाहरू</a>
                <a href="{{ route('frontend.product') }}"
                    class="nav-item nav-link {{ $page == 'product' ? 'active' : '' }}">उत्पादनहरू</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $page == 'pages' ? 'active' : '' }}"
                        data-bs-toggle="dropdown">पेजहरू</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="{{ route('frontend.my-order') }}"
                            class="dropdown-item {{ $sub_page == 'order' ? 'active' : '' }}">मेरो अर्डरहरू</a>
                        <a href="{{ route('frontend.my-milk-deposit-reports') }}"
                            class="dropdown-item {{ $sub_page == 'milk_deposit_report' ? 'active' : '' }}">दूध संकलन
                            रिपोर्ट</a>
                            <a href="{{ route('frontend.my-cash-deposit-reports') }}"
                            class="dropdown-item {{ $sub_page == 'cash_deposit_report' ? 'active' : '' }}">नगद निक्षेप
                            रिपोर्ट</a>
                        <a href="{{ route('frontend.my-cash-withdraw-reports') }}"
                            class="dropdown-item {{ $sub_page == 'cash_withdraw_report' ? 'active' : '' }}">नगद निकासी
                            रिपोर्ट</a>
                        <a href="{{ route('frontend.gallery') }}"
                            class="dropdown-item {{ $sub_page == 'gallery' ? 'active' : '' }}">ग्यालेरी</a>
                        <a href="{{ route('frontend.team') }}"
                            class="dropdown-item {{ $sub_page == 'team' ? 'active' : '' }}">कर्मचारी र सञ्चालक</a>
                    </div>
                </div>
                <a href="{{ route('frontend.contact') }}"
                    class="nav-item nav-link {{ $page == 'contact' ? 'active' : '' }}">सम्पर्क</a>
                <a href="{{ route('frontend.cart') }}"
                    class="nav-item nav-link {{ $page == 'cart' ? 'active' : '' }}">कार्ट</a>
                <a href="{{ route('frontend.profile') }}"
                    class="nav-item nav-link {{ $page == 'profile' ? 'active' : '' }}">प्रोफाइल</a>
                @livewire('frontend.logout-button')
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    @yield('content')

    @yield('modal')


    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s" wire:ignore>
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">हाम्रो कार्यालय</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>महुली, सप्तरी, नेपाल</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>९८०४७२६६४०</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>aadarshadairy@example.com</p>
                    <div class="d-flex pt-3">
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i
                                class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-secondary rounded-circle me-2" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">छिटो लिङ्कहरू</h5>
                    <a class="btn btn-link" href="">हाम्रो बारेमा</a>
                    <a class="btn btn-link" href="">हामीलाई सम्पर्क गर्नुहोस्</a>
                    <a class="btn btn-link" href="">हाम्रा सेवाहरू</a>
                    <a class="btn btn-link" href="">शर्त र अवस्था</a>
                    <a class="btn btn-link" href="">सपोर्ट</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">कार्यालय समय</h5>
                    <p class="mb-1">सोमबार - शुक्रबार</p>
                    <h6 class="text-light">पूर्वाह्न ०९:०० बजे - बेलुका ०७:०० बजे</h6>
                    <p class="mb-1">शनिबार</p>
                    <h6 class="text-light">पूर्वाह्न ०९:०० बजे - अपराह्न १२:०० बजे</h6>
                    <p class="mb-1">आइतबार</p>
                    <h6 class="text-light">बन्द</h6>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">हाम्रो डेरी सेवाहरू</h5>
                    <p>हामी उत्कृष्ट गुणस्तरका दूध र डेरी उत्पादनहरू प्रदान गर्दछौं। हाम्रो डेरी उत्पादनहरू तपाईंको
                        स्वास्थ्य र स्वादका लागि उत्तम छन्।</p>
                    {{-- <div class="position-relative w-100">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="तपाईंको इमेल">
                        <button type="button" class="btn btn-secondary py-2 position-absolute top-0 end-0 mt-2 me-2">सहयोगको लागि सम्पर्क गर्नुहोस्</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid bg-secondary text-body copyright py-4" wire:ignore>
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="fw-semi-bold" href="#">Your Site Name</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a class="fw-semi-bold" href="https://htmlcodex.com">HTML Codex</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <div wire:ignore>



        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('frontend_assets/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('frontend_assets/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('frontend_assets/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('frontend_assets/lib/owlcarousel/owl.carousel.js') }}"></script>
        <script src="{{ asset('frontend_assets/lib/counterup/counterup.min.js') }}"></script>
        <script src="{{ asset('frontend_assets/lib/parallax/parallax.min.js') }}"></script>
        <script src="{{ asset('frontend_assets/lib/lightbox/js/lightbox.min.js') }}"></script>

        <!-- Template Javascript -->
        <script src="{{ asset('frontend_assets/js/main.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('.translate-nepali');

                inputs.forEach(input => {
                    input.addEventListener('input', function(event) {
                        translateToNepali(this);
                    });
                });
            });

            function translateToNepali(input) {
                const options = {
                    layout: "traditional",
                };

                // Preserve the decimal point in the value
                let translatedValue = '';
                for (let char of input.value) {
                    if (char === '.') {
                        translatedValue += char; // Keep the decimal point as is
                    } else {
                        translatedValue += nepalify.format(char, options); // Convert other characters to Nepali
                    }
                }

                // Update the input with the translated value
                input.value = translatedValue;
            }
        </script>

        <script>
            document.addEventListener('livewire:init', () => {
                // =============error message=============
                Livewire.on('error', (event) => {
                    toastify().error(event.title);
                });
                // =========warning message============
                Livewire.on('warningMessage', (event) => {
                    Swal.fire({
                        title: "<span style='color: #c0392b; font-weight: bold;'>⚠️ चेतावनी!</span>",
                        html: `<strong style='font-size: 18px; color: #4a4a4a;'>${event.title}</strong>`,
                        icon: "warning",
                        iconColor: "#c0392b",
                        background: "#fff7e6",
                        showCloseButton: true,
                        confirmButtonText: "<span style='font-weight: bold; font-size: 16px;'>ठीक छ</span>",
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: "custom-confirm-button"
                        }
                    });
                });
            });
        </script>

        @toastifyJs
    </div>


    {{-- script --}}
    @stack('script')
</body>

</html>
