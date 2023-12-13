@props(['alert'])

<div class="fixed bottom-4 right-0 px-4">
    <div class="mb-4">
        <div class="flex max-w-sm w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mx-auto">
            <div class="w-2 bg-green-600">
            </div>
            <div class="w-full flex justify-between items-start px-2 py-2">
                <div class="flex flex-col ml-2">
                    <label class="text-gray-500">Dashboard</label>
                    <p class="text-gray-800 dark:text-gray-200">{{ $alert }}</p>
                </div>
                <button wire:click="closeAlert()" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>