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
                        <h5>नगद निक्षेप रिपोर्ट</h5>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Order Items Table -->
                        <div class="table-responsive">
                            <div class="d-md-flex justify-content-between align-items-center py-2">
                                <div>
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
                                            <option value="all">सबै</option>
                                        </select>
                                        <span>डेटा</span>
                                    </label>
                                </div>
                                <div class="mt-2 mt-md-0">
                                    <input type="text" id="amount_deposit_date" class="form-control "
                                        wire:model.live="amount_deposit_date" placeholder="नगद सङ्कलन मिति">
                                </div>
                            </div>
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th scope="col" style="font-size: 16px; white-space: nowrap;"
                                            style="white-space: nowrap;">
                                            क्र.सं.</th>
                                        <th scope="col" style="font-size: 16px; white-space: nowrap;"
                                            style="white-space: nowrap;">
                                            निक्षेप
                                            रकम(रु)</th>
                                        <th scope="col" style="font-size: 16px; white-space: nowrap;"
                                            style="white-space: nowrap;">
                                            मिति</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($depositTransactions) > 0)
                                        @foreach ($depositTransactions as $key => $deposit)
                                            <tr wire:key="{{ $key }}">
                                                <td style="white-space: nowrap;">{{ $deposit->nepali_count }}</td>
                                                <td style="white-space: nowrap;">{{ $deposit->nepali_amount }}</td>
                                                @php
                                                    $year = $deposit->created_at->format('Y');
                                                    $month = $deposit->created_at->format('m');
                                                    $day = $deposit->created_at->format('d');
                                                    $date = Bsdate::eng_to_nep($year, $month, $day);
                                                @endphp
                                                <td style="white-space: nowrap;">
                                                    {{ html_entity_decode($date['date']) . ' ' . html_entity_decode($date['nmonth']) . ' ' . html_entity_decode($date['year']) . ', ' . $date['day'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="fs-5 fw-semibold  bg-body-secondary" style="white-space: nowrap;">
                                                कुल बचत
                                            </td>
                                            <td colspan="20" class="fs-5 fw-semibold  bg-body-secondary" style="white-space: nowrap;">
                                                रु {{ $sumDepositAmount }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if (count($depositTransactions) <= 0)
                                        <tr class="text-center">
                                            <td colspan="20" style="white-space: nowrap;">प्रदर्शन गर्नका लागि कुनै डाटा छैन</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="ml-4 mt-3">
                                @if ($entries !== 'all')
                                    {{ $depositTransactions->links() }}
                                @endif
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
                $('#amount_deposit_date').nepaliDatePicker({
                    onChange: function() {
                        // Manually trigger Livewire update
                        var nepaliDate = $('#amount_deposit_date').val();
                        // Convert to Nepali numerals before sending to Livewire
                        var nepaliDateInNepaliNumerals = NepaliFunctions.ConvertToUnicode(nepaliDate);
                        @this.set('amount_deposit_date', nepaliDateInNepaliNumerals);
                    }
                });
            });
        </script>
    </div>
@endpush
