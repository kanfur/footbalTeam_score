<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name','short_name','logo_path'
    ];
    protected $appends = [
        "goal_power","keeper_power","goals_diff","statistic"
    ];

    public function power(){
        return $this->hasOne('App\Models\TeamPower',"team_id", "id");
    }


    public function getGoalPowerAttribute()
    {
        $power = TeamPower::where('team_id',$this->id)->where('power_type',TeamPower::TYPE["goal_power"])->first();
        return  $power?$power->power:0;
    }
    public function getKeeperPowerAttribute()
    {
        $power = TeamPower::where('team_id',$this->id)->where('power_type',TeamPower::TYPE["keeper_power"])->first();
        return $power?$power->power:0;
    }
    public function getStatisticAttribute()
    {
        $wins = 0;
        $draws = 0;
        $loss = 0;
        $played = 0;
        $points = 0;
        $matches = Match::where('home_team_id',$this->id)->played()->get();
        foreach ($matches as $match){
            if($match->getStatus() == 1){
                $wins++;
                $points+=3;
            }
            if($match->getStatus() == 0){
                $draws++;
                $points+=1;
            }
            if($match->getStatus() == 2){
                $loss++;
            }
            $played++;
        }
        $matches = Match::where('away_team_id',$this->id)->played()->get();
        foreach ($matches as $match){
            if($match->getStatus() == 2){
                $wins++;
                $points+=3;
            }
            if($match->getStatus() == 0){
                $draws++;
                $points+=1;
            }
            if($match->getStatus() == 1){
                $loss++;
            }
            $played++;
        }
        return ["played" => $played,"pts" => $points,"wins" => $wins,"draws" => $draws,"losses" => $loss];
    }
    public function getGoalsDiffAttribute()
    {
        $teams = Team::count();
        $weeks = $teams*2-2;
        $diff = 0;
        for($week = 1; $week <= $weeks ; $week++){
            $match = Match::where('home_team_id',$this->id)->where('week_count',$week)->first();
            if($match){
                $diff = $diff+($match->home_team_goals-$match->away_team_goals);
            }
            $match = Match::where('away_team_id',$this->id)->where('week_count',$week)->first();
            if($match){
                $diff = $diff+($match->away_team_goals-$match->home_team_goals);
            }
        }

        return $diff;
    }
}
