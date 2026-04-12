<?php

namespace App\Livewire\Admin\Administrator;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Helpers\NumberHelper;
use App\Models\Administrator as ModelsAdministrator;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;

class Administrator extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    private $employeeRepository;
    public $page = 'members';
    public $entries = 10;
    public $search = '';
    public $name, $profile_image, $position, $phone_no, $location, $status = 'चालू', $gender = 'पुरुष', $rank;
    public $administrator_id;

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
        $administrators = $this->employeeRepository->allAdministrators($this->entries, $this->search);
        return view('livewire.admin.administrator.administrator', [
            'administrators' => $administrators
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
        'rank' => 'required|integer|unique:administrators,rank',
    ];

    // Custom validation messages in Nepali
    protected $messages = [
        'name.required' => 'सञ्चालकको नाम आवश्यक छ।',
        'profile_image.required' => 'सञ्चालकको प्रोफाइल आवश्यक छ।',
        'profile_image.mimes' => 'केवल jpeg, png, jpg, र webp प्रकारका फोटो मात्र स्वीकार्य छन्।',
        'position.required' => 'सञ्चालकको पद आवश्यक छ।',
        'phone_no.required' => 'सञ्चालकको फोन नम्बर आवश्यक छ।',
        'location.required' => 'सञ्चालकको ठेगाना आवश्यक छ।',
        'status.required' => 'सञ्चालकको स्थिति आवश्यक छ।',
        'status.in' => 'सञ्चालकको स्थिति "चालू" वा "बन्द" हुनुपर्छ।',
        'gender.required' => 'सञ्चालकको लिङ्ग आवश्यक छ।',
        'gender.in' => 'सञ्चालकको लिङ्ग "पुरुष", "महिला", वा "अन्य" हुनुपर्छ।',
        'rank.required' => 'सञ्चालकको रैंक आवश्यक छ।',
        'rank.unique' => 'सञ्चालकको रैंक पहिले नै प्रयोग गरिएको छ।',
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
             'administrator_id'
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


            // Create the administrator record in the database
            ModelsAdministrator::create([
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
            $this->dispatch('success', title: 'सञ्चालक सफलतापूर्वक थपियो');
            $this->resetFields();
        } catch (\Throwable $th) {
            // Dispatch error message
            $this->dispatch('error', title: $th->getMessage());
        }
    }

     // Delete data from DB
     public function delete($administratorId)
     {
         try {
             // Retrieve the administrator from the database
             $administrator = ModelsAdministrator::find($administratorId);
             if (!$administrator) {
                 $this->dispatch('error', title: 'सञ्चालक भेटिएन!');
                 return;
             }
 
             if ($administrator) {
                 // Get the image path from the administrator
                 $imagePath = $administrator->profile_image;
 
                 // Check if the image exists and delete it
                 if (file_exists(storage_path('app/public/' . $imagePath))) {
                     unlink(storage_path('app/public/' . $imagePath));
                 }
 
                 // Delete the administrator record from the database
                 $administrator->delete();
                 $this->dispatch('success', title: 'डाटा मेटाइएको छ।');
             }
         } catch (\Throwable $th) {
             // If there's any error, dispatch an error message
             $this->dispatch('error', title: $th->getMessage());
         }
     }

      // change status
    public function changeStatus($administratorId)
    {
        try {
            // Retrieve the administrator from the database
            $administrator = ModelsAdministrator::find($administratorId);
            if (!$administrator) {
                $this->dispatch('error', title: 'सञ्चालक भेटिएन!');
                return;
            }
            $administrator->status = $administrator->status === 'चालू' ? 'बन्द' : 'चालू';
            $administrator->save();
            $this->dispatch('success', title: 'अवस्था सफलतापूर्वक परिवर्तन गरियो!');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

     // change status
     public function edit($administratorId)
     {
         try {
             $administrator = ModelsAdministrator::find($administratorId);
             if (!$administrator) {
                 $this->dispatch('error', title: 'सञ्चालक भेटिएन!');
                 return;
             }
             $this->rank = NumberHelper::toNepaliNumber($administrator->rank);
             $this->administrator_id = $administratorId;
             $this->name = $administrator->name;
             $this->position = $administrator->position;
             $this->phone_no = $administrator->phone_no;
             $this->location = $administrator->location;
             $this->status = $administrator->status;
             $this->gender = $administrator->gender;
             $this->dispatch('editModal');
         } catch (\Throwable $th) {
             // If there's any error, dispatch an error message
             $this->dispatch('error', title: $th->getMessage());
         }
     }

     public function update()
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
                 Rule::unique('administrators')->ignore($this->administrator_id),
             ],
         ], [
             'name.required' => 'सञ्चालकको नाम आवश्यक छ।',
             'profile_image.mimes' => 'केवल jpeg, png, jpg, र webp प्रकारका फोटो मात्र स्वीकार्य छन्।',
             'position.required' => 'सञ्चालकको पद आवश्यक छ।',
             'phone_no.required' => 'सञ्चालकको फोन नम्बर आवश्यक छ।',
             'location.required' => 'सञ्चालकको ठेगाना आवश्यक छ।',
             'status.required' => 'सञ्चालकको स्थिति आवश्यक छ।',
             'status.in' => 'सञ्चालकको स्थिति "चालू" वा "बन्द" हुनुपर्छ।',
             'gender.required' => 'सञ्चालकको लिङ्ग आवश्यक छ।',
             'gender.in' => 'सञ्चालकको लिङ्ग "पुरुष", "महिला", वा "अन्य" हुनुपर्छ।',
             'rank.required' => 'सञ्चालकको रैंक आवश्यक छ।',
             'rank.unique' => 'सञ्चालकको रैंक पहिले नै प्रयोग गरिएको छ।',
         ]);
 
         try {
             // Retrieve the administrator from the database
             $administrator = ModelsAdministrator::find($this->administrator_id);
             if (!$administrator) {
                 $this->dispatch('error', title: 'सञ्चालक भेटिएन!');
                 return;
             }
 
             // Handle Image Upload & Conversion
             if ($this->profile_image) {
                 // Delete the old image
                 if ($administrator->profile_image && Storage::disk('public')->exists($administrator->profile_image)) {
                     Storage::disk('public')->delete($administrator->profile_image);
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
                 $imagePath = $administrator->profile_image;
             }
 
             // Update the administrator data in the database
             $administrator->update([
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
             $this->dispatch('success', title: 'सञ्चालक सफलतापूर्वक अपडेट गरियो');
             $this->resetFields();
         } catch (\Throwable $th) {
             // Dispatch error if any exception occurs
             $this->dispatch('error', title: $th->getMessage());
         }
     }

}
