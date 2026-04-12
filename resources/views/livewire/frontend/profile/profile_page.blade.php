@extends('livewire.frontend.layouts.master')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" wire:ignore>
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">किसान प्रोफाइल</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">होम पेज</a></li>
                    <li class="breadcrumb-item"><a href="#">प्रोफाइल</a></li>
                    <li class="breadcrumb-item active" aria-current="page">किसान प्रोफाइल</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Profile Section -->
    <div class="container py-5" wire:ignore.self>
        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar avatar-xl  text-white rounded-circle me-3">
                                <img src="{{ asset('frontend_assets/farmer.png') }}" alt="Profile Image" loading="lazy"
                                    height="40">
                            </div>
                            <div>
                                <h5 class="mb-0">{{ Auth::user()->owner_name }}</h5>
                                <small class="text-muted">किसान</small>
                            </div>
                        </div>

                        <ul class="nav nav-pills flex-column gap-2" wire:ignore>

                            <li class="nav-item">
                                <a class="nav-link active" href="#profile" data-bs-toggle="tab">
                                    <i class="bi bi-person me-2"></i> प्रोफाइल
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#password" data-bs-toggle="tab">
                                    <i class="bi bi-lock-fill me-2"></i> पासवर्ड
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="tab-content">
                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile" wire:ignore>
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 fs-3 text-white">प्रोफाइल जानकारी</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex">
                                            <span class="fw-bold">पूरा नाम:</span>
                                            <span class="ms-2">{{ Auth::user()->owner_name }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex">
                                            <span class="fw-bold">कृषक नम्बर:</span>
                                            <span class="ms-2">{{ Auth::user()->farmer_number }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex">
                                            <span class="fw-bold">फोन:</span>
                                            <span class="ms-2">{{ Auth::user()->phone_number }}</span>
                                        </div>
                                    </div>
                                    <!-- Right Column -->
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex">
                                            <span class="fw-bold">लिङ्ग:</span>
                                            <span class="ms-2">{{ Auth::user()->gender }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex">
                                            <span class="fw-bold">ठेगाना:</span>
                                            <span class="ms-2">{{ Auth::user()->location }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex">
                                            <span class="fw-bold">ब्यालेन्स:</span>
                                            <span class="ms-2 text-success">रु. {{ $user_balance }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Tab -->
                    <div class="tab-pane fade" id="password" wire:ignore.self>
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 text-white  fs-3">पासवर्ड परिवर्तन</h5>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" wire:submit.prevent="changePassword">
                                    <!-- Old Password -->
                                    <div class="col-md-12">
                                        <label for="currentPassword" class="form-label">हालको पासवर्ड</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="currentPassword"
                                                placeholder="**********" wire:model="old_password"
                                                autocomplete="new-password">
                                            <button class="btn text-white" style="background-color: #5B8C51;" type="button"
                                                onclick="togglePassword('currentPassword', 'eyeOld')">
                                                <i id="eyeOld" class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        @error('old_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- New Password -->
                                    <div class="col-md-6">
                                        <label for="newPassword" class="form-label">नयाँ पासवर्ड</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="newPassword"
                                                placeholder="**********" wire:model="new_password">
                                            <button class="btn text-white" style="background-color: #5B8C51;"
                                                type="button" onclick="togglePassword('newPassword', 'eyeNew')">
                                                <i id="eyeNew" class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Confirm New Password -->
                                    <div class="col-md-6">
                                        <label for="confirmPassword" class="form-label">पासवर्ड पुष्टि गर्नुहोस्</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="confirmPassword"
                                                placeholder="**********" wire:model="new_password_confirmation">
                                            <button class="btn text-white" style="background-color: #5B8C51;"
                                                type="button" onclick="togglePassword('confirmPassword', 'eyeConfirm')">
                                                <i id="eyeConfirm" class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        @error('new_password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-key me-2"></i> पासवर्ड परिवर्तन गर्नुहोस्
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .nav-pills .nav-link {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link.active {
            background: var(--bs-primary);
            color: white !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
        }

        @media (max-width: 768px) {
            .nav-pills {
                flex-direction: row;
                overflow-x: auto;
                flex-wrap: nowrap;
            }

            .nav-item {
                min-width: 150px;
            }
        }
    </style>
@endsection

@push('script')
<div wire:ignore.self>
    <script>
        document.addEventListener('livewire:init', () => {
            // =============success message=============
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
        });

        function togglePassword(fieldId, eyeId) {
            let field = document.getElementById(fieldId);
            let eyeIcon = document.getElementById(eyeId);
            if (field.type === "password") {
                field.type = "text";
                eyeIcon.classList.remove("bi-eye");
                eyeIcon.classList.add("bi-eye-slash");
            } else {
                field.type = "password";
                eyeIcon.classList.remove("bi-eye-slash");
                eyeIcon.classList.add("bi-eye");
            }
        }
    </script>
    </div>
@endpush
