<?php

namespace App\Http\Controllers;

use App\Actions\Games\FetchSingleGame;
use App\Utils\ArrayUtil;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Exceptions\ModelNotFoundException;

class GameController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function show(string $slug)
    {
        try {
            $game = FetchSingleGame::run($slug);
        } catch (ModelNotFoundException $exception) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view('show', [
            'game' => $this->formatGameForView($game),
        ]);
    }

    private function formatGameForView(array $game): array
    {
        return collect($game)->merge([
            'coverUrl' => array_key_exists('cover', $game)
                ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])
                : '//via.placeholder.com/264x374',
            'genres' => array_key_exists('genres', $game)
                ? ArrayUtil::toSeparatedString($game['genres'], 'name', ', ')
                : null,
            'platforms' => array_key_exists('platforms', $game)
                ? ArrayUtil::toSeparatedString($game['platforms'], 'abbreviation', ', ')
                : null,
            'company' => isset($game['involved_companies'][0]['company']['name'])
                ? $game['involved_companies'][0]['company']['name']
                : null,
            'memberRating' => array_key_exists('rating', $game)
                ? round($game['rating'])
                : null,
            'criticRating' => array_key_exists('aggregated_rating', $game)
                ? round($game['aggregated_rating'])
                : null,
            'screenshots' => array_key_exists('screenshots', $game)
                ? collect($game['screenshots'])->map(function ($screenshot) {
                    return [
                        'big' => Str::replaceFirst('thumb', 'screenshot_big', $screenshot['url']),
                        'huge' => Str::replaceFirst('thumb', 'screenshot_huge', $screenshot['url']),
                    ];
                })->take(9)->toArray()
                : [],
            'trailer' => array_key_exists('videos', $game)
                ? 'https://youtube.com/embed/' . $game['videos'][0]['video_id']
                : null,
            'similarGames' => collect($game['similar_games'])->map(function ($game) {
                return collect($game)->merge([
                    'coverUrl' => array_key_exists('cover', $game)
                        ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])
                        : 'https://via.placeholder.com/264x374',
                    'rating' => array_key_exists('total_rating', $game)
                        ? round($game['total_rating'])
                        : null,
                    'platforms' => array_key_exists('platforms', $game)
                        ? ArrayUtil::toSeparatedString($game['platforms'], 'abbreviation', ', ')
                        : null,
                ]);
            })->take(6)->toArray(),
            'social' => $this->getSocial($game)
        ])->toArray();
    }

    private function getSocial(array $game): array {
        if (!array_key_exists('websites', $game)) {
            return ['website' => null, 'facebook' => null, 'twitter' => null, 'instagram' => null];
        }

        return [
            'website' => $game['websites'][0],
            'facebook' => collect($game['websites'])->filter(function ($website) {
                return Str::contains($website['url'], 'facebook');
            })->first(),
            'twitter' => collect($game['websites'])->filter(function ($website) {
                return Str::contains($website['url'], 'twitter');
            })->first(),
            'instagram' => collect($game['websites'])->filter(function ($website) {
                return Str::contains($website['url'], 'instagram');
            })->first(),
        ];
    }
}
