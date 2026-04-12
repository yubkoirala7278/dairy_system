@extends('livewire.admin.layouts.master')
@section('content')
    <div class="col-12 py-3 px-5" style="background-color: #eee;" wire:ignore.self>
        <div class="d-md-flex justify-content-between align-items-center py-2">
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
            </div>
        </div>

        <!-- Table Wrapper for Horizontal Scroll -->
        <div class="table-responsive">
            <table class="table table-bordered" style="font-size: 16px; min-width: 800px; width: 100%;">
                <thead>
                    <tr class="table-secondary">
                        {{-- <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            क्र.सं.</th> --}}
                            <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">कृषक
                                नम्बर</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">कृषकको
                            नाम</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">फोन
                            नम्बर</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">स्थिति
                        </th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            उपकुल(रु)</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">ढुवानी
                            शुल्क(रु)</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            कुल(रु)</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">मिति
                        </th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            उत्पादन विवरण</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($orders) > 0)
                        @foreach ($orders as $key => $order)
                            <tr wire:key="{{ $key }}">
                                <td style="white-space: nowrap;">{{ $order->user->farmer_number }}</td>
                                <td style="white-space: nowrap;">{{ $order->user->owner_name }}</td>
                                <td style="white-space: nowrap;">{{ $order->user->phone_number }}</td>
                                <td style="white-space: nowrap;">
                                    @if ($order->status == 'pending')
                                        <span class="badge text-bg-warning text-dark py-2">विचाराधीन</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge text-bg-success py-2 text-white">पुर्याइएको</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="badge text-bg-danger py-2 text-white">रद्द गरिएको</span>
                                    @endif
                                </td>
                                <td style="white-space: nowrap;">{{ $order->sub_total_nepali }}</td>
                                <td style="white-space: nowrap;">{{ $order->shipping_charge_nepali }}</td>
                                <td style="white-space: nowrap;">{{ $order->total_charge_nepali }}</td>
                                @php
                                    $year = $order->created_at->format('Y');
                                    $month = $order->created_at->format('m');
                                    $day = $order->created_at->format('d');
                                    $date = Bsdate::eng_to_nep($year, $month, $day);
                                @endphp
                                <td style="white-space: nowrap;">
                                    {{ html_entity_decode($date['date']) . ' ' . html_entity_decode($date['nmonth']) . ' ' . html_entity_decode($date['year']) . ', ' . $date['day'] }}
                                </td>
                                <td>
                                    <div class="action-container">
                                        <!-- Button for viewing details -->
                                        <button class="btn btn-success rounded-2"
                                            wire:click="getOrderDetails({{ $order->id }})" data-bs-toggle="modal"
                                            data-bs-target="#productDetails" style="white-space: nowrap;">
                                            विवरण हेर्नुहोस्
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    @if (count($orders) <= 0)
                        <tr class="text-center">
                            <td colspan="20">प्रदर्शन गर्न कुनै अर्डर छैन..</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="ml-4">
            {{ $orders->links() }}
        </div>
    </div>

@endsection

@section('modal')
    <!-- Modal for Order Details -->
    <div class="modal fade" wire:ignore.self id="productDetails" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="productDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header text-white">
                    <h1 class="modal-title fs-5" id="productDetailsLabel">{{ $order->user->owner_name ?? '' }}को अर्डर
                        विवरण
                    </h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <!-- Wrap the table in a scrollable container -->
                    <div style="max-width: 100%; overflow-x: auto;">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="fs-5" style="white-space: nowrap;">प्रोडक्ट</th>
                                    <th scope="col" class="fs-5" style="white-space: nowrap;">मात्रा</th>
                                    <th scope="col" class="fs-5" style="white-space: nowrap;">मूल्य प्रति लि./किग्रा
                                    </th>
                                    <th scope="col" class="fs-5" style="white-space: nowrap;">कुल(रु)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($orderDetails) > 0)
                                    @foreach ($orderDetails as $key => $order)
                                        <tr wire:ignore>
                                            <td style="white-space: nowrap;">{{ $order->product_name }}</td>
                                            <td>{{ $order->qty_nepali }}
                                                {{ $order->product->unit == 'kg' ? 'किलो' : 'लिटर' }}
                                            </td>
                                            <td wire:ignore>रु {{ $order->price_nepali }}</td>
                                            <td>रु {{ $order->total_nepali }}</td>
                                        </tr>
                                    @endforeach
                                    <!-- Order Summary -->
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-end" style="white-space: nowrap;">उपकुल :</td>
                                        <td class="fw-bold" style="white-space: nowrap;" wire:ignore>रु
                                            {{ $order_summary->sub_total_nepali }}</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-end" style="white-space: nowrap;">ढुवानी शुल्क :
                                        </td>
                                        <td class="fw-bold" style="white-space: nowrap;" wire:ignore>रु
                                            {{ $order_summary->shipping_charge_nepali }}</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-end" style="white-space: nowrap;">कुल :</td>
                                        <td class="fw-bold text-success" style="white-space: nowrap;" wire:ignore>रु
                                            {{ $order_summary->total_charge_nepali }}</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-end" style="white-space: nowrap;">स्थिति</td>
                                        <td class="fw-bold text-success" style="white-space: nowrap;">
                                            <select class="form-select status-select py-2" wire:model.live="status" style="white-space: nowrap;width:120px">
                                                <option value="pending">विचाराधीन</option>
                                                <option value="cancelled">रद्द गरिएको</option>
                                                <option value="delivered">पुर्याइएको</option>
                                            </select>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-muted" style="white-space: nowrap;">
                                            कुनै अर्डर विवरण उपलब्ध छैन।</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बन्द गर्नुहोस्</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('success', (event) => {
            $('#productDetails').modal('hide');
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
        Livewire.on('warning', (event) => {
            Swal.fire({
                title: 'के तपाईं यसलाई सम्पादन गर्न निश्चित हुनुहुन्छ?',
                text: "यसले किसानको रकममा असर गर्न सक्छ!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "हो, सम्पादन गरौं!",
                cancelButtonText: "रद्द गर्नुहोस्"
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('confirmUpdateStatus');
                }
            });

        });
    });
</script>
@endpush

@section('custom-style')
    <style>
        /* Modal customizations */
        .modal-content {
            border-radius: 10px;
            background-color: #ffffff;
            padding: 20px;
        }

        .modal-header {
            background-color: #515F52;
            /* Soft Blue */
            padding-bottom: 10px;
        }

        .modal-footer {
            border-top: 1px solid #e2e6ea;
            padding-top: 10px;
        }

        /* Table Styling */
        .table th,
        .table td {
            vertical-align: middle !important;
            padding: 12px;
            font-size: 15px;
        }

        .table th {
            background-color: #f8f9fa;
            /* Light Gray */
            color: #343a40;
            /* Dark Gray */
        }

        .table td {
            color: #495057;
            /* Slightly lighter dark gray */
        }

        .table-bordered {
            border: 1px solid #e2e6ea;
        }

        .fw-bold {
            font-weight: bold;
        }

        /* Success color for important numbers (like totals) */
        .text-success {
            color: #28a745;
        }

        /* Text alignments */
        .text-end {
            text-align: right;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modal-dialog {
                max-width: 100%;
            }

            .modal-header h1 {
                font-size: 1.25rem;
            }

            .table th,
            .table td {
                font-size: 14px;
                padding: 10px;
            }

            .modal-content {
                padding: 15px;
            }
        }

        /* Button Styling */
        .btn-close-white {
            filter: invert(1);
        }

        .btn-secondary {
            background-color: #6c757d !important;
            /* Neutral gray */
            color: white !important;
            border-radius: 8px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .action-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Simple and clean status-select styling */
        .status-select {
            border: 1px solid #ced4da;
            /* Light gray border */
            border-radius: 6px;
            /* Slightly rounded corners */
            font-size: 1rem;
            /* Readable font size */
            padding: 0.5rem;
            /* Comfortable padding */
            color: #495057;
            /* Neutral text color */
            background-color: #ffffff;
            /* Clean white background */
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            /* Subtle transition */
            appearance: none;
            /* Simple arrow */
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 0.65rem;
        }
      

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .status-select {
                font-size: 0.9rem;
                /* Adjust font size */
                padding: 0.4rem;
                /* Adjust padding */
            }
        }
    </style>
@endsection
