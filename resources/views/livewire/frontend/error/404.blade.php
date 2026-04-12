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
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Open+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

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
</head>

<body>
    <!-- 404 Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
                    <h1 class="display-1">४०४</h1>
                    <h1 class="mb-4">पृष्ठ फेला परेन</h1>
                    <p class="mb-4">माफ गर्नुहोस्, तपाईंले खोजेको पृष्ठ हाम्रो वेबसाइटमा उपलब्ध छैन! हुनसक्छ हाम्रो होम पेजमा जानुहोस् वा सर्च प्रयोग गर्न प्रयास गर्नुहोस्।</p>
                    <a class="btn btn-secondary rounded-pill py-3 px-5" href="{{route('frontend.home')}}">होम पेजमा फर्किनुहोस्</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 404 End -->
</body>

</html>

   