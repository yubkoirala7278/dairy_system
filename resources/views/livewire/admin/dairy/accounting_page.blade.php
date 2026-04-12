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
            <div class="d-flex align-items-center" style="column-gap: 10px">
                <input type="search" class="form-control  translate-nepali" placeholder="खोज्नुहोस्..."
                    aria-controls="withdraw-request-list" wire:model.live.debounce.500ms="search">
                <input type="text" id="milk_deposit_date" class="form-control " wire:model.live="milk_deposit_date"
                    placeholder="दूध सङ्कलन मिति">
                <button type="button" class="btn btn-success px-3 rounded-pill" style="width: 300px"
                    wire:click="depositMilkIncome" id="deposit-button" wire:ignore>जम्मा गर्नुहोस्</button>
                <button type="button" class="btn btn-secondary px-3 rounded-pill btn-flex" 
                    wire:click="printUsers()">
                    PDF
                </button>
                <button type="button" class="btn btn-secondary px-3 btn-flex  rounded-pill"
                    wire:click="exportToExcel">Excel</button>
            </div>

        </div>
        <table class="table table-bordered table-hover " style="font-size: 20px; min-width: 800px; width: 100%;"
            wire:ignore.self>
            <thead>
                <tr class="table-secondary">
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">
                        <input type="checkbox" id="select-all" wire:model.live="selectAll"
                            style="transform: scale(1.7); cursor: pointer;" class="ms-4 rounded-pill" wire:ignore>
                    </th>

                    <th scope="col" style="font-size: 20px; white-space: nowrap;">कृ.न.</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">कृषक नाम</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">फोन नम्बर</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">मिति</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">प्रहर</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">दूध लि.</th>
                    <th scope="col" style="font-size: 20px; white-space: nowrap;">जम्मा(रु)</th>
                </tr>
            </thead>
            <tbody>
                @if (count($milkDepositsIncome) > 0)
                    @foreach ($milkDepositsIncome as $key => $milkIncome)
                        <tr wire:key="{{ $key }}">
                            <td class="text-center">
                                <input class="form-check-input" type="checkbox" value="{{ $milkIncome->id }}"
                                    wire:model="incomes" id="checkbox-{{ $milkIncome->id }}">
                            </td>

                            <td>{{ $milkIncome->user->farmer_number }}</td>
                            <td>{{ $milkIncome->user->owner_name }}</td>
                            <td>{{ $milkIncome->user->phone_number }}</td>
                            <td>{{ $milkIncome->milkDeposits->milk_deposit_date }}</td>
                            <td>{{ $milkIncome->milkDeposits->milk_deposit_time }}</td>
                            <td>{{ $milkIncome->milkDeposits->milk_quantity_nepali }}</td>
                            <td>{{ $milkIncome->deposit_nepali }}</td>
                        </tr>
                    @endforeach
                    <tr class="text-white" style="background-color: #32705f">
                        <td colspan="2">कुल दूध संकलन: {{ $totalMilkQuantity }} लिटर </td>
                        <td colspan="20">कुल मूल्य: {{ $totalMilkTotalPrice }} रुपैया</td>
                    </tr>
                @endif
                @if (count($milkDepositsIncome) <= 0)
                    <tr class="text-center">
                        <td colspan="20">प्रदर्शन गर्न दुध डिपोजिट आय उपलब्ध छैन।</td>
                    </tr>
                @endif

            </tbody>
        </table>
        <div class="ml-4">
            {{ $entries!=='all'?$milkDepositsIncome->links():'' }}
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
                            @this.call('confirmDepositMilkIncome');
                        }
                    });

                });
                Livewire.on('open-new-tab', (event) => {
                    window.open(event.url, '_blank');
                });
            });
        </script>
    </div>
@endpush
