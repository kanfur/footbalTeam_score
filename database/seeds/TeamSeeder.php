<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Team::query()->delete();

        \App\Services\TeamService::createATeam("Galatasaray","gs",3,3);
        \App\Services\TeamService::createATeam("Fenerbahçe","fb",3,2);
        \App\Services\TeamService::createATeam("Beşiktaş","bjk",2,3);
        \App\Services\TeamService::createATeam("Karabükspor","kbü",1,1);
    }
}
