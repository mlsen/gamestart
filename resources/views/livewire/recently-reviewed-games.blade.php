<div wire:init="loadRecentlyReviewedGames" class="recently-reviewed-container space-y-12 mt-8">
        @forelse($recentlyReviewedGames as $game)
            <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
                <div class="relative flex-none">
                    <a href="{{ route('games.show', ['slug' => $game->slug()]) }}">
                        <img src="{{ $game->coverUrl('big') }}"
                                     alt="game cover" class="w-48 hover:opacity-75 transition ease-in-out duration-150" width="264" height="274">
                    </a>
                    @if ($game->totalRating())
                        <div id="reviewed_{{ $game->slug() }}" class="absolute bottom-0 right-0 w-16 h-16 bg-gray-900 rounded-full"
                             style="right: -20px; bottom: -20px">
                        </div>
                    @endif
                </div>

                <div class="ml-12">
                    <a href="{{ route('games.show', ['slug' => $game->slug()]) }}"
                       class="block text-lg font-semibold leading-tight hover:text-gray-400 mt-4">{{ $game->name() }}</a>

                    @if ($game->hasPlatforms())
                        <div class="text gray-400 mt-1">
                            {{ $game->platforms() }}
                        </div>
                    @endif
                    <p class="mt-6 text-gray-400 hidden lg:block">
                        {{ $game->summary() }}
                    </p>
                </div>
            </div>
        @empty
            @foreach(range(1, 3) as $game)
                <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
                    <div class="relative flex-none">
                        <div class="bg-gray-700 w-32 lg:w-48 h-40 lg:h-60"></div>
                    </div>

                    <div class="ml-12">
                        <div class="text-transparent bg-gray-700 text-lg font-semibold leading-tight mt-4 rounded">Title goes here</div>
                        <div class="text-transparent bg-gray-700 mt-2 rounded">PS4, PC, Switch</div>
                        <p class="mt-6 text-transparent hidden lg:block bg-gray-700 rounded">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium adipisci animi asperiores at
                            consequuntur cum delectus ducimus et excepturi facere facilis fugiat labore magni molestias natus
                            obcaecati officiis, omnis quas quasi quia quidem quos tempora, tenetur ullam voluptates, voluptatibus.
                        </p>
                    </div>
                </div>
            @endforeach
        @endforelse
</div>

@push('scripts')
    @include('partials._rating', [
        'event' => 'recentlyReviewedGameWithRatingAdded'
    ])
@endpush
