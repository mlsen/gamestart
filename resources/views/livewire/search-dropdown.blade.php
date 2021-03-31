<div class="relative" x-data="{ isVisible: true }" @click.away="isVisible = false">
    <input
        wire:model.debounce.300ms="query"
        type="text"
        class="bg-gray-800 text-sm rounded-full px-3 py-2 pl-8 w-64 focus:outline-none focus:ring"
        placeholder="Search... (Press '/' to focus)"
        x-ref="search"
        @keydown.window="
            if (event.keyCode === 191) {
                event.preventDefault();
                $refs.search.focus();
            }
        "
        @focus="isVisible = true"
        @keydown.escape.window="isVisible  = false"
        @keydown="isVisible = true"
        @keydown.shift.tab="isVisible = false"
    >

    <div class="absolute top-0 flex items-center h-full ml-2">
        <svg class="fill-current text-gray-400 w-4" viewBox="0 0 24 24">
            <path class="heroicon-ui"
                  d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z"/>
        </svg>
    </div>

    <x-loading-spinner wire:loading class="h-6 w-6 absolute top-0 right-0 mr-2 mt-2" style="padding-bottom: 5px;"/>

    @if(strlen($query) >= 2)
        <div class="absolute z-50 bg-gray-800 text-xs rounded-lg w-64 mt-2" x-show.transition.opacity.duration.200="isVisible">
            <ul>
                @forelse($searchResults as $result)
                    <li class="border-b border-gray-700">
                        <a href="{{ route('games.show', ['slug' => $result['slug']]) }}"
                           class="block hover:bg-gray-700 flex items-center transition ease-in-out duration-1 px-3 py-3"
                           @if($loop->last) @keydown.tab="isVisible = false" @endif
                        >

                            @if(isset($result['cover']))
                                <img src="{{ $result['cover']['url'] }}" alt="cover" class="w-10">
                            @else
                                <img src="//via.placeholder.com/90" alt="cover" class="w-10">
                            @endif

                            <span class="ml-4">{{ $result['name'] }}</span>
                        </a>
                    </li>
                @empty
                    <li class="px-3 py-3">No results for "{{ $query }}"</li>
                @endforelse
            </ul>
        </div>
    @endif
</div>
