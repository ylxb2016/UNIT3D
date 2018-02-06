@extends('layout.default')

@section('title')
<title>{{ Config::get('other.title') }}</title>
@stop

@section('meta')
<meta name="description" content="{{ Config::get('other.title') }}">
@stop

@section('breadcrumb')

@stop

@section('content')
<div class="container box">
    <div class="row">
        <div class="header gradient teal">
          <div class="inner_content">
            <h1>Game Betting</h1>
          </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default margin-top-20px">
            <div class="panel-heading">{{ $bank->name }} Balance: <b>{{ $bank->value }} BON</b></div>
            </div>
            @if(Auth::user()->group->is_modo)
            <div class="panel panel-default">
                <div class="panel-body">
                    <form {{ action('GamesController@store') }} method="POST">
                        <div class="col-md-12">
                            <div class="col-md-6 col-md-offset-3">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="game_name">Game Name</label>
                                    <input type="text" class="form-control" name="game_name" placeholder="Game Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="outcome_1_name">Outcome 1 Name</label>
                                    <input type="text" class="form-control" name="outcome_1_name" placeholder="Outcome 1 Name">
                                </div>
                                <div class="form-group">
                                    <label for="outcome_2_name">Outcome 2 Name</label>
                                    <input type="text" class="form-control" name="outcome_2_name" placeholder="Outcome 2 Name">
                                </div>
                                <button class="btn btn-primary" type="submit">Create</button>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="outcome_1_name">Outcome 1 Odds</label>
                                    <input type="text" class="form-control" name="outcome_1_odds" placeholder="Outcome 1 Odds">
                                </div>
                                <div class="form-group">
                                    <label for="outcome_2_name">Outcome 2 Odds</label>
                                    <input type="text" class="form-control" name="outcome_2_odds" placeholder="Outcome 2 Odds">
                                </div>
                            </div>
                            <div class="col-md-12 margin-top-20px">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            @if(isset($games))
                <div class="panel panel-default">
                    <div class="panel-heading">Current Games</div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Game Name</th>
                                <th>Game Start Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        @foreach($games as $game)
                            <tr>
                                <td><a href="game/{{ $game->id }}">{{ $game->game_name }}</a></td>
                                <td>{{ $game->game_start_time }}</td>
                                <td>
                                    @if($game->status != "active")
                                    <div class="label label-danger">{{ ucfirst($game->status) }}</div>
                                    @else
                                    <div class="label label-success">{{ ucfirst($game->status) }}</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
