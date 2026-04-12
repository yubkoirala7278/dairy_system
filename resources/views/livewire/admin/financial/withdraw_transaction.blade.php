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
                        <option value="all">सबै</option>
                    </select>
                    <span>डेटा</span>
                </label>
            </div>
            <div class="d-flex align-items-center" style="column-gap: 10px">
                <input type="search" class="form-control  translate-nepali" placeholder="खोज्नुहोस्..."
                    aria-controls="withdraw-request-list" wire:model.live.debounce.500ms="search">
                <input type="text" id="amount_withdraw_date" class="form-control " wire:model.live="amount_withdraw_date"
                    placeholder="नगद निकासी मिति">
                <button type="button" class="btn btn-secondary px-3 rounded-pill btn-flex"
                    wire:click="printWithdrawTransaction()">
                    PDF
                </button>
                <button type="button" class="btn btn-secondary px-3 btn-flex  rounded-pill"
                    wire:click="exportToExcel">Excel</button>
            </div>
        </div>

        <!-- Table Wrapper for Horizontal Scroll -->
        <div class="table-responsive">
            <table class="table table-bordered" style="font-size: 16px; min-width: 800px; width: 100%;">
                <thead>
                    <tr class="table-secondary">
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">कृषक
                            नम्बर</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">कृषकको
                            नाम</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            फोन नम्बर</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            स्थान</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            निकासी
                            रकम(रु)</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            मिति</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($withdrawTransactions) > 0)
                        @foreach ($withdrawTransactions as $key => $withdraw)
                            <tr wire:key="{{ $key }}">
                                <td>{{ $withdraw->account->user->farmer_number }}</td>
                                <td>{{ $withdraw->account->user->owner_name }}</td>
                                <td>{{ $withdraw->account->user->phone_number }}</td>
                                <td>{{ $withdraw->account->user->location }}</td>
                                <td>{{ $withdraw->nepali_amount }}</td>
                                @php
                                    $year = $withdraw->created_at->format('Y');
                                    $month = $withdraw->created_at->format('m');
                                    $day = $withdraw->created_at->format('d');
                                    $date = Bsdate::eng_to_nep($year, $month, $day);
                                @endphp
                                <td style="white-space: nowrap;">
                                    {{ html_entity_decode($date['date']) .
                                        ' ' .
                                        html_entity_decode($date['nmonth']) .
                                        ' ' .
                                        html_entity_decode($date['year']) .
                                        ', ' .
                                        $date['day'] }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="fs-5 fw-semibold  bg-body-secondary">
                                कुल बचत
                            </td>
                            <td colspan="20" class="fs-5 fw-semibold  bg-body-secondary">
                                रु {{ $sumWithdrawAmount }}
                            </td>
                        </tr>
                    @endif
                    @if (count($withdrawTransactions) <= 0)
                        <tr class="text-center">
                            <td colspan="20">प्रदर्शन गर्नका लागि कुनै डाटा छैन</td>
                        </tr>
                    @endif


                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="ml-4">
            @if ($entries !== 'all')
                {{ $withdrawTransactions->links() }}
            @endif
        </div>
    </div>
@endsection

@section('modal')
@endsection

@push('script')
    <div wire:ignore.self>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('open-new-tab', (event) => {
                    window.open(event.url, '_blank');
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                // Initialize the Nepali Date Picker
                $('#amount_withdraw_date').nepaliDatePicker({
                    onChange: function() {
                        // Manually trigger Livewire update
                        var nepaliDate = $('#amount_withdraw_date').val();
                        // Convert to Nepali numerals before sending to Livewire
                        var nepaliDateInNepaliNumerals = NepaliFunctions.ConvertToUnicode(nepaliDate);
                        @this.set('amount_withdraw_date', nepaliDateInNepaliNumerals);
                    }
                });
            });
        </script>
    </div>
@endpush

@section('custom-style')
    <style>
        .table td {
            vertical-align: middle !important;
        }
    </style>
@endsection
