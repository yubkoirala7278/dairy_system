@extends('livewire.admin.layouts.master')
@section('content')
    <div class="col-12 py-3 px-5" style="background-color: #eee;">
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
                <input type="search" class="form-control  translate-nepali" placeholder="खोज्नुहोस्..."
                    aria-controls="withdraw-request-list" wire:model.live.debounce.500ms="search">
                <input type="text" id="milk_deposit_date" class="form-control " wire:model.live="milk_deposit_date"
                    placeholder="दूध सङ्कलन मिति">
                <div class="d-flex align-items-center" style="column-gap: 5px">
                    <button type="button" class="btn btn-secondary px-3 radius-30 btn-flex" style="border-radius: 30px;"
                        wire:click="printMilkDepositReport">PDF</button>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover " style="font-size: 20px; min-width: 800px; width: 100%;">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">कृ.न.</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">मिति</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">प्रहर</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">कृषक नाम</th>
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
                            <td>{{ $deposit->user->farmer_number }}</td>
                            <td>{{ $deposit->milk_deposit_date }}</td>
                            <td>{{ $deposit->milk_deposit_time }}</td>
                            <td>{{ $deposit->user->owner_name }}</td>
                            <td>{{ $deposit->milk_type }}</td>
                            <td>{{ $deposit->milk_quantity }}</td>
                            <td>{{ $deposit->milk_fat }}</td>
                            <td>{{ $deposit->milk_snf }}</td>
                            <td>{{ $deposit->milk_price_per_ltr }}</td>
                            <td>{{ $deposit->per_ltr_commission }}</td>
                            <td>{{ $deposit->milk_per_ltr_price_with_commission }}</td>
                            <td>{{ $deposit->milk_total_price }}</td>
                        </tr>
                    @endforeach
                    <tr class="text-white" style="background-color: #32705f">
                        <td colspan="2">कुल दूध संकलन: {{ $totalMilkQuantity }} लिटर </td>
                        <td colspan="20">कुल मूल्य: {{ $totalDepositIncome }} रुपैया</td>
                    </tr>
                @endif
                @if (count($milkDeposits) <= 0)
                    <tr class="text-center">
                        <td colspan="20">दूध सङ्कलन देखाउनको लागि कुनै डेटा छैन..</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="ml-4">
            {{ $milkDeposits->links() }}
        </div>
    </div>
@endsection

@push('script')
    <div wire:ignore.self>
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
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('open-new-tab', (event) => {
                    window.open(event.url, '_blank');
                });
            });
        </script>
    </div>
@endpush
