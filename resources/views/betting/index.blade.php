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
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default margin-top-20px">
                <div class="panel-heading">Select a game to bet on</div>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Game Name</th>
                            <th>Game Start Time</th>
                            <th>Team 1</th>
                            <th>Odds</th>
                            <th>Team 2</th>
                            <th>Odds</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    @foreach($games as $game)
                        <tr @if($game->status == 'active') class="table-hover clickable-row" @endif data-href="bet/{{ $game->id }}">
                            <td>{{ $game->game_name }}</td>
                            <td>{{ $game->game_start_time }}</td>
                            @foreach($game->outcomes as $outcome)
                                <td>{{ $outcome->outcome_name }}</td>
                                <td>{{ $outcome->outcome_odds }}</td>
                            @endforeach
                            <td>{{ ucfirst($game->status) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
