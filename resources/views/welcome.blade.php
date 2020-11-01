<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="alert alert-success">
                <div class="title m-b-md">
                    Football Teams Analytics
                </div>

                <div class="row">
                    <div class="col container">
                        <div class="row">
                            <div class="col-4">Name</div>
                            <div class="col-1">Pts</div>
                            <div class="col-1">Ply</div>
                            <div class="col-1">W</div>
                            <div class="col-1">D</div>
                            <div class="col-1">L</div>
                            <div class="col-1">GD</div>
                        </div>
                        @forelse ($teams as $team)
                            <div class="row">
                                <div class="col-4">{{ $team->name }}</div>
                                <div class="col-1">{{ $team->statistic["pts"] }}</div>
                                <div class="col-1">{{ $team->statistic["played"] }}</div>
                                <div class="col-1">{{ $team->statistic["wins"] }}</div>
                                <div class="col-1">{{ $team->statistic["draws"] }}</div>
                                <div class="col-1">{{ $team->statistic["losses"] }}</div>
                                <div class="col-1">{{ $team->goals_diff }}</div>
                            </div>
                        @empty
                            <p>No teams</p>
                        @endforelse
                    </div>
                    <div class="col">
                        @forelse ($matches as $match)
                            <div class="row">
                                <li>{{ $match->home_team->name }} {{ $match->home_team_goals }} - {{ $match->away_team_goals }} {{ $match->away_team->name }}</li>
                            </div>

                        @empty
                            <p>No Matches</p>
                        @endforelse
                    </div>

                </div>
                <div class="container m-2 row">
                    <div class="col"><a class="btn btn-success"href="?fixture=true" >Create A Fixture</a>
                        <a class="btn btn-danger" href="?fixture_fresh=true" >Delete The Fixture</a></div>
                    <div class="col">
                        @if($week!=1)
                            <a class="btn btn-info"href="?week={{$week>1?$week-1:$week}}" > back </a>
                        @endif
                        <a class="btn btn-info" href="?week={{$week+1}}" > forward</a>
                        <a class="btn btn-info" href="?play={{$week}}" > Play</a>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>
