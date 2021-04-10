<div wire:init="loadPopularGames"
     class="popular-games text-sm md:grid md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12 border-b border-gray-800 pb-16">
    @forelse($popularGames as $game)
        <x-game-card :game="$game" rating-slug-prefix="popular" :event-based="true" />
    @empty
        @foreach(range(1, 12) as $game)
            <x-game-card-skeleton />
        @endforeach
    @endforelse
</div> <!-- End popular games -->

@push('scripts')
    @include('partials._rating', [
        'event' => 'popularGameWithRatingAdded'
    ])
@endpush
