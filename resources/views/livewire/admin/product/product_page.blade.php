@extends('livewire.admin.layouts.master')
@section('content')
    <div class="col-12 py-3 px-5" style="background-color: #eee;" wire:ignore.self>
        <div class="d-md-flex justify-content-between align-items-center  py-2 ">
            <div>
                <label class="d-flex align-items-center gap-2">
                    <span>प्रदर्शन गर्नुहोस्</span>
                    <select name="withdraw-request-list_length" aria-controls="withdraw-request-list"
                        class="form-select form-select-sm w-auto" wire:model.live.debounce.500ms="entries">
                        <option value="10">१०</option>
                        <option value="25">२५</option>
                        <option value="50">५०</option>
                        <option value="100">१००</option>
                        <option value="200">२००</option>
                        <option value="500">५००</option>
                    </select>
                    <span>डेटा</span>
                </label>
            </div>
            <div class="d-flex align-items-center" style="column-gap: 20px">
                <input type="search" class="form-control form-control-sm translate-nepali" placeholder="खोज्नुहोस्..."
                    aria-controls="withdraw-request-list" wire:model.live.debounce.500ms="search">
                <button type="button" class="btn btn-success px-3" data-bs-toggle="modal" data-bs-target="#createProduct"
                    style="border-radius: 30px; min-width: 100px;" wire:ignore>
                    नयाँ प्रोडक्ट
                </button>
            </div>

        </div>
        <table class="table table-bordered table-hover" style="font-size: 20px; min-width: 800px; width: 100%;">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">क्र.सं.</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">प्रोडक्टको नाम</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">मूल्य प्रति लि./किग्रा</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">स्थिति</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">प्रोडक्टको फोटो</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">कार्य</th>
                </tr>
            </thead>
            <tbody>
                @if (count($products) > 0)
                    @foreach ($products as $key => $product)
                        <tr wire:key="{{ $key }}">
                            <td>{{ $product->nepali_count }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price_per_kg }}</td>
                            <td>
                                @if ($product->status)
                                    <span class="badge text-bg-success">चालू</span>
                                @else
                                    <span class="badge text-bg-danger">बन्द</span>
                                @endif
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                    style="height: 30px; cursor: pointer;"
                                    onclick="openImageModal('{{ asset('storage/' . $product->image) }}')" loading="lazy">
                            </td>
                            <td class="d-flex gap-2 align-items-center">
                                <!-- Edit Button -->
                                <button class="btn btn-warning shadow-sm text-dark  rounded-1 d-flex justify-content-center align-items-center"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="सुधार्नुहोस्"
                                    wire:click="edit({{ $product->id }})" style="height: 20px;width:20px">
                                    <i class="fa-solid fa-pencil fs-6"></i>
                                </button>
                            
                                <!-- Delete Button -->
                                <button class="btn btn-danger shadow-sm text-white  rounded-1 d-flex justify-content-center align-items-center"
                                    onclick="confirmDelete({{ $product->id }})"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="मेटाउनुहोस्" style="height: 20px;width:20px">
                                    <i class="fa-solid fa-trash fs-6"></i>
                                </button>
                            </td>
                            
                            
                        </tr>
                    @endforeach
                @endif
                @if (count($products) <= 0)
                    <tr class="text-center">
                        <td colspan="20">प्रदर्शन गर्न कुनै प्रोडक्ट छैन..</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="ml-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection

@section('modal')
    <!-- create product Modal-->
    <div class="modal fade" id="createProduct" wire:ignore.self data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="createProductLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="createProductLabel">नयाँ प्रोडक्ट थप्नुहोस्</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetFields"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark">प्रोडक्टको नाम</label>
                            <input type="text" class="form-control translate-nepali" id="name"
                                placeholder="प्रोडक्टको नाम लेख्नुहोस्" wire:model="name">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label  text-dark">प्रोडक्टको फोटो</label>
                            <input type="file" id="fileInput" class="form-control"
                                accept="image/jpeg,image/png,image/webp,image/jpg"
                                wire:model.live="image">
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                            <span id="img-error-message" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="price_per_kg" class="form-label text-dark">प्रोडक्टको मूल्य</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="price_per_kg"
                                    placeholder="प्रोडक्टको मूल्य लेख्नुहोस्" wire:model="price_per_kg">
                                <select class="form-select" id="unit_selector" wire:model="unit">
                                    <option value="kg">प्रति किलो</option>
                                    <option value="ltr">प्रति लिटर</option>
                                </select>
                            </div>
                            @if ($errors->has('price_per_kg'))
                                <span class="text-danger">{{ $errors->first('price_per_kg') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label  text-dark">अवस्था</label>
                            <select class="form-select" wire:model="status" id="status">
                                <option value="1">चालू</option>
                                <option value="0">बन्द</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="resetFields">रद्द गर्नुहोस्</button>
                    <button type="button" class="btn btn-success" wire:click="createProduct">पेश गर्नुहोस्</button>
                </div>
            </div>
        </div>
    </div>


    <!-- update product Modal-->
    <div class="modal fade" id="updateProduct" wire:ignore.self data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="updateProductLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="updateProductLabel">प्रोडक्ट अपडेट गर्नुहोस्</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetFields"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark">प्रोडक्टको नाम</label>
                            <input type="text" class="form-control translate-nepali" id="name"
                                placeholder="प्रोडक्टको नाम लेख्नुहोस्" wire:model="name">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label text-dark">प्रोडक्टको फोटो</label>
                            <input type="file" id="fileInput" class="form-control"
                                accept="image/jpeg,image/png,image/webp,image/jpg" 
                                wire:model="image">
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                            <span id="error-message" style="color: red;"></span>
                        </div>
                        <div class="mb-3">
                            <label for="price_per_kg" class="form-label text-dark">प्रोडक्टको मूल्य</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="price_per_kg"
                                    placeholder="प्रोडक्टको मूल्य लेख्नुहोस्" wire:model="price_per_kg">
                                <select class="form-select" id="unit_selector" wire:model="unit">
                                    <option value="kg">प्रति किलो</option>
                                    <option value="ltr">प्रति लिटर</option>
                                </select>
                            </div>
                            @if ($errors->has('price_per_kg'))
                                <span class="text-danger">{{ $errors->first('price_per_kg') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label text-dark">अवस्था</label>
                            <select class="form-control" wire:model="status" id="status">
                                <option value="1">चालू</option>
                                <option value="0">बन्द</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="resetFields">रद्द
                        गर्नुहोस्</button>
                    <button type="button" class="btn btn-success" wire:click="updateProduct">अपडेट गर्नुहोस्</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for displaying the image -->
    <div id="imageModal" wire:ignore.self class="modal fade" tabindex="-1" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">प्रोडक्टको फोटो</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Product Image" class="img-fluid"
                        style="max-height: 500px;" loading="lazy">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <div wire:ignore.self>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ========success message============
                Livewire.on('success', (event) => {
                    $('#createProduct').modal('hide');
                    $('#updateProduct').modal('hide');
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

                Livewire.on('editModal', (event) => {
                    $('#updateProduct').modal('show');
                });
            });
        </script>
        <script>
            // ======alert delete confirmation========
            function confirmDelete(productId) {
                Swal.fire({
                    title: "के तपाईं पक्का हुनुहुन्छ?",
                    text: "यो क्रिया पुनः फर्काउन सकिने छैन!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "हो, यसलाई मेटाउनुहोस्!",
                    cancelButtonText: "रद्द गर्नुहोस्"
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('delete', productId);
                    }
                });

            }

            // Function to open the image modal and display the clicked image
            function openImageModal(imagePath) {
                // Set the source of the image in the modal
                document.getElementById('modalImage').src = imagePath;

                // Show the modal
                $('#imageModal').modal('show');
            }
        </script>
    </div>
@endpush

@section('custom-style')
    <div wire:ignore.self>
        <style>
            .input-group {
                display: flex;
                align-items: center;
            }

            .input-group .form-control {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }

            .input-group .form-select {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                background-color: #f8f9fa;
                border: 1px solid #ced4da;
            }

            .input-group .form-select:focus {
                border-color: #80bdff;
                box-shadow: none;
            }

            .mb-3 .form-label {
                font-weight: bold;
                font-size: 16px;
                margin-bottom: 8px;
            }

            .text-dark {
                color: #343a40 !important;
            }

            .text-danger {
                font-size: 12px;
                margin-top: 4px;
            }

            @media (max-width: 767px) {
                .input-group {
                    flex-direction: column;
                }

                .input-group .form-select {
                    margin-top: 10px;
                }
            }
        </style>
    </div>
@endsection
