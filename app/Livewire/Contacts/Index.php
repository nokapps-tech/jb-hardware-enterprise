<?php

namespace App\Livewire\Contacts;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function render(): View
    {
        $contacts = Contact::when($this->search !== '', function (Builder $query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('updated_at', 'desc')
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
