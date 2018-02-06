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
                <div class="panel-heading">Betting on {{ $game->game_name }}</div>
                <table class="table table-hover table-bordered">
                    <tbody>
                        @foreach($game->outcomes as $outcome)
                            <tr>
                                <td class="col-md-5">{{ $outcome->outcome_name }}</td>
                                <td class="col-md-5">{{ $outcome->outcome_odds }}</td>
                                <td class="col-md-2">
                                    <button
                                        type="button"
                                        class="btn btn-success"
                                        data-toggle="modal"
                                        data-target="#betting-modal"
                                        data-outcome="{{ $outcome->outcome_name }}"
                                        data-odds="{{ $outcome->outcome_odds }}"
                                    >
                                    Place Bet
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Betting Modal -->
<div class="modal fade" id="betting-modal" tabindex="-1" role="dialog" aria-labelledby="bettingModalTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="bettingModalTitle">Place bet on {{ $game->game_name }}</h4>
            </div>
            <div class="modal-body">
                <form action="/bets" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="gameId" value="{{ $game->id }}">
                    <div class="form-group">
                        <label for="outcome_name">Betting on</label>
                        <input class="form-control" type="text" name="outcome_name" id="outcome_name">
                    </div>

                    <div class="form-group">
                        <label for="odds">Odds</label>
                        <input class="form-control" type="text" name="odds" id="odds">
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount (BON)</label>
                        <input class="form-control" type="text" name="amount" id="amount" value="5000">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary pull-right" type="submit">Place Bet</button>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#betting-modal').on('show.bs.modal', function (event){
        var button = $(event.relatedTarget)
        var outcome = button.data('outcome')
        var odds = button.data('odds')

        $(".modal-body #outcome_name").val( outcome );
        $(".modal-body #odds").val( odds );
    })
</script>

@endsection
