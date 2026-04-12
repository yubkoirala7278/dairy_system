@extends('livewire.admin.layouts.master')
@section('content')
    <div class="col-12 col-sm-12 mb-4 mb-lg-0 col-lg-3 py-3" style="background-color: #32705f;" wire:ignore.self>
        <div class="mx-3">
            <form>
                <div class="form-group">
                    <label for="name" class="form-label h4 font-weight-bold">कृषकको नाम</label>
                    <input type="text" class="form-control translate-nepali" id="name" wire:model="name"
                        placeholder="कृषकको नाम लेख्नुहोस्">
                    @error('name')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="location" class="form-label h4 font-weight-bold">कृषकको ठेगाना</label>
                    <input type="text" class="form-control translate-nepali" id="location" wire:model="location"
                        placeholder="कृषकको ठेगाना लेख्नुहोस्">

                    @error('location')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="farmer_number" class="form-label h4 font-weight-bold">कृषकको नम्बर</label>
                    <input type="number" class="form-control translate-nepali" id="farmer_number"
                        wire:model="farmer_number" title="कृपया नम्बर प्रविष्ट गर्नुहोस्" inputmode="numeric"
                        placeholder="कृषकको नम्बर लेख्नुहोस्">

                    @error('farmer_number')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="owner_name" class="form-label h4 font-weight-bold">हकवाला व्यक्तिको नाम</label>
                    <input type="text" class="form-control translate-nepali" id="owner_name" wire:model="owner_name"
                        placeholder="हकवाला व्यक्तिको नाम लेख्नुहोस्">

                    @error('owner_name')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone_number" class="form-label h4 font-weight-bold">फोन नम्बर</label>
                    <input type="text" class="form-control translate-nepali" id="phone_number" wire:model="phone_number"
                        placeholder="फोन नम्बर लेख्नुहोस्">

                    @error('phone_number')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label for="pan_number" class="form-label h4 font-weight-bold">पान नम्बर (वैकल्पिक)</label>
                    <input type="number" class="form-control translate-nepali" id="pan_number" wire:model="pan_number"
                        placeholder="पान नम्बर लेख्नुहोस्">

                    @error('pan_number')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="vat_number" class="form-label h4 font-weight-bold">भ्याट नम्बर (वैकल्पिक)</label>
                    <input type="number" class="form-control translate-nepali" id="vat_number" wire:model="vat_number"
                        placeholder="भ्याट नम्बर लेख्नुहोस्">

                    @error('vat_number')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="form-group">
                    <label for="password" class="form-label h4 font-weight-bold">पासवर्ड</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" wire:model="password"
                            placeholder="पासवर्ड लेख्नुहोस्">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="#password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="password_confirmation" class="form-label h4 font-weight-bold">पासवर्ड पुष्ट
                        गर्नुहोस्</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password_confirmation"
                            wire:model="password_confirmation" placeholder="पासवर्ड पुनः लेख्नुहोस्">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="#password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    @error('password_confirmation')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="gender" class="form-label h4 font-weight-bold">लिङ्ग</label>
                    <select class="form-control" wire:model="gender" id="gender">
                        <option value="पुरुष">पुरुष</option>
                        <option value="महिला">महिला</option>
                        <option value="अन्य">अन्य</option>
                    </select>
                    @error('gender')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label for="status" class="form-label h4 font-weight-bold">अवस्था</label>
                    <select class="form-control" wire:model="status" id="status">
                        <option value="चालू">चालू</option>
                        <option value="बन्द">बन्द</option>
                    </select>
                    @error('status')
                        <span style="color: #ff8591 !important">{{ $message }}</span>
                    @enderror
                </div> --}}

                <button class="btn btn-success" wire:click.prevent="register" style="font-size: 19px">पेश
                    गर्नुहोस्</button>

            </form>
        </div>
    </div>
    <div class="col-12 col-lg-9" style="background-color: #eee;height:100vh;overflow-y:auto" wire:ignore.self>
        <div class="custom-overflow-x" style=" max-width: 100%;">
            <div class="d-lg-flex justify-content-between align-items-center mx-4 py-2">
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
                            <option value="all">सबै</option>
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
                            style="border-radius: 30px;" wire:click="printUsers()">
                            PDF
                        </button>
                        <button type="button" class="btn btn-secondary px-3 btn-flex" style="border-radius: 30px;"
                            wire:click="exportToExcel" >Excel</button>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-hover ml-4" style="font-size: 20px; min-width: 800px; width: 100%;">
                <thead>
                    <tr class="table-secondary">
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">कृषक नम्बर</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">नाम</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">ठेगाना</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">लिङ्ग</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">फोन</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">अवस्था</th>
                        <th scope="col" style="font-size: 20px; white-space: nowrap;">कार्य</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($users) > 0)
                        @foreach ($users as $key => $user)
                            <tr wire:key="{{ $key }}">
                                <td>{{ $user->farmer_number }}</td>
                                <td>{{ $user->owner_name }}</td>
                                <td>{{ $user->location }}</td>
                                <td>{{ $user->gender }}
                                </td>
                                <td>{{ $user->phone_number }}</td>
                                <td>
                                    <span class="badge {{ $user->status == 'चालू' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $user->status }}
                                    </span>
                                </td>
                                <td class="d-flex gap-2 align-items-center">
                                        <button class="btn btn-warning shadow-sm text-dark  rounded-1 d-flex justify-content-center align-items-center" data-toggle="tooltip"
                                            data-placement="top" title="सुधार्नुहोस्"
                                            wire:click="edit({{ $user->id }})" style="height: 20px;width:20px">
                                            <i class="fa-solid fa-pencil fs-6"></i>
                                        </button>

                                        <button class="btn btn-dark shadow-sm text-white  rounded-1 d-flex justify-content-center align-items-center"
                                            onclick="confirmChangeStatus({{ $user->id }})" data-toggle="tooltip"
                                            data-placement="top" title="स्थिति परिवर्तन गर्नुहोस्" style="height: 20px;width:20px">
                                            <i class="fa-solid fa-toggle-on fs-5"></i>
                                        </button>

                                        {{-- <button class="btn btn-sm btn-transparent py-0 px-1"
                                        onclick="confirmDelete({{ $user->id }})" data-toggle="tooltip"
                                        data-placement="top" title="मेटाउनुहोस्">
                                        <i class="fa-solid fa-trash fs-5 text-danger"></i>
                                    </button> --}}

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="20">प्रदर्शन गर्नको लागि कृषकहरू छैनन्..</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="ml-4">
                {{ $entries != 'all' ? $users->links() : '' }}
            </div>
        </div>
    </div>
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
                            @this.call('updateUser');
                        }
                    });

                });
                Livewire.on('open-new-tab', (event) => {
                    window.open(event.url, '_blank');
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Automatically focus on the first input field
                $('#name').focus();

                // Handle the Enter key press
                $('input, select').on('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault(); // Prevent form submission
                        const $inputs = $('input, select'); // Get all inputs and selects
                        const index = $inputs.index(this); // Get current input's index
                        if (index + 1 < $inputs.length) {
                            $inputs.eq(index + 1).focus(); // Focus on the next input
                        } else {
                            // If on the last field, you can optionally submit or do nothing
                            @this.call('register'); // Uncomment to submit on last field
                        }
                    }
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select all toggle buttons
                const togglePasswordButtons = document.querySelectorAll('.toggle-password');

                // Loop through each button and add click event
                togglePasswordButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const targetInput = document.querySelector(button.getAttribute('data-target'));

                        // Toggle the type attribute
                        if (targetInput.type === 'password') {
                            targetInput.type = 'text';
                            button.innerHTML =
                                '<i class="fas fa-eye-slash"></i>'; // Change icon to 'eye-slash'
                        } else {
                            targetInput.type = 'password';
                            button.innerHTML = '<i class="fas fa-eye"></i>'; // Change icon to 'eye'
                        }
                    });
                });
            });
        </script>
        <script>
            // =====function to delete user=========
            function confirmDelete(userId) {
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
                        @this.call('delete', userId);
                    }
                });

            }

            // =====function to change status=======
            function confirmChangeStatus(userId) {
                Swal.fire({
                    title: "के तपाईं पक्का हुनुहुन्छ?",
                    text: "यो क्रिया पुनः फर्काउन सकिने छैन!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "हो, परिवर्तन गर्नुहोस्!",
                    cancelButtonText: "रद्द गर्नुहोस्"
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('changeStatus', userId);
                    }
                });

            }
        </script>
    </div>
@endpush
