@extends('layout.default')

@section('title')
    <title>{{ trans('pool.pool') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ trans('pool.pool') }}">
@endsection

@section('breadcrumb')
    <li class="active">
        <a href="{{ route('pool') }}">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ trans('pool.pool') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container">
        <h1 class="title">{{ trans('bon.bon') }} {{ trans('pool.pool') }}</h1>
        <div class="block">
            @if (!$pool)
            <div class="well">
                <p class="text-bold text-center">
                    {{ trans('pool.not-active') }}
                </p>
            </div>
            @else
            <div class="well text-center">
                <p class="text-green">
                    There is currently an active Freeleech Pool! The goal is {{ number_format($pool->goal) }} {{ trans('bon.bon') }}.
                    If met global freeleech will activate for 7 days!
                </p>
                <span class="text-bold">
                    <strong>The current pool stands at {{ number_format($pool->current_pot) }} {{ trans('bon.bon') }} out of {{ number_format($pool->goal) }} {{ trans('bon.bon') }}</strong>
                    <br>
                    <br>
                    <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#modal_pool_contribute">
                        <i class="{{ config('other.font-awesome') }} fa-coins"></i>
                        {{ trans('pool.contribute') }}
                    </button>
                </span>
            </div>

            {{--<h2>Top 10 Contributors</h2>
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ trans('common.user') }}</th>
                        <th>{{ trans('common.amount') }}</th>
                        <th>{{ trans('common.added') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($top_contributors as $transaction)
                        <tr>
                            <td>
                            @if ($transaction->anon == 1)
                                <span class="badge-user text-orange text-bold">
                                    {{ strtoupper(trans('common.anonymous')) }}
                                    @if (auth()->user()->id == $transaction->user->id || auth()->user()->group->is_modo)
                                        <a href="{{ route('profile', ['username' => $transaction->user->username, 'id' => $transaction->user->id]) }}">
                                            ({{ $transaction->user->username }})
                                        </a>
                                    @endif
                                </span>
                            @else
                                <a href="{{ route('profile', ['username' => $transaction->user->username, 'id' => $transaction->user->id]) }}">
                                    <span class="badge-user text-bold" style="color:{{ $transaction->user->group->color }}; background-image:{{ $transaction->user->group->effect }};">
                                        <i class="{{ $transaction->user->group->icon }}" data-toggle="tooltip" data-original-title="{{ $transaction->user->group->name }}"></i>
                                        {{ $transaction->user->username }}
                                    </span>
                                </a>
                            @endif
                            </td>
                            <td>

                                {{ number_format($transaction->bonus_points) }} {{ trans('bon.bon') }}
                            </td>
                            <td>
                                {{ $transaction->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <br>--}}
            <h2>Latest Contributions</h2>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>{{ trans('common.user') }}</th>
                            <th>{{ trans('common.amount') }}</th>
                            <th>{{ trans('common.added') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pool->transactions as $transaction)
                            <tr>
                                <td>
                                    @if ($transaction->anon == 1)
                                        <span class="badge-user text-orange text-bold">
                                    {{ strtoupper(trans('common.anonymous')) }}
                                            @if (auth()->user()->id == $transaction->user->id || auth()->user()->group->is_modo)
                                                <a href="{{ route('profile', ['username' => $transaction->user->username, 'id' => $transaction->user->id]) }}">
                                            ({{ $transaction->user->username }})
                                        </a>
                                            @endif
                                </span>
                                    @else
                                        <a href="{{ route('profile', ['username' => $transaction->user->username, 'id' => $transaction->user->id]) }}">
                                    <span class="badge-user text-bold" style="color:{{ $transaction->user->group->color }}; background-image:{{ $transaction->user->group->effect }};">
                                        <i class="{{ $transaction->user->group->icon }}" data-toggle="tooltip" data-original-title="{{ $transaction->user->group->name }}"></i>
                                        {{ $transaction->user->username }}
                                    </span>
                                        </a>
                                    @endif
                                </td>
                                <td>

                                    {{ number_format($transaction->bonus_points) }} {{ trans('bon.bon') }}
                                </td>
                                <td>
                                    {{ $transaction->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @include('pool.pool_modals', ['pool' => $pool])
            @endif
        </div>
    </div>
@endsection
