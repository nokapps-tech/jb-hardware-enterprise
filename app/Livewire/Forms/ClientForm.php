<?php

namespace App\Livewire\Forms;

use App\Models\Client;
use Livewire\Form;

class ClientForm extends Form
{
    public ?Client $clientModel;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $notes = '';
    
    public function rules(): array
    {
        return [
        ];
    }

    public function setClientModel(Client $clientModel): void
    {
        $this->clientModel = $clientModel;
        
    }

    public function store(): void
    {
        $this->clientModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->clientModel->update($this->validate());

        $this->reset();
    }
}
