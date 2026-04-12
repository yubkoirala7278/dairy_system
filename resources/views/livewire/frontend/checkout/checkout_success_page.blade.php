@extends('livewire.frontend.layouts.master')
@section('content')
<div class="container-xxl py-5" wire:ignore.self>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        <div class="success-message mb-4">
                            <i class="fas fa-check-circle" style="font-size: 80px; color: #28a745;"></i>
                        </div>
                        <h2 class="mb-3 text-success fw-bold">तपाईंको अर्डर सफलतापूर्वक स्थान गरिएको छ।</h2>
                        <p class="mb-4 text-muted">हामी तपाईंको अर्डर प्रक्रिया गरिरहेका छौं। कृपया केही समय कुर्नुहोस्।</p>
                        <a href="{{route('frontend.product')}}" class="btn btn-lg btn-success px-5 py-3 rounded-pill">पुनः किनमेल</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('custom-style')
<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 15px;
    }

    .success-message {
        background-color: #d4edda;
        padding: 20px;
        border-radius: 50%;
        display: inline-block;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 1.8rem;
        font-weight: bold;
    }

    p {
        font-size: 1rem;
        color: #6c757d;
    }

    .btn-outline-success {
        color: #28a745;
        border-color: #28a745;
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
    }

    /* Mobile responsiveness */
    @media (max-width: 576px) {
        .container-xxl {
            padding: 2rem 1rem;
        }

        .card-body {
            padding: 2rem;
        }

        .success-message i {
            font-size: 60px;
        }

        h2 {
            font-size: 1.5rem;
        }

        .btn-lg {
            font-size: 1rem;
            padding: 12px 24px;
        }
    }

    /* Larger screens */
    @media (min-width: 992px) {
        .card-body {
            padding: 4rem;
        }

        .btn-lg {
            font-size: 1.2rem;
            padding: 16px 32px;
        }
    }
</style>
@endsection