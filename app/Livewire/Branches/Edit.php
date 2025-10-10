<?php

namespace App\Livewire\Branches;

use App\Livewire\Forms\BranchForm;
use App\Models\Branch;
use Livewire\Component;

class Edit extends Component
{
    public BranchForm $form;

    public function mount(Branch $branch)
    {
        $this->form->setBranchModel($branch);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('branches.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.branch.edit', [
            'branch' => $this->form->branchModel,
        ]);
    }
}
