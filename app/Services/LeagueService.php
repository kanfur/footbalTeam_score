<?php
/**
 * Created by PhpStorm.
 * User: mizrak
 * Date: 3/15/19
 * Time: 8:33 PM
 */

namespace App\Services;

use App\Helpers\Functions;
use App\Models\Match;
use App\Models\Team;
use App\Models\TeamPower;

class LeagueService
{
    private $teams = [];
    private static $is_fixtured = false;

    public function __construct($teams)
    {
        $this->teams = $teams;
    }

    public function createAFixture(){
        if(!self::$is_fixtured){
            $this->freshFixture();
            $this->makeMatchesFixtures();
        }
    }
    private function getMatches()
    {
        $fixtures = [];
        foreach ($this->teams as $homeTeam) {
            foreach ($this->teams as $awayTeam) {
                if ($homeTeam === $awayTeam) {
                    continue;
                }
                $fixtures[] = [
                    'home' => $homeTeam["id"],
                    'away' => $awayTeam["id"]
                ];
            }
        }
        shuffle($fixtures);
        return $fixtures;
    }

    public function makeMatchesFixtures()
    {
        $teams = $this->teams;

        $matches = $this->getMatches(); //olası eşleşmeler
        $weeks = count($matches)/2; // Weeks

        for($i = 1; $i <= $weeks; $i++){

            $weekly_matches_ids = []; //Weekly matches
            foreach ($teams as $team) {
                $herlperFunction = new Functions();
                $key = $herlperFunction->search_for_id($team["id"],$matches,$weekly_matches_ids); // ev sahibi maçı var mı
                if(!is_null($key)){
                    //dump($team["name"]." için ev sahibi maçı bulundu. "."match -> ".$matches[$key]["home"]." - ".$matches[$key]["away"]);
                    //iki takımında hiç maçı yoksa
                    if(array_search($matches[$key]["home"],$weekly_matches_ids) === false && array_search($matches[$key]["away"],$weekly_matches_ids) === false){
                        //dump("(".$team["id"].") ".$team["name"]." eklendi");
                        $match = new Match();
                        $match->home_team_id = $matches[$key]["home"];
                        $match->away_team_id = $matches[$key]["away"];
                        $match->week_count = $i;
                        $match->save();

                        $weekly_matches_ids[] = $matches[$key]["home"];
                        $weekly_matches_ids[] = $matches[$key]["away"];

                        unset($matches[$key]);
                        $matches = array_values($matches);
                    }else{
                        //dump($team["name"]." Maçı var bu hafta ");
                    }
                }else{
                    //dump("!!!! ".$team["id"]." bulunamadı");
                }
                //dump(count($matches)." matches remained");
            }
        }
        self::$is_fixtured = true;
        return true;
    }
    public function freshFixture(){
        Match::query()->delete();
    }
    public function playWeeklyMatch($week){
        $matches = Match::where('week_count',$week)->get();
        foreach ($matches as $match){
            $home_team = $match->home_team;
            $away_team = $match->away_team;
            $scores = $this->getGoalsForTeam($home_team,$away_team);
            $match->home_team_goals = $scores[0];
            $match->away_team_goals = $scores[1];
            $match->save();
        }
        return true;
    }
    private function getGoalsForTeam($home_team,$away_team){
        /** Calculating Scores with their powers**/
        //Goal Power
        //Keeper Power
        $helper = new Functions();
        $home_goal_power = $helper->getMaxNumberByRandom( $home_team->goal_power,7);
        $home_keeper_power = $helper->getMaxNumberByRandom( $home_team->keeper_power,7);
        //dump("home goal: ".$home_goal_power,"home keeper".$home_keeper_power);
        $away_goal_power = $helper->getMaxNumberByRandom( $away_team->goal_power,7);
        $away_keeper_power = $helper->getMaxNumberByRandom( $away_team->keeper_power,7);
        //dump("away goal: ".$away_goal_power,"away keeper".$away_keeper_power);
        $home_team_goals = $home_goal_power-$away_keeper_power;
        $away_team_goals = $away_goal_power-$home_keeper_power;
        $home_team_goals = $home_team_goals<0?0:$home_team_goals;
        $away_team_goals = $away_team_goals<0?0:$away_team_goals;
        return [0 => $home_team_goals, 1 => $away_team_goals];
    }
}
