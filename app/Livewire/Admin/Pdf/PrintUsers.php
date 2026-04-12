<?php

namespace App\Livewire\Admin\Pdf;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Livewire\Component;

class PrintUsers extends Component
{

    public  $search;

    private $userRepository;

    public function boot(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function mount($search = '')
    {
        $this->search = $search;
    }

    public function render()
    {
        $users = $this->userRepository->all('all', $this->search,'asc');
        return view('livewire.admin.pdf.print-users',[
            'users'=>$users
        ]);
    }
}
