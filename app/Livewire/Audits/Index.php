<?php

namespace App\Livewire\Audits;

use App\Models\Audit;
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
        $searchTerms = collect(explode(' ', $this->search))
            ->filter()
            ->map(fn ($term) => trim($term));

        $audits = Audit::with('user')->when($this->search !== '', function (Builder $query) use ($searchTerms) {
                $query->where(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where(function ($q) use ($term) {
                            $q->where('event', 'like', "%$term%")
                            ->orWhere('auditable_type', 'like', "%$term%")
                            ->orWhere('auditable_id', 'like', "%$term%")
                            ->orWhereHas('user', fn ($q) =>
                                $q->where('name', 'like', "%$term%")
                            );
                        });
                    }
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.audit.index', [
            'audits' => $audits,
            'i' => $this->getPage() * $audits->perPage(),
        ]);
    }

    public function delete(Audit $audit)
    {
        $audit->delete();

        return $this->redirectRoute('audits.index', navigate: true);
    }
}
