@extends('livewire.frontend.layouts.master')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" wire:ignore>
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">कार्ट</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">होम पेज
                        </a></li>
                    <li class="breadcrumb-item"><a href="#">पेजहरू</a></li>
                    <li class="breadcrumb-item active" aria-current="page">कार्ट</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container-xxl py-5" wire:ignore.self>
        <div class="container">
            <div class="text-center mx-auto mb-5">
                <p class="section-title bg-white text-center text-primary px-3 py-2">हाम्रो कार्ट</p>
                <h1 class="mb-4">तपाईंको किनमेल कार्ट</h1>
            </div>

            <!-- Grid layout for large devices (Cart info and Cart Summary side by side) -->
            @if (count($myCarts) > 0)
                <div class="row row-cols-1 row-cols-lg-2 g-4">
                    <!-- Left side: Cart Information -->
                    <div class="col">
                        <div class="row g-4">

                            @foreach ($myCarts as $key => $myCart)
                                <!-- Product Card 1 -->
                                <div class="col-12">
                                    <div class="card shadow rounded-4">
                                        <div class="card-body d-flex flex-column p-4">
                                            <div class="d-flex align-items-center mb-4">
                                                <!-- Product Image -->
                                                <img src="{{ asset('storage/' . $myCart->product->image) }}"
                                                    alt="Product Image" class="img-fluid rounded-3"
                                                    style="max-width: 100px; height: 100px; object-fit: cover;">
                                                <div class="ms-3">
                                                    <h5 class="card-title mb-2 text-truncate">{{ $myCart->product->name }}
                                                    </h5>
                                                    <p class="text-muted mb-0">रु
                                                        {{ $myCart->product->price_per_kg_nepali }} प्रति {{$myCart->product->unit=='kg'?'किलो':'लि.'}}</p>
                                                </div>
                                            </div>
                                            <!-- Quantity Control -->
                                            <div class="d-flex align-items-center mb-3">
                                                <button class="btn btn-outline-primary btn-sm me-3"
                                                    wire:click="decreaseQuantity({{ $myCart->id }})">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" class="form-control text-center" style="width: 70px;"
                                                    value="{{ $myCart->cart_count }}" min="1"
                                                    wire:model.live.debounce.2000ms="cartCounts.{{ $myCart->id }}">
                                                <button class="btn btn-outline-primary btn-sm ms-3"
                                                    wire:click="increaseQuantity({{ $myCart->id }})">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <!-- Total Price -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-0 fw-bold">कुल: <span style="color: #FF6F61;">रु</span><span
                                                        class="total-price" style="color: #FF6F61;">
                                                        {{ $myCart->product->price_per_kg * $myCart->cart_count }}</span>
                                                </p>
                                                <button class="btn btn-danger btn-sm"
                                                    wire:click="removeFromCart({{ $myCart->id }})">हटाउनुहोस्</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- Right side: Cart Summary -->
                    <div class="col">
                        <div class="card shadow rounded-4">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-3">कार्ट सारांश</h5>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <p class="mb-0">उपकुल:</p>
                                    <p class="mb-0">रु {{ $sub_total }}</p>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <p class="mb-0">ढुवानी शुल्क:</p>
                                    <p class="mb-0">रु ०</p>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <p class="mb-0">कुल:</p>
                                    <p class="mb-0 fw-bold" style="color: #FF6F61;">रु {{ $sub_total }}</p>
                                </div>
                                <hr>
                                <button class="btn btn-success w-100" wire:click="checkOut">चेकआउटमा
                                    जानुहोस्</button>
                            </div>
                        </div>
                    </div>

                </div>
            @endif
            @if (count($myCarts) <= 0)
            <div class="text-center">
                <p> कुनै उत्पादन कार्टमा थपिएको छैन।</p>
                <a href="{{route('frontend.product')}}" class="btn btn-success rounded-pill">अहिले किन्नुहोस्</a>
        </div>
            @endif
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

            // ========success message============
            Livewire.on('priceChanged', () => {
                setTimeout(() => {
                    convertToNepali();
                }, 1);
            });
        });
    </script>
@endpush

@section('custom-style')
    <style>
        /* Card and Button Styles */
        .card {
            border: 1px solid #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        /* Quantity Control Styles */
        .btn-outline-primary {
            border-radius: 50%;
            width: 35px;
            height: 35px;
            padding: 0;
        }

        .form-control {
            text-align: center;
        }

        /* Cart Summary Section */
        .card-body {
            padding: 2rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }

        .d-flex p {
            font-size: 1.1rem;
            color: #555;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 12px;
            font-size: 1.1rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .btn-primary {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1rem;
                padding: 5px;
            }

            .card-title {
                font-size: 1.1rem;
            }
        }

        /* Large Device (lg and above) Styles */
        @media (min-width: 992px) {
            .row-cols-lg-2 {
                display: flex;
                flex-wrap: nowrap;
            }

            .col-lg-6 {
                flex: 1 1 50%;
            }

            .col-lg-6.offset-lg-4 {
                margin-left: 0;
            }
        }
    </style>
@endsection
