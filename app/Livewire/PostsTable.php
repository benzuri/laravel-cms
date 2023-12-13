<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostsTable extends Component
{
    use WithPagination;

    public $active;
    public $q;
    public $category_post_id = 0;
    public $status_id = "";
    public $sortBy = 'id';
    public $sortAsc = true;
    public $message;

    public $confirmingItemAdd = false;
    public $confirmingItemDeletion = false;

    public $item = [];
    public $description;
    public $thecategories;
/*
    protected $rules = [
        'item.title' => 'required|string|min:4',
        'item.category_post_id' => 'required|integer|exists:category_posts,id',
    ];
*/
    protected function rules()
    {
        return [
            //'item.title' => 'required|string|min:4|unique:posts,title,' . ($this->item['id'] ?? ($this->item['title'] ?? '')),
            'item.category_post_id' => 'required|integer|exists:category_posts,id',
        ];
    }

    protected $queryString = [
        'active' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

    public function mount()
    {
        $this->thecategories = CategoryPost::all();
    }

    public function render()
    {
        $items = Post::when($this->q, function ($query) {
            return $query->where(function ($query) {
                $query->where('title', 'like', '%' . $this->q . '%')
                    ->orWhere('description', 'like', '%' . $this->q . '%');
            });
        })
            ->when($this->category_post_id, function ($query) {
                $query->where('category_post_id', $this->category_post_id);
            })
            ->when($this->status_id !== "", function ($query) {
                $query->where('published', $this->status_id);
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate(12);

        return view('livewire.posts-table', [
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
        $this->reset(['item', 'description']);
        $this->confirmingItemAdd = true;
    }

    public function confirmItemEdit(Post $item)
    {
        $this->resetErrorBag();
        $this->item = $item->toArray();
        $this->description = $item->description;
        $this->confirmingItemAdd = true;
    }

    public function saveItem()
    {
        if (!Auth::user()->is_admin)
            return abort(403);

        $this->validate();

        if (!isset($this->item['slug']) || $this->item['slug'] == '')
            $this->item['slug'] = Str::slug(($this->item['title']), '-');

        if (isset($this->item['id'])) {
            if (Post::where('id', '!=', $this->item['id'])->where('slug', $this->item['slug'])->first())
                $this->item['slug'] = Str::slug(($this->item['slug']), '-') . '-' . $this->item['id'];

            Post::updateOrCreate(['id' => $this->item['id']], $this->item);
            $this->dispatch('message', $this->message = 'Item Updated Successfully');
        } else {
            if (Post::where('slug', $this->item['slug'])->first()) {
                $nextId  = \DB::table('posts')->max('id') + 1;
                $this->item['slug'] = Str::slug(($this->item['slug']), '-') . '-' . $nextId;
            }

            Post::create($this->item);
            $this->dispatch('message', $this->message = 'Item Added Successfully');
        }

        $this->confirmingItemAdd = false;
    }

    public function confirmItemDeletion($id)
    {
        $this->confirmingItemDeletion = $id;
    }

    public function deleteItem(Post $item)
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
