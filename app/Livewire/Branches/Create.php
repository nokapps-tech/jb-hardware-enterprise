<?php

namespace App\Livewire\Branches;

use App\Livewire\Forms\BranchForm;
use App\Models\Branch;
use Livewire\Component;

class Create extends Component
{
    public BranchForm $form;

    public function mount(Branch $branch)
    {
        $this->form->setBranchModel($branch);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('branches.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.branch.create');
    }
}
