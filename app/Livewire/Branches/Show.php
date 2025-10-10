<?php

namespace App\Livewire\Branches;

use App\Livewire\Forms\BranchForm;
use App\Models\Branch;
use Livewire\Component;

class Show extends Component
{
    public BranchForm $form;

    public function mount(Branch $branch)
    {
        $this->form->setBranchModel($branch);
    }

    public function render()
    {
        return view('livewire.branch.show', ['branch' => $this->form->branchModel]);
    }
}
