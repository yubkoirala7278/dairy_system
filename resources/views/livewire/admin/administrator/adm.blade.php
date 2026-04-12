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
                <div class="d-flex align-items-center" style="column-gap: 5px">
                    <button type="button" class="btn btn-success px-3 btn-flex "
                        style="border-radius: 30px;min-width:130px" data-bs-toggle="modal"
                        data-bs-target="#addNewTeamMember">सञ्चालक थप्नुहोस्</button>
                </div>
            </div>
        </div>

        <!-- Table Wrapper for Horizontal Scroll -->
        <div class="table-responsive">
            <table class="table table-bordered" style="font-size: 16px; min-width: 800px; width: 100%;">
                <thead>
                    <tr class="table-secondary">
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            क्र.सं.</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            सञ्चालकको नाम</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            फोन नम्बर</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            लिङ्ग</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            ठेगाना</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            प्रोफाइल</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            पद</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            स्थिति</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            क्रमबद्धता</th>
                        <th scope="col" style="font-size: 16px; white-space: nowrap;" style="white-space: nowrap;">
                            कार्य</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($administrators) > 0)
                        @foreach ($administrators as $key => $administrator)
                            <tr wire:key="{{ $key }}">
                                <td>{{ $administrator->sn }}</td>
                                <td>{{ $administrator->name }}</td>
                                <td>{{ $administrator->phone_no }}</td>
                                <td>{{ $administrator->gender }}</td>
                                <td>{{ $administrator->location }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $administrator->profile_image) }}" alt="Profile Image"
                                        style="height: 30px; cursor: pointer;"
                                        onclick="openImageModal('{{ asset('storage/' . $administrator->profile_image) }}')"
                                        loading="lazy">
                                </td>
                                <td>{{ $administrator->position }}</td>
                                <td>
                                    @if ($administrator->status == 'चालू')
                                        <span class="badge text-bg-success">चालू</span>
                                    @else
                                        <span class="badge text-bg-danger">बन्द</span>
                                    @endif
                                </td>
                                <td>{{ $administrator->rank }}</td>
                                <td>
                                    <div class="d-flex gap-2 align-items-center">
                                        <!-- Edit Button -->
                                        <button
                                            class="btn btn-warning shadow-sm text-dark  rounded-1 d-flex justify-content-center align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#updateTeamMember" title="सुधार्नुहोस्"
                                            wire:click="edit({{ $administrator->id }})" style="height: 20px;width:20px">
                                            <i class="fa-solid fa-pencil fs-6"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <button
                                            class="btn btn-danger shadow-sm text-white  rounded-1 d-flex justify-content-center align-items-center"
                                            onclick="confirmDelete({{ $administrator->id }})" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="मेटाउनुहोस्" style="height: 20px;width:20px">
                                            <i class="fa-solid fa-trash fs-6"></i>
                                        </button>

                                        <!-- Change Status Button -->
                                        <button
                                            class="btn btn-dark shadow-sm text-white  rounded-1 d-flex justify-content-center align-items-center"
                                            onclick="confirmChangeStatus({{ $administrator->id }})" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="स्थिति परिवर्तन गर्नुहोस्"
                                            style="height: 20px;width:20px">
                                            <i class="fa-solid fa-toggle-on fs-6"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    @if (count($administrators) <= 0)
                        <tr class="text-center">
                            <td colspan="20">दिखाउनको लागि कुनै सदस्यहरू छैनन्..</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="ml-4">
            @if ($entries !== 'all')
                {{ $administrators->links() }}
            @endif
        </div>
    </div>
@endsection

@section('modal')
    {{-- add new team member --}}
    <div class="modal fade" wire:ignore.self id="addNewTeamMember" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="addNewTeamMemberLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h1 class="modal-title fs-5" id="addNewTeamMemberLabel">नयाँ सञ्चालक थप्नुहोस्</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetFields"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark">सञ्चालकको नाम</label>
                            <input type="text" class="form-control translate-nepali" id="name" name="name"
                                placeholder="सञ्चालकको नाम यहाँ लेख्नुहोस्" wire:model="name">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="profile_image" class="form-label text-dark">सञ्चालकको प्रोफाइल</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image"
                                wire:model="profile_image">
                            @if ($errors->has('profile_image'))
                                <span class="text-danger">{{ $errors->first('profile_image') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label text-dark">सञ्चालकको पद</label>
                            <input type="text" class="form-control translate-nepali" id="position" name="position"
                                placeholder="पद लेख्नुहोस्" wire:model="position">
                            @if ($errors->has('position'))
                                <span class="text-danger">{{ $errors->first('position') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="phone_no" class="form-label text-dark">सञ्चालकको फोन नम्बर</label>
                            <input type="text" class="form-control translate-nepali" id="phone_no" name="phone_no"
                                placeholder="फोन नम्बर लेख्नुहोस्" wire:model="phone_no">
                            @if ($errors->has('phone_no'))
                                <span class="text-danger">{{ $errors->first('phone_no') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label text-dark">सञ्चालकको ठेगाना</label>
                            <input type="text" class="form-control translate-nepali" id="location" name="location"
                                placeholder="ठेगाना लेख्नुहोस्" wire:model="location">
                            @if ($errors->has('location'))
                                <span class="text-danger">{{ $errors->first('location') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label text-dark">सञ्चालकको स्थिति</label>
                            <select class="form-select" id="status" name="status" wire:model="status">
                                <option value="चालू">चालू</option>
                                <option value="बन्द">बन्द</option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label text-dark">सञ्चालकको लिङ्ग</label>
                            <select class="form-select" id="gender" name="gender" wire:model="gender">
                                <option value="पुरुष">पुरुष</option>
                                <option value="महिला">महिला</option>
                                <option value="अन्य">अन्य</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="rank" class="form-label text-dark">सञ्चालकको रैंक</label>
                            <input type="number" class="form-control translate-nepali" id="rank" name="rank"
                                placeholder="रैंक लेख्नुहोस्" wire:model="rank" wire:ignore>
                            @if ($errors->has('rank'))
                                <span class="text-danger">{{ $errors->first('rank') }}</span>
                            @endif
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:click="resetFields">रद्द
                        गर्नुहोस्</button>
                    <button type="button" class="btn btn-success" wire:click="store">सबमिट गर्नुहोस्</button>
                </div>
            </div>
        </div>
    </div>
    {{-- edit team member --}}
    <div class="modal fade" wire:ignore.self id="updateTeamMember" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="updateTeamMemberLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h1 class="modal-title fs-5" id="updateTeamMemberLabel">नयाँ सञ्चालक थप्नुहोस्</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetFields"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark">सञ्चालकको नाम</label>
                            <input type="text" class="form-control translate-nepali" id="name" name="name"
                                placeholder="सञ्चालकको नाम यहाँ लेख्नुहोस्" wire:model="name">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="profile_image" class="form-label text-dark">सञ्चालकको प्रोफाइल</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image"
                                wire:model="profile_image">
                            @if ($errors->has('profile_image'))
                                <span class="text-danger">{{ $errors->first('profile_image') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label text-dark">सञ्चालकको पद</label>
                            <input type="text" class="form-control translate-nepali" id="position" name="position"
                                placeholder="पद लेख्नुहोस्" wire:model="position">
                            @if ($errors->has('position'))
                                <span class="text-danger">{{ $errors->first('position') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="phone_no" class="form-label text-dark">सञ्चालकको फोन नम्बर</label>
                            <input type="text" class="form-control translate-nepali" id="phone_no" name="phone_no"
                                placeholder="फोन नम्बर लेख्नुहोस्" wire:model="phone_no">
                            @if ($errors->has('phone_no'))
                                <span class="text-danger">{{ $errors->first('phone_no') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label text-dark">सञ्चालकको ठेगाना</label>
                            <input type="text" class="form-control translate-nepali" id="location" name="location"
                                placeholder="ठेगाना लेख्नुहोस्" wire:model="location">
                            @if ($errors->has('location'))
                                <span class="text-danger">{{ $errors->first('location') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label text-dark">सञ्चालकको स्थिति</label>
                            <select class="form-select" id="status" name="status" wire:model="status">
                                <option value="चालू">चालू</option>
                                <option value="बन्द">बन्द</option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label text-dark">सञ्चालकको लिङ्ग</label>
                            <select class="form-select" id="gender" name="gender" wire:model="gender">
                                <option value="पुरुष">पुरुष</option>
                                <option value="महिला">महिला</option>
                                <option value="अन्य">अन्य</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="rank" class="form-label text-dark">सञ्चालकको रैंक</label>
                            <input type="number" class="form-control translate-nepali" id="rank" name="rank"
                                placeholder="रैंक लेख्नुहोस्" wire:model="rank" wire:ignore>
                            @if ($errors->has('rank'))
                                <span class="text-danger">{{ $errors->first('rank') }}</span>
                            @endif
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:click="resetFields">रद्द
                        गर्नुहोस्</button>
                    <button type="button" class="btn btn-success" wire:click="update">सबमिट गर्नुहोस्</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for displaying the image -->
    <div id="imageModal" wire:ignore.self class="modal fade" tabindex="-1" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">सञ्चालकको फोटो</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Profile Image" class="img-fluid"
                        style="max-height: 500px;" loading="lazy">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <div wire:ignore.self>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ========success message============
                Livewire.on('success', (event) => {
                    $('#addNewTeamMember').modal('hide');
                    $('#updateTeamMember').modal('hide');
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

                Livewire.on('editModal', (event) => {
                    $('#updateTeamMember').modal('show');
                });
            });

            // Function to open the image modal and display the clicked image
            function openImageModal(imagePath) {
                // Set the source of the image in the modal
                document.getElementById('modalImage').src = imagePath;

                // Show the modal
                $('#imageModal').modal('show');
            }

            // =====function to delete user=========
            function confirmDelete(administratorId) {
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
                        @this.call('delete', administratorId);
                    }
                });

            }

            // =====function to change status=======
            function confirmChangeStatus(administratorId) {
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
                        @this.call('changeStatus', administratorId);
                    }
                });

            }
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
