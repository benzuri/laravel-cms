<div>
    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="flex flex-row gap-3 mb-3">
                        <x-dashboard-crud-search title="categories" />
                        
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
                                            <button wire:click="sortByField('name')" class="text-xs font-medium uppercase {{ $sortBy=='name' ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-300' }}">Name</button>
                                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Slug
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
                                            <a href="{{ route('posts.category', ['slug' => $item->slug]) }}" target="_blank">{{ $item->name }}</a>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-sm text-gray-500">
                                            {{ $item->slug }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->updated_at ?? $item->created_at)->translatedFormat('Y m j') }}
                                    </td>
                                    @if (Auth::user()->is_admin)
                                    <td class="px-4 py-2 flex flex-row justify-end gap-2">

                                        <x-button wire:click="confirmItemEdit( {{ $item->id }})" class="ms-3">
                                            {{ __('Edit') }}
                                        </x-button>
                                        <x-danger-button wire:click="confirmItemDeletion({{ $item->id}})">
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
            @if($confirmingDeleteRelated)
            <label for="delete_all" class="flex items-center mt-3">
                <x-checkbox id="delete_all" name="detelete_all" wire:model.live="deleteRelated" />
                <span class="ms-2 text-base text-gray-600 dark:text-gray-400">{{ __('Remove all related to this item') }}</span>
            </label>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingItemDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deleteItem({{ $confirmingItemDeletion }})" :disabled=!$deleteRelated>
                {{ __('Delete') }}
            </x-danger-button>

        </x-slot>
    </x-confirmation-modal>

    <x-dialog-modal wire:model="confirmingItemAdd">

        <x-slot name="title">
            {{ isset( $this->item['id']) ? 'Edit Item' : 'Add Item'}}
        </x-slot>

        <x-slot name="content">
            <div class="">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" type="text" wire:model="item.name" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                <x-input-error for="item.name" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="slug" value="{{ __('Slug') }}" />
                <x-input id="slug" type="text" wire:model.defer="item.slug" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                <x-input-error for="item.slug" class="mt-2" />
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

</div>