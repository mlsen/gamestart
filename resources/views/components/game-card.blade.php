<div class="game mt-8">
    <div class="relative inline-block">
        <a href="{{ route('games.show', ['slug' => $game['slug']]) }}">
            <img src="{{ $game['coverUrl'] }}"
                 alt="game cover" class="hover:opacity-75 transition ease-in-out duration-150 object-fill" width="264" height="374" />
        </a>
        @if ($game['rating'])
            <div id="{{ $ratingSlugPrefix }}_{{ $game['slug'] }}" class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full"
                 style="right: -20px; bottom: -20px">
            </div>

            @if(!$eventBased)
                @push('scripts')
                    @include('partials._rating', [
                        'slug' => $ratingSlugPrefix . '_' . $game['slug'],
                        'rating' => $game['rating'],
                        'event' => null,
                    ])
                @endpush
            @endif
        @endif
    </div>
    <a href="#"
       class="block text-base font-semibold leading-tight hover:text-gray-400 mt-4">{{ $game['name'] }}</a>
    @if ($game['platforms'])
        <div class="text-gray-400 mt-1">
            {{ $game['platforms'] }}
        </div>
    @endif
</div>
