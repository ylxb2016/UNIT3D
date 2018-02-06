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
            <h1>{{ $game->game_name }} Game</h1>
          </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default margin-top-20px">
                <div class="panel-heading">Current odds on {{ $game->game_name }}</div>
                <table class="table table-hover table-bordered">
                    <tbody>
                        @foreach($game->outcomes as $outcome)
                            <tr>
                                <td class="col-md-5">{{ $outcome->outcome_name }}</td>
                                <td class="col-md-5">{{ $outcome->outcome_odds }}</td>
                                <td class="col-md-2">
                                    <form action="/games/winner" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="gameId" value="{{ $game->id }}">
                                        <input type="hidden" name="winningOutcome" value="{{ $outcome->outcome_name }}">
                                        <button class="btn btn-success" type="submit">Declare Winner</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                @foreach($outcomes as $outcome)
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Bets on {{ $outcome->outcome_name }}
                                <div class="pull-right">Pending Volume {{ $outcome->total_volume_pending }}</div>
                            </div>
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Odds</th>
                                        <th>Stake</th>
                                        <th>Total</th>
                                        <th>Pending</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingBets as $bet)
                                        @if($bet->outcome_name == $outcome->outcome_name)
                                            <tr>
                                                <td>{{ $bet->user->name }}</td>
                                                <td>{{ $bet->odds }}</td>
                                                <td>{{ $bet->stake }}</td>
                                                <td>{{ $bet->total_amount }}</td>
                                                <td>{{ $bet->pending_amount }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach($outcomes as $outcome)
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Filled bets on {{ $outcome->outcome_name }}</div>
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Odds</th>
                                        <th>Stake</th>
                                        <th>Total</th>
                                        <th>Pending</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($filledBets as $bet)
                                        @if($bet->outcome_name == $outcome->outcome_name)
                                            <tr>
                                                <td>{{ $bet->user->name }}</td>
                                                <td>{{ $bet->odds }}</td>
                                                <td>{{ $bet->stake }}</td>
                                                <td>{{ $bet->total_amount }}</td>
                                                <td>{{ $bet->pending_amount }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
