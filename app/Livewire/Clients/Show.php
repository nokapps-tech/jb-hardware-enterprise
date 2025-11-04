<?php

namespace App\Livewire\Clients;

use App\Livewire\Forms\ClientForm;
use App\Models\Client;
use Livewire\Component;

class Show extends Component
{
    public ClientForm $form;

    public function mount(Client $client)
    {
        $this->form->setClientModel($client);
    }

    public function render()
    {
        return view('livewire.client.show', ['client' => $this->form->clientModel]);
    }
}
