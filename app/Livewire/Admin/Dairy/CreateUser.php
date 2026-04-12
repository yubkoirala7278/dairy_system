<?php

namespace App\Livewire\Admin\Dairy;

use App\Exports\UsersExport;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class CreateUser extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $owner_name, $password, $farmer_number, $location, $gender = 'पुरुष', $status = 'चालू', $phone_number, $pan_number, $vat_number, $password_confirmation;
    public $page = 'farmer';
    private $userRepository;
    public $entries = 10;
    public $search = '';
    public $user_id;


    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatedEntries()
    {
        $this->resetPage('page');
    }

    public function boot(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function render()
    {
        $users = $this->userRepository->all($this->entries, $this->search);
        return view('livewire.admin.dairy.create-user', [
            'users' => $users
        ]);
    }
    // export pdf
    public function printUsers()
    {
        $url = route('admin.users.print', ['search' => $this->search ?? '']);
        $this->dispatch('open-new-tab', url: $url);
    }
    // export excel
    public function exportToExcel()
    {
        // Start the query with the role filter
        $usersQuery = User::role('farmer');
    
        // Apply search filter if a search term is provided
        if (!empty($this->search)) {
            $usersQuery->where(function ($query) {
                $query->where('owner_name', 'like', "%{$this->search}%")
                    ->orWhere('location', 'like', "%{$this->search}%")
                    ->orWhere('farmer_number', '=', $this->search)
                    ->orWhere('gender', 'like', "%{$this->search}%")
                    ->orWhere('status', 'like', "%{$this->search}%");
            });
        }
    
        // Check if there are any results
        $users = $usersQuery->get();
    
        if ($users->isEmpty()) {
            // Dispatch error event to Livewire
            $this->dispatch('error', title: 'डाउनलोड गर्नको लागि कुनै किसान उपलब्ध छैन!');
            return;
        }
    
        // Export filtered users to Excel
        return Excel::download(new UsersExport($users), 'users.xlsx');
    }



    protected $rules = [
        'name' => 'required',
        'owner_name' => 'required',
        'password' => 'required|confirmed|min:6',
        'password_confirmation' => 'required',
        'farmer_number' => 'required|integer|min:1|unique:users,farmer_number',
        'location' => 'required',
        'gender' => 'required',
        'status' => 'nullable',
        'phone_number' => 'required',
        'pan_number' => 'nullable',
        'vat_number' => 'nullable',
    ];
    protected $messages = [
        'name.required' => 'कृषकको नाम अनिवार्य छ।',
        'owner_name.required' => 'हकवाला व्यक्तिको नाम अनिवार्य छ।',
        'password.required' => 'पासवर्ड अनिवार्य छ।',
        'password.confirmed' => 'पासवर्ड पुष्टि गर्नुहोस्।',
        'password.min' => 'पासवर्डमा कम्तीमा 6 अक्षर हुनु पर्छ।',
        'password_confirmation.required' => 'पासवर्ड पुष्टि गर्नुहोस् अनिवार्य छ।',
        'farmer_number.required' => 'कृषक नम्बर अनिवार्य छ।',
        'farmer_number.unique' => 'यो कृषक नम्बर पहिल्यै प्रयोग गरिएको छ।',
        'farmer_number.min' => 'ऋणात्मक नम्बर स्वीकृत छैन।',
        'location.required' => 'स्थान अनिवार्य छ।',
        'gender.required' => 'लिङ्ग अनिवार्य छ।',
        'status.required' => 'स्थिति अनिवार्य छ।',
        'phone_number.required' => 'फोन नम्बर अनिवार्य छ।',
    ];

    public function resetFields()
    {
        $this->reset([
            'name',
            'owner_name',
            'password',
            'farmer_number',
            'location',
            'gender',
            'status',
            'phone_number',
            'pan_number',
            'vat_number',
            'password_confirmation',
            'user_id',
        ]);
        $this->resetErrorBag();
    }

    // Method to convert English number to Nepali number
    public function convertToNepali($number)
    {
        $nepaliNumerals = [
            '0' => '०',
            '1' => '१',
            '2' => '२',
            '3' => '३',
            '4' => '४',
            '5' => '५',
            '6' => '६',
            '7' => '७',
            '8' => '८',
            '9' => '९',
        ];

        // Convert each digit to its Nepali equivalent
        return strtr($number, $nepaliNumerals);
    }

    public function register()
    {
        if ($this->user_id) {
            $this->update();
            return;
        }
        $this->validate();

        try {
            $user = User::create([
                'name' => $this->name,
                'owner_name' => $this->owner_name,
                'password' => Hash::make($this->password),
                'farmer_number' =>  $this->convertToNepali($this->farmer_number),
                'location' => $this->location,
                'gender' => $this->gender,
                // 'status' => $this->status,
                'phone_number' => $this->phone_number,
                'pan_number' => $this->convertToNepali($this->pan_number),
                'vat_number' => $this->convertToNepali($this->vat_number),
            ]);
            $user->assignRole('farmer');
            $this->resetFields();
            $this->dispatch('success', title: 'डाटा सुरक्षित भएको छ।');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            $this->dispatch('success', title: 'डाटा मेटाइएको छ।');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                $this->dispatch('error', title: 'प्रयोगकर्ता फेला परेन।');
                return;
            }
            $this->user_id = $id;
            $this->name = $user->name;
            $this->owner_name = $user->owner_name;
            $this->farmer_number = $user->farmer_number;
            $this->location = $user->location;
            $this->gender = $user->gender;
            $this->status = $user->status;
            $this->phone_number = $user->phone_number;
            $this->pan_number = $user->pan_number;
            $this->vat_number = $user->vat_number;
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'owner_name' => 'required',
            'password' => 'nullable|confirmed|min:6',
            'password_confirmation' => 'nullable',
            'farmer_number' => [
                'required',
                Rule::unique('users')->ignore($this->user_id),
            ],
            'location' => 'required',
            'gender' => 'required',
            'status' => 'nullable',
            'phone_number' => 'required',
            'pan_number' => 'nullable',
            'vat_number' => 'nullable',
        ]);
        $this->dispatch('warning');
        try {
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
    public function updateUser()
    {
        try {
            $user = User::find($this->user_id);
            $user->update([
                'name' => $this->name,
                'owner_name' => $this->owner_name,
                'password' => $this->password ? Hash::make($this->password) : $user->password,
                'farmer_number' =>  $this->convertToNepali($this->farmer_number),
                'location' => $this->location,
                'gender' => $this->gender,
                // 'status' => $this->status,
                'phone_number' => $this->phone_number,
                'pan_number' => $this->convertToNepali($this->pan_number),
                'vat_number' => $this->convertToNepali($this->vat_number),
            ]);
            $this->resetFields();
            $this->dispatch('success', title: 'डाटा सम्पादन भएको छ।');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // change status
    public function changeStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            if (!$user) {
                $this->dispatch('error', title: 'किसान फेला परेन!');
                return;
            }
            $user->status = $user->status === 'चालू' ? 'बन्द' : 'चालू';
            $user->save();
            $this->dispatch('success', title: 'अवस्था सफलतापूर्वक परिवर्तन गरियो!');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
}
