<x-guest-layout>
    <div class="flex flex-col sm:flex-row rounded-lg shadow bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full sm:max-w-sm">
            <img class="rounded-t-lg sm:rounded-l-lg sm:rounded-tr-none w-full" src="{{ $post->image }}" alt="" />
        </div>
        <div class="p-5">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $post->title }}</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{!! $post->description !!}</p>
        </div>
    </div>
</x-guest-layout>