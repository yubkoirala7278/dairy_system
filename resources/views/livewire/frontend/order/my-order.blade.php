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
                        <h5>मेरो अर्डरहरू</h5>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Order Items Table -->
                        <div class="table-responsive">
                            <div class="d-lg-flex justify-content-between align-items-center  py-2 ">
                                <div class="mb-3 mb-lg-0">
                                    <label class="d-flex align-items-center gap-2">
                                        <span>प्रदर्शन गर्नुहोस्</span>
                                        <select name="withdraw-request-list_length" aria-controls="withdraw-request-list"
                                            class="form-select form-select-sm w-auto"
                                            wire:model.live.debounce.500ms="entries">
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
                            </div>
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr style="vertical-align: middle">
                                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                                            अर्डर नम्बर</th>
                                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                                            स्थिति
                                        </th>
                                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                                            उपकुल(रु)</th>
                                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                                            ढुवानी
                                            शुल्क(रु)</th>
                                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                                            कुल(रु)</th>
                                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                                            मिति
                                        </th>
                                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                                            उत्पादन विवरण</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($orders) > 0)
                                    @foreach ($orders as $key => $order)
                                        <tr wire:key="{{ $key }}" style="vertical-align: middle">
                                            <td style="white-space: nowrap;min-width:150px">{{ $order->nepali_count }}</td>
                                            <td style="white-space: nowrap;min-width:150px">
                                                @if ($order->status == 'pending')
                                                    <span class="badge bg-warning text-dark py-2">विचाराधीन</span>
                                                @elseif($order->status == 'delivered')
                                                    <span class="badge bg-success py-2 text-white">पुर्याइएको</span>
                                                @elseif($order->status == 'cancelled')
                                                    <span class="badge bg-danger py-2 text-white">रद्द गरिएको</span>
                                                @endif
                                            </td>
                                            <td style="white-space: nowrap;min-width:150px">{{ $order->sub_total_nepali }}</td>
                                            <td style="white-space: nowrap;min-width:150px">{{ $order->shipping_charge_nepali }}
                                            </td>
                                            <td style="white-space: nowrap;min-width:150px">{{ $order->total_charge_nepali }}</td>
                                            @php
                                                $year = $order->created_at->format('Y');
                                                $month = $order->created_at->format('m');
                                                $day = $order->created_at->format('d');
                                                $date = Bsdate::eng_to_nep($year, $month, $day);
                                            @endphp
                                            <td style="white-space: nowrap;min-width:200px">
                                                {{ html_entity_decode($date['date']) . ' ' . html_entity_decode($date['nmonth']) . ' ' . html_entity_decode($date['year']) . ', ' . $date['day'] }}
                                            </td>
                                            <td>
                                                <a class="btn btn-success rounded-pill btn-sm"
                                                    href="{{ route('frontend.my-order-details', $order->slug) }}">अर्डर विवरण</a>
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
                            <div class="ml-4 mt-3">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
                        </div>

                    </div> <!-- End Card Body -->
                </div> <!-- End Card -->
            </div> <!-- End Column -->
        </div> <!-- End Row -->
    </div> <!-- End Container -->
@endsection

