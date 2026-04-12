<?php

namespace App\Livewire\Admin\Employee;

use App\Helpers\NumberHelper;
use App\Models\Employee as ModelsEmployee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Employee extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    private $employeeRepository;
    public $page = 'members';
    public $entries = 10;
    public $search = '';
    public $name, $profile_image, $position, $phone_no, $location, $status = 'चालू', $gender = 'पुरुष', $rank;
    public $employee_id;

    public function boot(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }
    public function updatedEntries()
    {
        $this->resetPage('page');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $employees = $this->employeeRepository->all($this->entries, $this->search);
        return view('livewire.admin.employee.employee', [
            'employees' => $employees
        ]);
    }

    // Validation rules in Nepali
    protected $rules = [
        'name' => 'required|string|max:255',
        'profile_image' => 'required||mimes:png,jpg,jpeg,webp',
        'position' => 'required|string|max:255',
        'phone_no' => 'required|string|max:15',
        'location' => 'required|string|max:255',
        'status' => 'required|in:चालू,बन्द',
        'gender' => 'required|in:पुरुष,महिला,अन्य',
        'rank' => 'required|integer|unique:employees,rank',
    ];

    // Custom validation messages in Nepali
    protected $messages = [
        'name.required' => 'कर्मचारीको नाम आवश्यक छ।',
        'profile_image.required' => 'कर्मचारीको प्रोफाइल आवश्यक छ।',
        'profile_image.mimes' => 'केवल jpeg, png, jpg, र webp प्रकारका फोटो मात्र स्वीकार्य छन्।',
        'position.required' => 'कर्मचारीको पद आवश्यक छ।',
        'phone_no.required' => 'कर्मचारीको फोन नम्बर आवश्यक छ।',
        'location.required' => 'कर्मचारीको ठेगाना आवश्यक छ।',
        'status.required' => 'कर्मचारीको स्थिति आवश्यक छ।',
        'status.in' => 'कर्मचारीको स्थिति "चालू" वा "बन्द" हुनुपर्छ।',
        'gender.required' => 'कर्मचारीको लिङ्ग आवश्यक छ।',
        'gender.in' => 'कर्मचारीको लिङ्ग "पुरुष", "महिला", वा "अन्य" हुनुपर्छ।',
        'rank.required' => 'कर्मचारीको रैंक आवश्यक छ।',
        'rank.unique' => 'कर्मचारीको रैंक पहिले नै प्रयोग गरिएको छ।',
    ];

    // ========reset fields=========
    public function resetFields()
    {
        $this->reset([
            'name',
            'profile_image',
            'position',
            'phone_no',
            'location',
            'rank',
            'gender',
            'status',
            'employee_id'
        ]);
        $this->resetErrorBag();
    }

    // Store data in DB after validation
    public function store()
    {
        $this->rank = NumberHelper::toEnglishNumber($this->rank);
        $this->validate(); // Perform validation

        try {
            // Get the original file
            $originalFile = $this->profile_image->getRealPath();

            // Generate a unique filename
            $fileName = 'team_profile_' . time() . '.webp';

            // Load the image, resize while maintaining aspect ratio, and convert to webp
            $compressedImage = Image::make($originalFile)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 80); // Compress with 80% quality

            // Store the compressed webp image in public storage
            Storage::disk('public')->put('team_profile/' . $fileName, $compressedImage);


            // Create the employee record in the database
            ModelsEmployee::create([
                'name' => $this->name,
                'profile_image' => 'team_profile/' . $fileName, // Save the image path
                'position' => $this->position,
                'phone_no' => $this->phone_no,
                'location' => $this->location,
                'status' => $this->status,
                'gender' => $this->gender,
                'rank' => $this->rank,
            ]);

            // Dispatch success message
            $this->dispatch('success', title: 'कर्मचारी सफलतापूर्वक थपियो');
            $this->resetFields();
        } catch (\Throwable $th) {
            // Dispatch error message
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // Delete data from DB
    public function delete($employeeId)
    {
        try {
            // Retrieve the employee from the database
            $employee = ModelsEmployee::find($employeeId);
            if (!$employee) {
                $this->dispatch('error', title: 'कर्मचारी भेटिएन!');
                return;
            }

            if ($employee) {
                // Get the image path from the employee
                $imagePath = $employee->profile_image;

                // Check if the image exists and delete it
                if (file_exists(storage_path('app/public/' . $imagePath))) {
                    unlink(storage_path('app/public/' . $imagePath));
                }

                // Delete the employee record from the database
                $employee->delete();
                $this->dispatch('success', title: 'डाटा मेटाइएको छ।');
            }
        } catch (\Throwable $th) {
            // If there's any error, dispatch an error message
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // change status
    public function changeStatus($employeeId)
    {
        try {
            // Retrieve the employee from the database
            $employee = ModelsEmployee::find($employeeId);
            if (!$employee) {
                $this->dispatch('error', title: 'कर्मचारी भेटिएन!');
                return;
            }
            $employee->status = $employee->status === 'चालू' ? 'बन्द' : 'चालू';
            $employee->save();
            $this->dispatch('success', title: 'अवस्था सफलतापूर्वक परिवर्तन गरियो!');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // change status
    public function edit($employeeId)
    {
        try {
            $employee = ModelsEmployee::find($employeeId);
            if (!$employee) {
                $this->dispatch('error', title: 'कर्मचारी भेटिएन!');
                return;
            }
            $this->rank = NumberHelper::toNepaliNumber($employee->rank);
            $this->employee_id = $employeeId;
            $this->name = $employee->name;
            $this->position = $employee->position;
            $this->phone_no = $employee->phone_no;
            $this->location = $employee->location;
            $this->status = $employee->status;
            $this->gender = $employee->gender;
            $this->dispatch('editModal');
        } catch (\Throwable $th) {
            // If there's any error, dispatch an error message
            $this->dispatch('error', title: $th->getMessage());
        }
    }
    public function updateEmployee()
    {
        $this->rank = NumberHelper::toEnglishNumber($this->rank);
         // Validate the incoming request data
         $this->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|mimes:png,jpg,jpeg,webp',
            'position' => 'required|string|max:255',
            'phone_no' => 'required|string|max:15',
            'location' => 'required|string|max:255',
            'status' => 'required|in:चालू,बन्द',
            'gender' => 'required|in:पुरुष,महिला,अन्य',
            'rank' => [
                'required',
                Rule::unique('employees')->ignore($this->employee_id),
            ],
        ], [
            'name.required' => 'कर्मचारीको नाम आवश्यक छ।',
            'profile_image.mimes' => 'केवल jpeg, png, jpg, र webp प्रकारका फोटो मात्र स्वीकार्य छन्।',
            'position.required' => 'कर्मचारीको पद आवश्यक छ।',
            'phone_no.required' => 'कर्मचारीको फोन नम्बर आवश्यक छ।',
            'location.required' => 'कर्मचारीको ठेगाना आवश्यक छ।',
            'status.required' => 'कर्मचारीको स्थिति आवश्यक छ।',
            'status.in' => 'कर्मचारीको स्थिति "चालू" वा "बन्द" हुनुपर्छ।',
            'gender.required' => 'कर्मचारीको लिङ्ग आवश्यक छ।',
            'gender.in' => 'कर्मचारीको लिङ्ग "पुरुष", "महिला", वा "अन्य" हुनुपर्छ।',
            'rank.required' => 'कर्मचारीको रैंक आवश्यक छ।',
            'rank.unique' => 'कर्मचारीको रैंक पहिले नै प्रयोग गरिएको छ।',
        ]);

        try {
            // Retrieve the employee from the database
            $employee = ModelsEmployee::find($this->employee_id);
            if (!$employee) {
                $this->dispatch('error', title: 'कर्मचारी भेटिएन!');
                return;
            }

            // Handle Image Upload & Conversion
            if ($this->profile_image) {
                // Delete the old image
                if ($employee->profile_image && Storage::disk('public')->exists($employee->profile_image)) {
                    Storage::disk('public')->delete($employee->profile_image);
                }

                // Generate a unique filename for the webp image
                $imageName = 'team_profile/' . uniqid() . '.webp';

                // Convert & compress the image to webp format
                $image = Image::make($this->profile_image->getRealPath())
                    ->encode('webp', 80) // Compress & convert to webp (80% quality)
                    ->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio(); // Maintain aspect ratio
                        $constraint->upsize(); // Prevent enlargement
                    });

                // Store the converted image in the public disk
                Storage::disk('public')->put($imageName, (string) $image);

                // Store the new image path
                $imagePath = $imageName;
            } else {
                // Retain the old image if no new image is uploaded
                $imagePath = $employee->profile_image;
            }

            // Update the employee data in the database
            $employee->update([
                'name' => $this->name,
                'profile_image' => $imagePath, // Save the image path
                'position' => $this->position,
                'phone_no' => $this->phone_no,
                'location' => $this->location,
                'status' => $this->status,
                'gender' => $this->gender,
                'rank' =>$this->rank,
            ]);

            // Dispatch success event or message
            $this->dispatch('success', title: 'कर्मचारी सफलतापूर्वक अपडेट गरियो');
            $this->resetFields();
        } catch (\Throwable $th) {
            // Dispatch error if any exception occurs
            $this->dispatch('error', title: $th->getMessage());
        }
    }
}
