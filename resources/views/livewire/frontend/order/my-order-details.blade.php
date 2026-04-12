@extends('livewire.frontend.layouts.master')
@section('custom-style')
    <style>
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(90deg, #404A3D, #6B705C);
            padding: 1rem 1.5rem;
        }

        .card-header h5 {
            margin: 0;
            color: #fff;
            font-weight: 700;
        }

        .card-body {
            padding: 1.5rem;
            background-color: #fff;
        }

        .order-info p,
        .shipping-info p {
            margin-bottom: 0.5rem;
        }

        .shipping-info {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
            margin-bottom: 1.5rem;
        }

        .table thead {
            background-color: #f8f9fa;
        }

        @media (max-width: 576px) {

            .text-md-end,
            .text-md-center {
                text-align: center !important;
            }
        }
    </style>
@endsection
@section('content')
    <!-- Profile Section -->
    <div class="container py-5" wire:ignore.self>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <!-- Card Header -->
                    <div class="card-header">
                        <h5>अर्डर विवरण</h5>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">

                        <!-- Order Status Section -->
                        <div class="row mb-4 align-items-center order-info">
                            <div class="col-md-4">
                                @php
                                    $year = $order_summary->created_at->format('Y');
                                    $month = $order_summary->created_at->format('m');
                                    $day = $order_summary->created_at->format('d');
                                    $date = Bsdate::eng_to_nep($year, $month, $day);
                                @endphp
                                <p>
                                    <strong>अर्डर मिति:</strong>
                                    {{ html_entity_decode($date['date']) .
                                        ' ' .
                                        html_entity_decode($date['nmonth']) .
                                        ' ' .
                                        html_entity_decode($date['year']) .
                                        ', ' .
                                        $date['day'] }}
                                </p>
                                @if ($order_summary->status == 'delivered')
                                    @php
                                        $year = $order_summary->updated_at->format('Y');
                                        $month = $order_summary->updated_at->format('m');
                                        $day = $order_summary->updated_at->format('d');
                                        $date = Bsdate::eng_to_nep($year, $month, $day);
                                    @endphp
                                    <p>
                                        <strong>डेलिभरी मिति:</strong>
                                        {{ html_entity_decode($date['date']) .
                                            ' ' .
                                            html_entity_decode($date['nmonth']) .
                                            ' ' .
                                            html_entity_decode($date['year']) .
                                            ', ' .
                                            $date['day'] }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-4 text-lg-center">
                                <p>
                                    <strong>अर्डर स्थिति:</strong>
                                    @if ($order_summary->status == 'pending')
                                        <span class="badge bg-warning">विचाराधीन</span>
                                    @elseif($order_summary->status == 'delivered')
                                        <span class="badge bg-success">पुर्याइएको</span>
                                    @elseif($order_summary->status == 'cancelled')
                                        <span class="badge bg-danger">रद्द गरिएको</span>
                                    @endif
                                </p>
                            </div>
                            @if ($order_summary->status == 'pending')
                                <div class="col-md-4 text-lg-end">
                                    <button class="btn btn-danger rounded-pill"
                                        wire:click="cancelOrder({{ $order_summary->id }})">
                                        अर्डर रद्द गर्नुहोस्
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Shipping Information -->
                        <div class="shipping-info mb-4">
                            <h6 class="text-uppercase text-muted mb-3">शिपिंग जानकारी</h6>
                            <p><strong>कृषकको नाम:</strong> {{ $order_summary->user->owner_name }}</p>
                            <p><strong>कृषक नम्बर:</strong> {{ $order_summary->user->farmer_number }}</p>
                            <p><strong>ठेगाना:</strong> {{ $order_summary->user->location }}</p>
                            <p><strong>फोन नम्बर:</strong> {{ $order_summary->user->phone_number }}</p>
                            <p><strong>लिंग:</strong> {{ $order_summary->user->gender }}</p>
                        </div>

                        <!-- Order Items Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th style="white-space: nowrap;">प्रोडक्ट</th>
                                        <th style="white-space: nowrap;">मात्रा</th>
                                        <th style="white-space: nowrap;">मूल्य प्रति लि./किग्रा</th>
                                        <th style="white-space: nowrap;">कुल(रु)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderDetails as $order)
                                        <tr wire:ignore>
                                            <td style="white-space: nowrap;">{{ $order->product_name }}</td>
                                            <td style="white-space: nowrap;">
                                                {{ $order->qty_nepali }}
                                                {{ $order->product->unit == 'kg' ? 'किलो' : 'लिटर' }}
                                            </td>
                                            <td style="white-space: nowrap;">रु {{ $order->price_nepali }}</td>
                                            <td style="white-space: nowrap;">रु {{ $order->total_nepali }}</td>
                                        </tr>
                                    @endforeach
                                    <!-- Order Summary Rows -->
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-end" style="white-space: nowrap;"><strong>उपकुल
                                                :</strong></td>
                                        <td class="fw-bold" wire:ignore style="white-space: nowrap;">रु
                                            {{ $order_summary->sub_total_nepali }}</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-end" style="white-space: nowrap;"><strong>ढुवानी
                                                शुल्क :</strong></td>
                                        <td class="fw-bold" wire:ignore style="white-space: nowrap;">रु
                                            {{ $order_summary->shipping_charge_nepali }}
                                        </td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td colspan="3" class="text-end" style="white-space: nowrap;"><strong>कुल
                                                :</strong></td>
                                        <td class="fw-bold text-success" wire:ignore style="white-space: nowrap;">रु
                                            {{ $order_summary->total_charge_nepali }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div> <!-- End Card Body -->
                </div> <!-- End Card -->
            </div> <!-- End Column -->
        </div> <!-- End Row -->
    </div> <!-- End Container -->
@endsection

@push('script')
    <div wire:ignore.self>
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
                Livewire.on('warning', (event) => {
                    Swal.fire({
                        title: event.title,
                        text: "यो क्रिया पुनः फर्काउन सकिने छैन!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "हो, सम्पादन गरौं!",
                        cancelButtonText: "रद्द गर्नुहोस्"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('confirmCancelOrder');
                        }
                    });

                });
            });
        </script>
    </div>
@endpush
