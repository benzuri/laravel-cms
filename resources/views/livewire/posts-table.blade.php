<div>
    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">

                    <div class="flex flex-row gap-3 mb-3">
                        <x-dashboard-crud-search title="posts" />

                        <select wire:model.live="category_post_id" class="text-sm rounded-lg shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="0">{{ __('All categories') }}</option>
                            @foreach ($thecategories as $category)
                            <option value="{{ $category['id'] }}">
                                {{ $category['name'] }}
                            </option>
                            @endforeach
                        </select>

                        <select wire:model.live="status_id" class="text-sm rounded-lg shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">{{ __('All status') }}</option>
                            <option value="1">
                                {{ __('Published') }}
                            </option>
                            <option value="0">
                                {{ __('Draft') }}
                            </option>
                        </select>

                        @if (Auth::user()->is_admin)
                        <button wire:click="confirmItemAdd" class="bg-sky-600 hover:bg-grey text-sky-100 font-bold py-1 px-3 rounded inline-flex items-center hover:bg-sky-400 hover:text-sky-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-sm">{{ __('NEW') }}</span>
                        </button>
                        @endif
                    </div>

                    <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-700 sm:rounded-lg">
                        @if ($items->count())
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="w-full px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <button wire:click="sortByField('title')" class="text-xs font-medium uppercase {{ $sortBy=='title' ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-300' }}">Title</button>
                                            <x-sort-icon sortField="title" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <button wire:click="sortByField('updated_at')" class="text-xs font-medium uppercase {{ $sortBy=='updated_at' ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-300' }}">Date</button>
                                            <x-sort-icon sortField="updated_at" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                                        </div>
                                    </th>
                                    @if (Auth::user()->is_admin)
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($items as $item)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            @if($item->published)
                                            <a href="{{ route('posts.show', ['slug' => $item->slug]) }}" target="_blank">{{ $item->title }}</a>
                                            @else
                                            <span class="line-through">{{ $item->title }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-sm text-gray-500">
                                            {{ $item->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-sm text-gray-500">
                                            {{ $item->published ? __('Published') : __('Draft') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->updated_at ?? $item->created_at)->translatedFormat('Y m j') }}
                                    </td>
                                    @if (Auth::user()->is_admin)
                                    <td class="px-4 py-2 flex flex-row justify-end gap-2">

                                        <x-button wire:click="confirmItemEdit({{ $item->id }})" class="ms-3">
                                            {{ __('Edit') }}
                                        </x-button>
                                        <x-danger-button wire:click="confirmItemDeletion({{ $item->id}})" wire:loading.attr="disabled">
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- paginate -->
                        <div class="bg-white dark:bg-gray-700 px-4 py-1 border-t border-gray-200 dark:border-gray-700">
                            @if ($items->hasPages())
                            {{ $items->links() }}
                            @else
                            <p class="text-sm text-gray-700 dark:text-gray-400 leading-5 py-2">Showing {{ $items->count() }} results</p>
                            @endif
                        </div>
                        @else
                        <!-- no result -->
                        <div class="bg-white dark:bg-gray-300 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-">
                            No results
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-action-message class="absolute bottom-0 right-0 mr-3" on="message">
        <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">{{ $message }}</span>
            </div>
        </div>
    </x-action-message>

    <x-confirmation-modal wire:model="confirmingItemDeletion">
        <x-slot name="title">
            {{ __('Delete Item') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this Item? ') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingItemDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deleteItem({{ $confirmingItemDeletion }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <x-dialog-modal wire:model="confirmingItemAdd">

        <x-slot name="title">
            {{ isset($this->item['id']) ? 'Edit Item' : 'Add Item'}}
        </x-slot>

        <x-slot name="content">
            <div class="">
                <x-label for="title" value="{{ __('Title') }}" />
                <x-input id="title" type="text" wire:model="item.title" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                <x-input-error for="item.title" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="slug" value="{{ __('Slug') }}" />
                <x-input id="slug" type="text" wire:model.defer="item.slug" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                <x-input-error for="item.slug" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="image" value="{{ __('Image') }}" />
                <x-input id="image" type="text" wire:model.defer="item.image" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                <x-input-error for="item.image" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="description" value="{{ __('Description') }}" />

                <div class="w-full h-[calc(100%_-_4rem)]" wire:ignore.self>
                    <div class="!border-0 mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" x-data x-ref="quillEditor" x-init="
                                    quill = new Quill($refs.quillEditor, {theme: 'snow'});
                                    quill.on('text-change', function () {
                                    $dispatch('input', quill.root.innerHTML);
                                    });
                                " wire:model.refer="item.description">
                        {!! $description !!}
                    </div>
                </div>

                <x-input-error for="item.description" class="mt-2" />
            </div>
            <div class="mt-4 flex md:flex-row gap-2">
                <div class="w-full">
                    <x-label for="category" value="{{ __('Category') }}" />
                    <select wire:model.defer="item.category_post_id" id="category" class="mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>{{ __('- Choose a category -') }}</option>
                        @foreach ($thecategories as $category)
                        <option value="{{ $category['id'] }}">
                            {{ $category['name'] }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error for="item.category_post_id" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-label for="published" value="{{ __('Status') }}" />
                    <select wire:model.defer="item.published" id="published" class="mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="1">
                            {{ __('Published') }}
                        </option>
                        <option value="0">
                            {{ __('Draft') }}
                        </option>
                    </select>
                    <x-input-error for="item.published" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingItemAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-2 bg-blue-500 hover:bg-blue-700" wire:click="saveItem()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    @push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    @endpush
</div>