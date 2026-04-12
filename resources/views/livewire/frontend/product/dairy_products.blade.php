@extends('livewire.frontend.layouts.master')
@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">उत्पादनहरू</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">होम पेज
                        </a></li>
                    <li class="breadcrumb-item"><a href="#">पेजहरू</a></li>
                    <li class="breadcrumb-item active" aria-current="page">उत्पादनहरू</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Product Start -->
    <div class="container-xxl py-5" wire:ignore.self>
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">हाम्रो उत्पादनहरू</p>
                <h1 class="mb-5">स्वस्थ जीवनको लागि हाम्रा डेरी र अन्य उत्पादनहरू</h1>
            </div>
            <div class="row gx-4" style="row-gap: 20px">
                @if (count($products) > 0)
                    @foreach ($products as $key => $product)
                        <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="product-item">
                                <div class="position-relative text-center">
                                    <img class="img-fluid" src="{{ asset('storage/' . $product->image) }}" alt=""
                                        loading="lazy" style="max-height: 250px;object-fit:fill">
                                </div>
                                <div class="text-center p-4">
                                    <a class="d-block h5" href="">{{ $product->name }}</a>
                                    <span class="text-primary me-1 d-block">रु {{ $product->price_per_kg }} प्रति {{$product->unit=='kg'?'किलो':'लि.'}}</span>
                                    <button class="btn btn-primary btn-sm w-75 rounded-pill mt-1"
                                        wire:click="addProductToCart({{ $product->id }})">
                                        <i class="bi bi-cart-plus me-2"></i>
                                        कार्टमा थप्नुहोस्
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if (count($products) <= 0)
                    <p class="text-center">दिखाउनको लागि कुनै उत्पादन छैन।</p>
                @endif
            </div>
            <!-- Load More Button -->
            @if ($this->productCount > $this->entries)
                <div class="text-center mt-4">
                    <div class="d-flex align-items-center justify-content-center">
                        <!-- Left Line -->
                        <div class="flex-grow-1 border-bottom"
                            style="height: 1px; background-color: #ccc; margin-right: 15px;"></div>

                        <!-- Button -->
                        <button class="btn btn-primary btn-md rounded-pill px-4 d-flex align-items-center"
                            wire:click="loadMoreProducts" style="position: relative;">
                            <i class="bi bi-arrow-down-circle me-2 animate-bounce"></i>
                            थप लोड गर्नुहोस्
                        </button>

                        <!-- Right Line -->
                        <div class="flex-grow-1 border-bottom"
                            style="height: 1px; background-color: #ccc; margin-left: 15px;"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if (Auth::user())
        <a href="{{ route('frontend.cart') }}"
            class="btn btn-lg btn-primary btn-lg-square rounded-circle position-fixed bottom-0 end-0 mb-3 me-3">
            <i class="bi bi-cart"></i>
            <span class="badge rounded-circle bg-danger position-absolute top-0 start-100 translate-middle"
                style="width: 25px; height: 25px; font-size: 14px; text-align: center; line-height: 16px;transform: translate(-73%, -37%) !important;">
                {{ $cartCount }}
            </span>
        </a>
    @endif

    <!-- Product End -->
@endsection

@section('modal')
    <div class="modal fade" wire:ignore.self id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="loginModalLabel">लगिन गर्नुहोस्</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="farmer_number" class="form-label">कृषक नम्बर</label>
                            <input type="text" class="form-control translate-nepali" id="farmer_number"
                                wire:model="farmer_number" placeholder="कृषक नम्बर लेख्नुहोस्">
                            @if ($errors->has('farmer_number'))
                                <span class="text-danger">{{ $errors->first('farmer_number') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">पासवर्ड</label>
                            <input type="password" class="form-control" id="password" wire:model="password"
                                placeholder="पासवर्ड लेख्नुहोस्">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">रद्द गर्नुहोस्</button>
                    <button type="button" class="btn btn-primary" wire:click="loginUser">लगिन</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <div wire:ignore>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('success', (event) => {
                    Swal.fire({
                        title: "जानकारी",
                        text: event.title,
                        icon: "success",
                        iconColor: "#28a745", // Use a green color to match success theme
                        background: "#f9f9f9",
                        color: "#333", // Darker text color for readability
                        showConfirmButton: true,
                        confirmButtonColor: "#4CAF50", // Custom green button
                        confirmButtonText: "ठीक छ",
                        customClass: {
                            popup: "swal-custom-popup",
                            title: "swal-custom-title",
                            confirmButton: "swal-custom-button"
                        },
                        didOpen: () => {
                            // Adding a custom animation for the icon
                            document.querySelector('.swal2-icon.swal2-success').classList.add(
                                'swal-animate-icon');
                        }
                    });

                });
                Livewire.on('loginUser', (event) => {
                    $('#loginModal').modal('show');
                });
                Livewire.on('successLogin', (event) => {
                    $('#loginModal').modal('hide');
                    toastify().success(event.title);
                });
            });
        </script>
    </div>
@endpush
