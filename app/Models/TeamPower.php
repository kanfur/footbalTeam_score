<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPower extends Model
{
    protected $fillable = [
        'team_id','power','power_type'
    ];

    const TYPE = [
        "keeper_power" => 0,
        "goal_power" => 1
    ];

}
