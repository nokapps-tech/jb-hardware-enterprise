<?php

namespace App\Livewire\Audits;

use App\Models\Audit;
use Livewire\Component;

class Show extends Component
{
    public Audit $audit;

    public function mount(Audit $audit)
    {
        $this->audit = $audit;
    }

    public function render()
    {
        return view('livewire.audit.show', ['audit' => $this->audit]);
    }
}
