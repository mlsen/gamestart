<?php


namespace App\ViewModels;


use App\Utils\ArrayUtil;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\ViewModels\ViewModel;

class GameViewModel
{
    private array $game;

    private array $coverSizes = [
        'small' => '90x128',
        'big' => '264x374',
    ];

    /**
     * GameViewModel constructor.
     * @param array $game
     */
    public function __construct(array $game)
    {
        $this->game = $game;
    }

    public function name(): string {
        return $this->game['name'];
    }

    public function slug(): string {
        return $this->game['slug'];
    }

    public function summary(): ?string {
        return array_key_exists('summary', $this->game)
            ? $this->game['summary']
            : null;
    }

    public function coverUrl(string $size): string
    {
        if (array_key_exists('cover', $this->game)) {
            return Str::replaceFirst('thumb', 'cover_' . $size, $this->game['cover']['url']);
        }

        $size = array_key_exists($size, $this->coverSizes)
            ? $this->coverSizes[$size]
            : $this->coverSizes['big'];

        return '//via.placeholder.com/' . $size;
    }

    public function genres(): ?string
    {
        if (!array_key_exists('genres', $this->game)) {
            return null;
        }
        return ArrayUtil::toSeparatedString($this->game['genres'], 'name', ', ');
    }

    public function platforms(): ?string
    {
        if (!isset($this->game['platforms'])) {
            return null;
        }

        return ArrayUtil::toSeparatedString($this->game['platforms'], 'abbreviation', ', ');
    }

    public function company(): ?string
    {
        if (isset($this->game['involved_companies'][0]['company']['name'])) {
            return $this->game['involved_companies'][0]['company']['name'];
        }
        return null;
    }

    public function totalRating(): ?int {
        if (array_key_exists('total_rating', $this->game)) {
            return round($this->game['total_rating']);
        }
        return null;
    }

    public function memberRating(): ?int
    {
        if (array_key_exists('rating', $this->game)) {
            return round($this->game['rating']);
        }
        return null;
    }

    public function criticRating(): ?int
    {
        if (array_key_exists('aggregated_rating', $this->game)) {
            return round($this->game['aggregated_rating']);
        }
        return null;
    }

    public function releaseDate(): ?string {
        if (array_key_exists('first_release_date', $this->game)) {
            return Carbon::parse($this->game['first_release_date'])->format('M d, Y');
        }
        return null;
    }

    public function screenshots(int $amount): ?array
    {
        if (!array_key_exists('screenshots', $this->game)) {
            return null;
        }

        return collect($this->game['screenshots'])->map(function ($screenshot) {
            return [
                'big' => Str::replaceFirst('thumb', 'screenshot_big', $screenshot['url']),
                'huge' => Str::replaceFirst('thumb', 'screenshot_huge', $screenshot['url']),
            ];
        })->take($amount)->toArray();
    }

    public function trailer(): ?string {
        if (!array_key_exists('videos', $this->game)) {
            return null;
        }

        return 'https://youtube.com/embed/' . $this->game['videos'][0]['video_id'];
    }

    public function similarGames(): ?\Illuminate\Support\Collection
    {
        if (!array_key_exists('similar_games', $this->game)) {
            return null;
        }

        return collect($this->game['similar_games'])->map(function ($game) {
            return new GameViewModel($game);
        });
    }

    public function social(): array {
        if (!array_key_exists('websites', $this->game)) {
            return ['website' => null, 'facebook' => null, 'twitter' => null, 'instagram' => null];
        }

        return [
            'website' => $this->game['websites'][0],
            'facebook' => collect($this->game['websites'])->filter(function ($website) {
                return Str::contains($website['url'], 'facebook');
            })->first(),
            'twitter' => collect($this->game['websites'])->filter(function ($website) {
                return Str::contains($website['url'], 'twitter');
            })->first(),
            'instagram' => collect($this->game['websites'])->filter(function ($website) {
                return Str::contains($website['url'], 'instagram');
            })->first(),
        ];
    }
}
