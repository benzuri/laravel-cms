<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SettingsTable extends Component
{
    use WithPagination;

    public $active;
    public $q;
    public $category_post_id = 0;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $message;

    public $confirmingItemAdd = false;
    public $confirmingItemDeletion = false;

    public $item = [];
    public $description;

    protected function rules()
    {
        //dd($this->item);
        return [
            //'item.key' => ['required', 'string', 'unique:settings,key,' . ($this->item['id'] ?? ($this->item['key'] ?? '') ],
            'item.key' => 'required|string|unique:settings,key,' . ($this->item['id'] ?? ($this->item['key'] ?? '')),
        ];
    }

    protected $queryString = [
        'active' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

    public function render()
    {
        $items = Setting::when($this->q, function ($query) {
            return $query->where(function ($query) {
                $query->where('key', 'like', '%' . $this->q . '%')
                    ->orWhere('value', 'like', '%' . $this->q . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate(12);

        return view('livewire.settings-table', [
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

    public function confirmItemEdit(Setting $item)
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

        $this->item['user_id'] = Auth::user()->id;

        $save = Setting::updateOrCreate(['id' => $this->item['id'] ?? null], $this->item);

        if (!$save->wasChanged() && !$save->wasRecentlyCreated)
            $this->dispatch('message', $this->message = 'Item Not Changed');
        elseif ($save->wasRecentlyCreated)
            $this->dispatch('message', $this->message = 'Item Added Successfully');
        else
            $this->dispatch('message', $this->message = 'Item Updated Successfully');

        $this->confirmingItemAdd = false;
    }

    public function confirmItemDeletion($id)
    {
        $this->confirmingItemDeletion = $id;
    }

    public function deleteItem(Setting $item)
    {
        $item->delete();
        $this->confirmingItemDeletion = false;
        $this->dispatch('message', $this->message = 'Item Deleted Successfully');
    }

    public function sortByField($field)
    {
        $this->sortAsc = ($field === $this->sortBy) ? !$this->sortAsc : $this->sortAsc;
        $this->sortBy = $field;
    }
}
