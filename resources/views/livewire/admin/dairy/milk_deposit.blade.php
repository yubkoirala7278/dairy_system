@extends('livewire.admin.layouts.master')

@section('content')
    <div class="col-12 col-sm-12 mb-4 mb-lg-0 col-lg-4 py-3" style="background-color: #32705f;height:100vh" wire:ignore.self>
        <div class="row">
            <div class="col-12">
                <div class="mx-3 d-flex align-items-center " style=" column-gap: 30px;">
                    <div class="form-group">
                        <label for="milk_type" class="form-label h4 font-weight-bold">दूधको प्रकार</label>
                        <select class="form-control" wire:model.live="milk_type" id="milk_type">
                            <option value="मिश्रित">मिश्रित दूध</option>
                            <option value="गाईको">गाईको दूध</option>
                            <option value="भैंसीको">भैंसीको दूध</option>
                            <option value="बाख्राको">बाख्राको दूध</option>
                            <option value="भेडाको">भेडाको दूध</option>
                        </select>
                        @error('milk_type')
                            <span style="color: #ff8591 !important">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="milk_deposit_date" class="form-label h4 font-weight-bold">दूध सङ्कलन मिति</label>
                        <input type="text" id="milk_deposit_date" class="py-1" wire:model.live="milk_deposit_date">
                        <br>
                        @error('milk_deposit_date')
                            <span style="color: #ff8591 !important">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="milk_deposit_time" class="form-label h4 font-weight-bold">प्रहर</label>
                        <select class="form-control" wire:model.live="milk_deposit_time" id="milk_deposit_time">
                            <option value="बिहान">बिहान</option>
                            <option value="साझ">साझ</option>
                        </select>
                        @error('milk_deposit_time')
                            <span style="color: #ff8591 !important">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="ml-3 ">
                    <div class="form-group">
                        <label for="farmernumber" class="form-label h4 font-weight-bold">कृषक नम्बर</label>
                        <input type="text" class="form-control translate-nepali" id="farmernumber"
                            wire:model.live.debounce.300ms="farmernumber" placeholder="कृषकको नम्बर लेख्नुहोस्" autofocus>
                        @if ($errors->has('farmernumber'))
                            <span style="color: #ff8591 !important">{{ $errors->first('farmernumber') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="milkQuantity" class="form-label h4 font-weight-bold">दुध (लि.)</label>
                        <input type="number" class="form-control" id="milkQuantity" wire:model.live="milkQuantity"
                            placeholder="दुधको मात्रा लेख्नुहोस्">
                        @if ($errors->has('milkQuantity'))
                            <span style="color: #ff8591 !important">{{ $errors->first('milkQuantity') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="milk_fat" class="form-label h4 font-weight-bold">फ्याट</label>
                        <input type="number" class="form-control" id="milk_fat" wire:model.live="milk_fat"
                            placeholder="दुधको फ्याट लेख्नुहोस्">
                        @if ($errors->has('milk_fat'))
                            <span style="color: #ff8591 !important">{{ $errors->first('milk_fat') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="milk_snf" class="form-label h4 font-weight-bold">एस.एन.एफ</label>
                        <input type="number" class="form-control " id="milk_snf" wire:model.live="milk_snf"
                            placeholder="दुधको एस.एन.एफ लेख्नुहोस्">
                        @if ($errors->has('milk_snf'))
                            <span style="color: #ff8591 !important">{{ $errors->first('milk_snf') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label for="owner_name" class="form-label h4 font-weight-bold">सदस्यको नाम</label>
                    <input type="text" class="form-control translate-nepali" id="owner_name" wire:model="owner_name"
                        disabled>
                    @error('owner_name')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="location" class="form-label h4 font-weight-bold">सदस्यको ठेगाना</label>
                    <input type="text" class="form-control translate-nepali" id="location" wire:model="location"
                        disabled>
                    @error('location')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone_number" class="form-label h4 font-weight-bold">सदस्यको फोन नम्बर</label>
                    <input type="text" class="form-control translate-nepali" id="phone_number" wire:model="phone_number"
                        disabled>
                    @error('phone_number')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="col-12">
                <div class="d-flex align-items-center mx-3" style="column-gap: 20px">
                    <div class="form-group">
                        <label for="per_litre_commission" class="form-label h4 font-weight-bold">प्र.लि.
                            कमिशन</label>
                        <input type="number" class="form-control" id="per_litre_commission"
                            wire:model.live="per_litre_commission">
                        @error('per_litre_commission')
                            <span style="color: #ff8591 !important">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="per_litre_price" class="form-label h4 font-weight-bold">प्रति लि.(रु.)</label>
                        <input type="number" class="form-control" id="per_litre_price" wire:model="per_litre_price"
                            disabled>
                        @error('per_litre_price')
                            <span style="color: #ff8591 !important">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="total_milk_price" class="form-label h4 font-weight-bold">कुल रकम(रु.)</label>
                        <input type="number" class="form-control " id="total_milk_price" wire:model="total_milk_price"
                            disabled>
                        @error('total_milk_price')
                            <span style="color: #ff8591 !important">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="mx-3">
                    <button class="btn btn-success mr-2" wire:click.prevent="register" style="font-size: 19px">पेश
                        गर्नुहोस्</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8" style="background-color: #eee;height:100vh;overflow-y:auto" wire:ignore.self>
        <div class="custom-overflow-x" style=" max-width: 100%;">
            <div class="d-md-flex justify-content-between align-items-center mx-4 py-2">
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
                            <option value="1000">सबै</option>
                        </select>
                        <span>डेटा</span>
                    </label>

                </div>
                <div class="d-flex align-items-center" style="column-gap: 20px">
                    <input type="search" class="form-control form-control-sm translate-nepali"
                        placeholder="खोज्नुहोस्..." aria-controls="withdraw-request-list"
                        wire:model.live.debounce.500ms="search">
                    <div class="d-flex align-items-center" style="column-gap: 5px">
                        <button type="button" class="btn btn-secondary px-3 radius-30 btn-flex"
                            style="border-radius: 30px;" wire:click="printMilkDeposits">PDF</button>
                            <button type="button" class="btn btn-secondary px-3 btn-flex" style="border-radius: 30px;"
                            wire:click="exportToExcel" >Excel</button>
                    </div>
                </div>

            </div>
            <table class="table table-bordered table-hover ml-4 " style="font-size: 20px; min-width: 800px; width: 100%;">
                <thead>
                    <tr class="table-secondary">
                        {{-- <th scope="col" style="font-size: 20px; white-space: nowrap;">मिति</th> --}}
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">कृ.न.</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">कृषक नाम</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">प्रकार</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">दूध लि.</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">FAT</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">SNF</th>
                        {{-- <th scope="col" style="font-size: 20px; white-space: nowrap;">मूल्य</th> --}}
                        {{-- <th scope="col" style="font-size: 20px; white-space: nowrap;">कुल कमिशन</th> --}}
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">प्र.लि(रु)</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">जम्मा(रु)</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">कार्य</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($milkDeposits) > 0)
                        @foreach ($milkDeposits as $key => $deposit)
                            <tr wire:key="{{ $key }}">
                                {{-- <td>{{$deposit->milk_deposit_date}}</td> --}}
                                <td>{{ $deposit->user->farmer_number }}</td>
                                <td>{{ $deposit->user->owner_name }}</td>
                                <td>{{ $deposit->milk_type }}</td>
                                <td>{{ $deposit->milk_quantity }}</td>
                                <td>{{ $deposit->milk_fat }}</td>
                                <td>{{ $deposit->milk_snf }}</td>
                                {{-- <td>{{$deposit->milk_price_per_ltr}}</td> --}}
                                {{-- <td>{{$deposit->per_ltr_commission}}</td> --}}
                                <td>{{ $deposit->milk_per_ltr_price_with_commission }}</td>
                                <td>{{ $deposit->milk_total_price }}</td>
                                <td class="d-flex gap-2 align-items-center">
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning shadow-sm text-dark  rounded-1 d-flex justify-content-center align-items-center"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="सुधार्नुहोस्"
                                        wire:click="edit({{ $deposit->id }})" style="height: 20px;width:20px">
                                        <i class="fa-solid fa-pencil fs-6"></i>
                                    </button>
                                
                                    <!-- Delete Button -->
                                    <button class="btn btn-danger shadow-sm text-white  rounded-1 d-flex justify-content-center align-items-center"
                                        onclick="confirmDelete({{ $deposit->id }})"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="मेटाउनुहोस्" style="height: 20px;width:20px">
                                        <i class="fa-solid fa-trash  fs-6"></i>
                                        {{-- <span>मेटाउनुहोस्</span> --}}
                                    </button>
                                </td>
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
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = [
                    document.getElementById('farmernumber'),
                    document.getElementById('milkQuantity'),
                    document.getElementById('milk_fat'),
                    document.getElementById('milk_snf'),
                    document.getElementById('per_litre_commission')
                ];

                inputs.forEach((input, index) => {
                    input.addEventListener('keydown', function(event) {
                        if (event.key === 'Enter') {
                            event.preventDefault(); // Prevent the form from submitting

                            // Move to the next input or trigger the submit button
                            if (index < inputs.length - 1) {
                                inputs[index + 1].focus();
                            } else {
                                // Trigger Livewire method by simulating a click event on the button
                                document.querySelector('button[wire\\:click\\.prevent="register"]')
                                    .click();
                                document.getElementById('farmernumber').focus();
                            }
                        }
                    });
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
                    }).then(() => {
                        document.getElementById('farmernumber').focus();
                    });

                });
                Livewire.on('warning', (event) => {
                    Swal.fire({
                        title: 'के तपाईं यसलाई सम्पादन गर्न निश्चित हुनुहुन्छ?',
                        text: "यो क्रिया पुनः फर्काउन सकिने छैन!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "हो, सम्पादन गरौं!",
                        cancelButtonText: "रद्द गर्नुहोस्"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('confirmUpdate');
                        }
                    });

                });
                Livewire.on('open-new-tab', (event) => {
                    window.open(event.url, '_blank');
                });
            });
        </script>
        <script>
            function confirmDelete(depositId) {
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
                        @this.call('delete', depositId);
                    }
                });

            }
        </script>
    </div>
@endpush
