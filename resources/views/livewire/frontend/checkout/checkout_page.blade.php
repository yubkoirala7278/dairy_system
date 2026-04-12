@extends('livewire.frontend.layouts.master')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" wire:ignore>
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">चेकआउट</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">होम पेज
                        </a></li>
                    <li class="breadcrumb-item"><a href="#">पेजहरू</a></li>
                    <li class="breadcrumb-item active" aria-current="page">चेकआउट</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container-xxl py-5" wire:ignore.self>
        <div class="container">
            <div class="text-center mx-auto mb-5">
                <p class="section-title bg-white text-center text-primary px-3 py-2">हाम्रो चेकआउट</p>
                <h1 class="mb-4">तपाईंको चेकआउट पृष्ठ</h1>
            </div>

            <!-- Grid layout for large devices (Cart info and Cart Summary side by side) -->
            <div class="row row-cols-1 row-cols-lg-2 g-4">
                <!-- Left side: Personal Information -->
                <div class="col col-lg-8">
                    <div class="card shadow rounded-4">
                        <div class="card-body p-4">
                            <!-- Personal Information Card -->

                            <div class="info-card">
                                <div class="icon-box">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="text-box">
                                    <p class="label">तपाईंको नाम:</p>
                                    <p class="info-text">{{ $user->owner_name }}</p>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="icon-box">
                                    <i class="bi bi-phone"></i>
                                </div>
                                <div class="text-box">
                                    <p class="label">फोन नम्बर:</p>
                                    <p class="info-text">{{ $user->phone_number }}</p>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="icon-box">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="text-box">
                                    <p class="label">ठेगाना:</p>
                                    <p class="info-text">{{ $user->location }}</p>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="icon-box">
                                    <i class="bi bi-card-text"></i>
                                </div>
                                <div class="text-box">
                                    <p class="label">कृषक नम्बर:</p>
                                    <p class="info-text">{{ $user->farmer_number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side: Cart Summary -->
                <div class="col col-lg-4">
                    <div class="card shadow rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column">
                                @if (count($myCarts) > 0)
                                    @foreach ($myCarts as $key => $cart)
                                        <div class="d-flex align-items-center justify-content-between"
                                            wire:key="{{ $key }}">
                                            <p>{{ $cart->product->name }} * <span
                                                    class="fw-bold">{{ $cart->cart_count_nepali }}</span></p>
                                            <p class="fw-bold">रु. <span
                                                    class="total-price">{{ $cart->cart_count * $cart->product->price_per_kg }}</span>
                                            </p>
                                        </div>
                                    @endforeach
                                    <hr>
                                    <div class="d-flex align-items-center justify-content-between fw-bold">
                                        <p>उपकुल:</p>
                                        <p>रु {{ $sub_total }}</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between fw-bold">
                                        <p>ढुवानी शुल्क:</p>
                                        <p>रु ०</p>
                                    </div>
                                    <hr>
                                    <div class="d-flex align-items-center justify-content-between fw-bold">
                                        <p>कुल:</p>
                                        <p>रु {{ $sub_total }}</p>
                                    </div>
                                @endif
                                @if(count($myCarts) <= 0)
                                    कुनै उत्पादन कार्टमा थपिएको छैन।
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (count($myCarts) > 0)
                    <div class="card shadow rounded-4 mt-4">
                        <div class="card-body d-flex flex-column p-4">
                            <!-- Proceed Button -->
                            <button class="btn btn-primary w-100"
                                wire:click="checkoutProduct">अगाडि बढ्नुहोस्</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to convert English digits to Nepali digits
            function convertToNepali() {
                const nepaliDigits = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];

                // Select all elements with the class 'total-price'
                const elements = document.querySelectorAll('.total-price');

                elements.forEach(element => {
                    // Get the current text value of the element
                    let text = element.innerText;

                    // Convert each English digit to Nepali
                    let nepaliText = text.replace(/\d/g, (match) => nepaliDigits[parseInt(match)]);

                    // Update the element's text with the converted Nepali digits
                    element.innerText = nepaliText;
                });
            }

            // Call the function to convert numbers to Nepali when the page is ready
            convertToNepali();
        });
    </script>
@endpush

@section('custom-style')
    <style>
        .info-card {
            display: flex;
            align-items: center;
            background: #fafafa;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .icon-box {
            background-color: #5B8C51;
            /* Blue background */
            padding: 15px;
            border-radius: 50%;
            /* Circle */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Optional shadow */
        }

        .text-box {
            flex-grow: 1;
            padding-left: 15px;
        }

        .label {
            font-weight: bold;
            font-size: 1rem;
            color: #555;
        }

        .info-text {
            font-size: 1.1rem;
            color: #333;
        }

        .card-body p {
            margin-bottom: 0.5rem;
        }

        /* Ensure the button looks good on mobile */
        @media (max-width: 576px) {
            .btn {
                font-size: 1rem;
                padding: 12px;
            }
        }
    </style>
@endsection
