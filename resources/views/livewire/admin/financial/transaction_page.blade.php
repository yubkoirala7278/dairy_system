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
                <button type="button" class="btn btn-secondary px-3 rounded-pill btn-flex" wire:click="printTransaction()">
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
                        {{-- <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                        क्र.सं.</th> --}}
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">कृषक
                            नम्बर</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">कृषकको
                            नाम</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            फोन नम्बर</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            स्थान</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">कुल
                            रकम(रु)</th>
                        {{-- <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            बक्यौता रकम(रु)</th> --}}
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            कार्य</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($usersWithTransaction) > 0)
                        @foreach ($usersWithTransaction as $key => $user)
                            <tr wire:key="{{ $key }}">
                                <td>{{ $user->user->farmer_number }}</td>
                                <td>{{ $user->user->owner_name }}</td>
                                <td>{{ $user->user->phone_number }}</td>
                                <td>{{ $user->user->location }}</td>
                                <td>{{ $user->nepali_balance }}</td>
                                <td>
                                    <button type="button" class="btn btn-success rounded-pill" data-bs-toggle="modal"
                                        data-bs-target="#depositModal"
                                        wire:click="getUserInfo({{ $user->user->id }}, {{ $user->balance }})">
                                        <i class="fa-solid fa-sack-dollar me-2"></i>जमाफेरी
                                    </button>
                                    <button type="button" class="btn btn-dark text-white rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#withdrawModal"
                                        wire:click="getUserInfo({{ $user->user->id }}, {{ $user->balance }})">
                                        <i class="fa-solid fa-money-bill-transfer me-2"></i>निकासी
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="fs-5 fw-semibold  bg-body-secondary">
                                कुल बचत
                            </td>
                            <td colspan="20" class="fs-5 fw-semibold  bg-body-secondary">
                                रु {{$totalBalance}}
                            </td>
                        </tr>
                    @endif
                    @if (count($usersWithTransaction) <= 0)
                        <tr class="text-center">
                            <td colspan="20">प्रदर्शन गर्नका लागि कुनै किसान छैनन्</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="ml-4">
            @if ($entries !== 'all')
                {{ $usersWithTransaction->links() }}
            @endif
        </div>
    </div>
@endsection

@section('modal')
    {{-- deposit modal --}}
    <div class="modal fade" wire:ignore.self id="depositModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header text-white" style="background-color: #515F52">
                    <h1 class="modal-title fs-5" id="depositModalLabel">{{ $owner_name }} को
                        खाता मा रकम जम्मा गर्नुहोस्</h1>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetFields"></button>
                </div>
                <div class="modal-body" style="background-color: #F4F5F8">
                    <form>
                        <div class="mb-3">
                            <div class="d-flex align-item-center justify-content-between">
                                <label for="deposit_amount" class="form-label text-dark">रकम</label>
                                <span>रु {{ $available_balance_nepali }}</span>
                            </div>
                            <input type="number" class="form-control" id="deposit_amount" wire:model="deposit_amount"
                                placeholder="जम्मा गर्नको लागि रकम भर्नुहोस्">
                            @if ($errors->has('deposit_amount'))
                                <span class="text-danger">{{ $errors->first('deposit_amount') }}</span>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark rounded-pill" data-bs-dismiss="modal"
                        wire:click="resetFields">रद्द
                        गर्नुहोस्</button>
                    <button type="button" class="btn btn-success rounded-pill" wire:click="checkDepositInfo">जम्मा
                        गर्नुहोस्</button>
                </div>
            </div>
        </div>
    </div>
    {{-- withdraw modal --}}
    <div class="modal fade" wire:ignore.self id="withdrawModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: #515F52">
                    <h1 class="modal-title fs-5" id="withdrawModalLabel">{{ $owner_name }} को खाताबाट रकम झिक्नुहोस्
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetFields"></button>
                </div>
                <div class="modal-body" style="background-color: #F4F5F8">
                    <form>
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <label for="withdraw_amount" class="form-label text-dark">रकम</label>
                                <span>रु {{ $available_balance_nepali }}</span>
                            </div>
                            <input type="number" class="form-control" id="withdraw_amount" wire:model="withdraw_amount"
                                placeholder="रकम झिक्नको लागि यहाँ भर्नुहोस्">
                            @if ($errors->has('withdraw_amount'))
                                <span class="text-danger">{{ $errors->first('withdraw_amount') }}</span>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark rounded-pill" data-bs-dismiss="modal"
                        wire:click="resetFields">रद्द गर्नुहोस्</button>
                    <button type="button" class="btn btn-success rounded-pill" wire:click="checkWithdrawInfo">रकम
                        झिक्नुहोस्</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <div wire:ignore.self>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('success', (event) => {
                    $('#depositModal').modal('hide');
                    $('#withdrawModal').modal('hide');
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
                Livewire.on('warningForDeposit', (event) => {
                    Swal.fire({
                        title: event.title,
                        text: "यो प्रक्रिया एकपटक पूरा भएपछि पुनः फर्काउन सकिने छैन। कृपया एक पटक पुनः जाँच गर्नुहोस्!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "हो, जम्मा गरौं!",
                        cancelButtonText: "रद्द गर्नुहोस्"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('confirmDeposit');
                        }
                    });

                });

                Livewire.on('warningForWithdraw', (event) => {
                    Swal.fire({
                        title: event.title,
                        text: "यो प्रक्रिया एकपटक पूरा भएपछि पुनः फर्काउन सकिने छैन। कृपया एक पटक पुनः जाँच गर्नुहोस्!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "हो, जम्मा गरौं!",
                        cancelButtonText: "रद्द गर्नुहोस्"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('confirmWithdraw');
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

@section('custom-style')
    <style>
        .table td {
            vertical-align: middle !important;
        }
    </style>
@endsection
