<?php

namespace App\Livewire\Contacts;

use App\Models\Contact;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function render(): View
    {
        # TODO: Add columns to search on with $search here
        $contacts = Contact::orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.contact.index', [
            'contacts' => $contacts,
            'i' => $this->getPage() * $contacts->perPage(),
        ]);
    }

    public function delete(Contact $contact)
    {
        $contact->delete();

        return $this->redirectRoute('contacts.index', navigate: true);
    }
}
