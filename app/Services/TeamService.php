<?php
/**
 * Created by PhpStorm.
 * User: mizrak
 * Date: 3/15/19
 * Time: 8:33 PM
 */

namespace App\Services;

use App\Models\Team;
use App\Models\TeamPower;

class TeamService
{

    static $teams = [];

    public static function createATeam($name,$short_name,$keeper_power,$goal_power){
        $team = Team::updateOrCreate([
            'name' => $name,
            "short_name" => $short_name
        ]);

        $team->power()->saveMany([
            new TeamPower(['power_type' => TeamPower::TYPE["keeper_power"],'power' => $keeper_power]),
            new TeamPower(['power_type' => TeamPower::TYPE["goal_power"],'power' => $goal_power])
        ]);

        if(!array_search($team,self::$teams)){
            self::$teams[] = $team;
        }
    }


    public static function fresh(){

    }
}
