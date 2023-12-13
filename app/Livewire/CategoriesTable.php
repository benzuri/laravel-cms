<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CategoryPost;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CategoriesTable extends Component
{
    use WithPagination;

    public $active;
    public $q;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $message;

    public $confirmingItemAdd = false;
    public $confirmingItemDeletion = false;

    public $confirmingDeleteRelated = false;
    public $deleteRelated = false;

    public $item = [];

    protected $rules = [
        'item.name' => 'required|string|min:4',
    ];

    protected $queryString = [
        'active' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

    public function render()
    {
        $items = CategoryPost::when($this->q, function ($query) {
            return $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->q . '%')
                    ->orWhere('slug', 'like', '%' . $this->q . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate(12);

        return view('livewire.categories-table', [
            'items' => $items,
        ])->layout('layouts.app');
    }

    public function updatingActive()
    {
        $this->resetPage();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function confirmItemAdd()
    {
        $this->reset(['item']);
        $this->confirmingItemAdd = true;
    }

    public function confirmItemEdit(CategoryPost $item)
    {
        $this->resetErrorBag();
        $this->item = $item->toArray();
        $this->confirmingItemAdd = true;
    }

    public function saveItem()
    {
        if (!Auth::user()->is_admin)
            return abort(403);

        $this->validate();

        if (!isset($this->item['slug']) || $this->item['slug'] == '')
            $this->item['slug'] = Str::slug(($this->item['name']), '-');

        if (isset($this->item['id'])) {
            if (CategoryPost::where('id', '!=', $this->item['id'])->where('slug', $this->item['slug'])->first())
                $this->item['slug'] = Str::slug(($this->item['slug']), '-') . '-' . $this->item['id'];

            CategoryPost::updateOrCreate(['id' => $this->item['id']], $this->item);
            $this->dispatch('message', $this->message = 'Item Updated Successfully');
        } else {
            CategoryPost::create($this->item);
            $this->dispatch('message', $this->message = 'Item Added Successfully');
        }

        $this->confirmingItemAdd = false;
    }

    public function confirmItemDeletion($id)
    {
        if (CategoryPost::find($id)->posts()->count() == 0) {
            $this->deleteRelated = true;
            $this->confirmingDeleteRelated = false;
        } else {
            $this->deleteRelated = false;
            $this->confirmingDeleteRelated = true;
        }

        $this->confirmingItemDeletion = $id;
    }

    public function deleteItem(CategoryPost $item)
    {
        if (!Auth::user()->is_admin)
            return abort(403);

        $item->delete();
        $this->confirmingItemDeletion = false;
        $this->dispatch('message', $this->message = 'Item Deleted Successfully');
    }

    public function deleteRelated()
    {
        $this->deleteRelated = true;
    }

    public function sortByField($field)
    {
        $this->sortAsc = ($field === $this->sortBy) ? !$this->sortAsc : $this->sortAsc;
        $this->sortBy = $field;
    }
}
