@extends('livewire.frontend.layouts.master')
@section('custom-style')
    <style>
        .employee-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .employee-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-text {
            font-size: 0.9rem;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.4em 0.8em;
        }
    </style>
@endsection
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">हाम्रो कर्मचारी र सञ्चालक</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">होम पेज
                        </a></li>
                    <li class="breadcrumb-item"><a href="#">पेजहरू</a></li>
                    <li class="breadcrumb-item active" aria-current="page">कर्मचारी र सञ्चालक</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">कर्मचारी सदस्यहरू</p>
                <h1 class="mb-5">अनुभवी कर्मचारी सदस्यहरू</h1>
            </div>
            <div class="row">
                @if (count($employees) > 0)
                    @foreach ($employees as $employee)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 shadow-sm border-0 employee-card">
                                <!-- Profile Image -->
                                <div class="card-img-top text-center p-3 bg-light position-relative">
                                    <img src="{{ asset('storage/' . $employee->profile_image) }}"
                                        class="rounded-circle img-fluid" alt="{{ $employee->name }}"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                </div>

                                <!-- Card Body -->
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary mb-1">{{ $employee->name }}</h5>
                                    <p class="card-text text-muted mb-2">{{ $employee->position }}</p>

                                    <!-- Additional Info -->
                                    <ul class="list-unstyled text-start mx-auto" style="max-width: 200px;">
                                        <li class="mb-2">
                                            <i class="bi bi-telephone-fill text-primary me-2"></i>
                                            {{ $employee->phone_no }}
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                            {{ $employee->location }}
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p class="text-muted">No employees found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Team End -->

    <!-- Administration Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">सञ्चालक सदस्यहरू</p>
                <h1 class="mb-5">अनुभवी सञ्चालक सदस्यहरू</h1>
            </div>
            <div class="row">
                @if (count($administrations) > 0)
                    @foreach ($administrations as $administration)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 shadow-sm border-0 employee-card">
                                <!-- Profile Image -->
                                <div class="card-img-top text-center p-3 bg-light position-relative">
                                    <img src="{{ asset('storage/' . $administration->profile_image) }}"
                                        class="rounded-circle img-fluid" alt="{{ $administration->name }}"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                </div>

                                <!-- Card Body -->
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary mb-1">{{ $administration->name }}</h5>
                                    <p class="card-text text-muted mb-2">{{ $administration->position }}</p>

                                    <!-- Additional Info -->
                                    <ul class="list-unstyled text-start mx-auto" style="max-width: 200px;">
                                        <li class="mb-2">
                                            <i class="bi bi-telephone-fill text-primary me-2"></i>
                                            {{ $administration->phone_no }}
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                            {{ $administration->location }}
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p class="text-muted">No Administration found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Administration End -->
@endsection
