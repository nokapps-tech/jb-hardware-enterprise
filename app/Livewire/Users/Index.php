<?php

namespace App\Livewire\Users;

use App\Models\User;
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
        $users = User::when($this->search !== '', function (Builder $query) {
                $query->where('name','like', '%'.$this->search.'%');
            })
            ->notMe()
            ->notSystemUsers()
            ->orderBy('updated_at', 'desc')
            ->paginate();

        return view('livewire.user.index', [
            'users' => $users,
            'i' => $this->getPage() * $users->perPage(),
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();

        return $this->redirectRoute('users.index', navigate: true);
    }
}
