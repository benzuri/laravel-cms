<x-guest-layout>
    @if ($posts->count() > 0)
    <div class="relative sm:flex sm:justify-center sm:items-center">
        <article role="main" class="w-full ">
            <section class="text-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 lg:gap-3">
                    @foreach ($posts as $post)
                    <x-post-card :post="$post" />
                    @endforeach
                </div>
            </section>
        </article>
    </div>
    <div class="py-2">
        {{ $posts->links() }}
    </div>
    @else
    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    There are no posts available
                </div>
            </div>
        </div>
    </div>
    @endif
</x-guest-layout>