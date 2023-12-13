@props(['post'])

<div class="relative block w-full rounded bg-gray-200 dark:bg-gray-800 group hover:shadow-md hover:dark:shadow-gray-800 border border-transparent hover:border-gray-400 hover:dark:border-gray-600">
    <img class="rounded absolute inset-0 object-cover w-full h-full group-hover:opacity-20 group-hover:blur-[2px] duration-300" loading="lazy" src="{{ $post->image }}" />
    <div class="relative">
        <div class="mt-0 h-96 sm:h-80 transition-all transform opacity-0 group-hover:opacity-100 duration-500">
            <div class="h-full w-full flex flex-col justify-between">
                <div class="flex  w-full h-full text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    <a href="{{ route('posts.show', $post->slug) }}" class="w-full p-5">
                        <h5>{{ $post->title }}</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>