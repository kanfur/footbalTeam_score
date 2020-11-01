<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Team;
use App\Services\LeagueService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private $leagueService;
    public function __construct(LeagueService $leagueService)
    {
        $this->leagueService = $leagueService;
    }

    public function index(Request $request){
        if($request->fixture){
            $this->leagueService->createAFixture();
        }
        if($request->fixture_fresh){
            $this->leagueService->freshFixture();
        }
        if(!$request->week && !$request->play){
           $week = 1;
        }else{
            $week = $request->week? $request->week : $request->play;
        }
        if($request->play){
            $this->leagueService->playWeeklyMatch($request->play);
        }

        $teams = Team::get();
        $matches = Match::where('week_count',$week)->get();

        $teams = collect($teams);
        $teams = $teams->sortByDesc(function ($team, $key) {
            return $team['statistic']['pts'];
        });

        return view('welcome',["teams" => $teams,"matches" => $matches,"week" => $week]);
    }
}
