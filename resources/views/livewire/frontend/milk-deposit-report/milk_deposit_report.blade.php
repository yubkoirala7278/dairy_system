@extends('livewire.frontend.layouts.master')
@section('custom-style')
    <!-- Nepali Datepicker -->
    <link href="{{ asset('backend_assets/calender/nepali.datepicker.v4.0.4.min.css') }}" rel="stylesheet" type="text/css" />
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
                        <h5>दूध संकलन रिपोर्ट</h5>
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
                                <div class="d-flex align-items-center" style="column-gap: 20px">
                                    <input type="search" class="form-control  translate-nepali" placeholder="खोज्नुहोस्..."
                                        aria-controls="withdraw-request-list" wire:model.live.debounce.500ms="search">
                                    <input type="text" id="milk_deposit_date" class="form-control "
                                        wire:model.live="milk_deposit_date" placeholder="दूध सङ्कलन मिति">
                                </div>
                            </div>
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th scope="col" style="font-size: 20px; white-space: nowrap;">मिति</th>
                                        <th scope="col" style="font-size: 20px; white-space: nowrap;">प्रहर</th>
                                        <th scope="col" style="font-size: 20px; white-space: nowrap;">प्रकार</th>
                                        <th scope="col" style="font-size: 20px; white-space: nowrap;">दूध लि.</th>
                                        <th scope="col" style="font-size: 20px; white-space: nowrap;">FAT</th>
                                        <th scope="col" style="font-size: 20px; white-space: nowrap;">SNF</th>
                                        <th scope="col" style="font-size: 20px; white-space: nowrap;">मूल्य(रु)</th>
                                        <th scope="col" style="font-size: 20px; white-space: nowrap;">कुल कमिशन(रु)</th>
                                        <th scope="col" style="font-size: 20px; white-space: nowrap;">प्र.लि(रु)</th>
                                        <th scope="col" style="font-size: 20px; white-space: nowrap;">जम्मा(रु)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($milkDeposits) > 0)
                                        @foreach ($milkDeposits as $key => $deposit)
                                            <tr wire:key="{{ $key }}">
                                                <td style="white-space: nowrap;">{{ $deposit->milk_deposit_date }}</td>
                                                <td style="white-space: nowrap;">{{ $deposit->milk_deposit_time }}</td>
                                                <td style="white-space: nowrap;">{{ $deposit->milk_type }}</td>
                                                <td style="white-space: nowrap;">{{ $deposit->milk_quantity }}</td>
                                                <td style="white-space: nowrap;">{{ $deposit->milk_fat }}</td>
                                                <td style="white-space: nowrap;">{{ $deposit->milk_snf }}</td>
                                                <td style="white-space: nowrap;">{{ $deposit->milk_price_per_ltr }}</td>
                                                <td style="white-space: nowrap;">{{ $deposit->per_ltr_commission }}</td>
                                                <td style="white-space: nowrap;">{{ $deposit->milk_per_ltr_price_with_commission }}</td>
                                                <td style="white-space: nowrap;">{{ $deposit->milk_total_price }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="text-white" style="background-color: #32705f">
                                            <td colspan="2" style="white-space: nowrap;">कुल दूध संकलन: {{ $totalMilkQuantity }} लिटर </td>
                                            <td colspan="20" style="white-space: nowrap;">कुल मूल्य: {{ $totalDepositIncome }} रुपैया</td>
                                        </tr>
                                    @endif
                                    @if (count($milkDeposits) <= 0)
                                        <tr class="text-center">
                                            <td colspan="20" style="white-space: nowrap;">दूध सङ्कलन देखाउनको लागि कुनै डेटा छैन..</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="ml-4 mt-3">
                                {{ $milkDeposits->links() }}
                            </div>
                        </div>

                    </div> <!-- End Card Body -->
                </div> <!-- End Card -->
            </div> <!-- End Column -->
        </div> <!-- End Row -->
    </div> <!-- End Container -->
@endsection

@push('script')
    <div wire:ignore.self>
        {{-- nepali date picker --}}
        <script src="{{ asset('backend_assets/calender/nepali.datepicker.v4.0.4.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                // Initialize the Nepali Date Picker
                $('#milk_deposit_date').nepaliDatePicker({
                    onChange: function() {
                        // Manually trigger Livewire update
                        var nepaliDate = $('#milk_deposit_date').val();
                        // Convert to Nepali numerals before sending to Livewire
                        var nepaliDateInNepaliNumerals = NepaliFunctions.ConvertToUnicode(nepaliDate);
                        @this.set('milk_deposit_date', nepaliDateInNepaliNumerals);
                    }
                });
            });
        </script>
    </div>
@endpush
