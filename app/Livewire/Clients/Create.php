<?php

namespace App\Livewire\Clients;

use App\Livewire\Forms\ClientForm;
use App\Models\Client;
use Livewire\Component;

class Create extends Component
{
    public ClientForm $form;

    public function mount(Client $client)
    {
        $this->form->setClientModel($client);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('clients.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.client.create');
    }
}
