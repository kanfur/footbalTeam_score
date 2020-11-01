<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'home_team_id','away_team_id','home_team_goals','away_team_goals','week_count'
    ];
    protected $with = ["home_team","away_team"];

    public function home_team(){
        return $this->belongsTo('App\Models\Team',"home_team_id", "id");
    }
    public function away_team(){
        return $this->belongsTo('App\Models\Team',"away_team_id", "id");
    }
    public function scopePlayed($query){
        return $query->whereNotNull('home_team_goals');
    }
    public function getStatus(){
        if($this->home_team_goals > $this->away_team_goals){
            return 1;
        }
        if($this->home_team_goals < $this->away_team_goals){
            return 2;
        }
        if($this->home_team_goals == $this->away_team_goals){
            return 0;
        }
        return null;
    }
}
