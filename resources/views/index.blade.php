@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Popular Games</h2>
        <livewire:popular-games />

        <div class="flex flex-col lg:flex-row my-10">
            <div class="recently-reviewed lg:w-3/4 mr-0 lg:mr-32">
                <h2 class="h2 text-blue-500 uppercase tracking-wide font-semibold">Recently Reviewed</h2>
                <livewire:recently-reviewed-games />
            </div>

            <div class="lg:w-1/4">
                <div class="most-anticipated-container">
                    <h2 class="h2 text-blue-500 uppercase tracking-wide font-semibold">Most Anticipated</h2>
                    <livewire:most-anticipated-games />
                </div>

                <div class="coming-soon-container mt-8">
                    <h2 class="h2 text-blue-500 uppercase tracking-wide font-semibold">Coming Soon</h2>
                    <livewire:coming-soon-games />
                </div>
            </div>
        </div>
    </div>

@endsection
