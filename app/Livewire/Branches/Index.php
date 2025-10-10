<?php

namespace App\Livewire\Branches;

use App\Models\Branch;
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
        # TODO: Add columns to search on with $search here
        $branches = Branch::when($this->search !== '', function (Builder $query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('address', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate();
        return view('livewire.branch.index', [
            'branches' => $branches,
            'i' => $this->getPage() * $branches->perPage(),
        ]);
    }

    public function delete(Branch $branch)
    {
        $branch->delete();

        return $this->redirectRoute('branches.index', navigate: true);
    }
}
