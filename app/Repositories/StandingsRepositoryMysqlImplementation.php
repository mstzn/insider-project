<?php

namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Interfaces\StandingsRepositoryInterface;
use App\Models\Fixture;
use App\Models\Standing;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class StandingsRepositoryMysqlImplementation implements StandingsRepositoryInterface
{
    protected GameRepositoryInterface $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function get(Fixture $fixture): Collection
    {
        return Standing::where('fixture_id', $fixture->id)->orderBy('points', 'desc')->orderBy('goal_difference', 'desc')->orderBy('team_id', 'desc')->get();
    }

    public function getTeam(Fixture $fixture, Team $team)
    {
        return Standing::where('fixture_id', $fixture->id)
            ->where('team_id', $team->id)
            ->orderBy('points', 'desc')
            ->first();
    }

    public function add(Fixture $fixture, array $teams)
    {
        foreach ($teams as $team) {
            $standing = new Standing();
            $standing->team_id = $team['id'];
            $standing->fixture_id = $fixture->id;
            $standing->save();
        }
    }

    public function update(Fixture $fixture): void
    {
        $standings = $this->get($fixture);
        foreach ($standings as $standing) {
            $points = 0;
            $won = 0;
            $drawn = 0;
            $lost = 0;
            $goalsFor = 0;
            $goalsAgainst = 0;
            $playedGames = $this->gameRepository->getPlayedTeamGamesForFixture($fixture, $standing->team);
            foreach ($playedGames as $game) {
                if ($game->home_team_id == $standing->team->id) {

                    if ($game->home_team_score > $game->away_team_score) {
                        $points += 3;
                        $won += 1;
                    } elseif ($game->home_team_score < $game->away_team_score) {
                        $lost += 1;
                    } else {
                        $drawn += 1;
                        $points += 1;
                    }

                    $goalsFor += $game->home_team_score;
                    $goalsAgainst += $game->away_team_score;

                } elseif($game->away_team_id == $standing->team->id) {

                    if ($game->away_team_score > $game->home_team_score) {
                        $points += 3;
                        $won += 1;
                    } elseif ($game->away_team_score < $game->home_team_score) {
                        $lost += 1;
                    } else {
                        $drawn += 1;
                        $points += 1;
                    }

                    $goalsFor += $game->away_team_score;
                    $goalsAgainst += $game->home_team_score;

                }
            }

            $standing->won = $won;
            $standing->points = $points;
            $standing->drawn = $drawn;
            $standing->goal_difference = $goalsFor - $goalsAgainst;
            $standing->lost = $lost;
            $standing->update();
        }
    }

    public function clearAll()
    {
        Standing::truncate();
    }
}
