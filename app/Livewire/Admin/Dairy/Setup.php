<?php

namespace App\Livewire\Admin\Dairy;

use App\Models\Setup as ModelsSetup;
use Livewire\Component;

class Setup extends Component
{
    public $page = 'farmer';
    public $gov_fat,$gov_snf,$id;

    public function mount(){
        $setup=ModelsSetup::latest()->first();
        if($setup){
            $this->gov_fat=$setup->gov_fat;
            $this->gov_snf=$setup->gov_snf;
        }
    }
   
    public function render()
    {
        return view('livewire.admin.dairy.setup');
    }
    public function register(){
        $this->validate([
            'gov_fat' => 'required|min:1|numeric',
            'gov_snf' => 'required|min:1|numeric',
        ], [
            'gov_fat.required' => 'कृपया सरकार द्वारा दूधको फ्याट भर्नुहोस्।',
            'gov_fat.min' => 'दूधको फ्याट कम्तिमा १ हुनु पर्छ।',
            'gov_snf.required' => 'कृपया सरकार द्वारा दूधको एस.एन.एफ भर्नुहोस्।',
            'gov_snf.min' => 'दूधको एस.एन.एफ कम्तिमा १ हुनु पर्छ।',
        ]);
        try{
            ModelsSetup::query()->delete();
            ModelsSetup::create(
                [
                    'gov_fat' => $this->gov_fat,
                    'gov_snf' => $this->gov_snf,
                ]
            );
    
            // Dispatch a success message
            $this->dispatch('success', title:'डेटा सफलतापूर्वक सुरक्षित भयो।');
        }catch(\Throwable $th){
            $this->dispatch('error',$th->getMessage());
        }
    }
}
