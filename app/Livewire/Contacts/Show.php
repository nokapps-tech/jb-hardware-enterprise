<?php

namespace App\Livewire\Contacts;

use App\Livewire\Forms\ContactForm;
use App\Models\Contact;
use Livewire\Component;

class Show extends Component
{
    public ContactForm $form;

    public function mount(Contact $contact)
    {
        $this->form->setContactModel($contact);
    }

    public function render()
    {
        return view('livewire.contact.show', ['contact' => $this->form->contactModel]);
    }
}
