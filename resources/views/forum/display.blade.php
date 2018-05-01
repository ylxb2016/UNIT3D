@extends('layout.default')

@section('title')
    <title>{{ $forum->name }} - {{ trans('forum.forums') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ trans('forum.display-forum') . $forum->name }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('forum_index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ trans('forum.forums') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('forum_display', ['slug' => $forum->slug, 'id' => $forum->id]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $forum->name }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="box container">
        <div class="f-display">
            <div class="f-display-info col-md-12">
                <h1 class="f-display-info-title">{{ $forum->name }}</h1>
                <p class="f-display-info-description">{{ $forum->description }}
                    @if(auth()->user()->can('start_topic'))
                        <a href="{{ route('forum_new_topic', ['slug' => $forum->slug, 'id' => $forum->id]) }}"
                           class="btn btn-primary" style="float:right;">{{ trans('forum.create-new-topic') }}</a>
                    @endif
                </p>
            </div>
            <div class="f-display-table-wrapper col-md-12">
                {{-- NEED TO RE-THINK THIS WHOLE APPROACH --}}
            </div>
            <div class="f-display-pagination col-md-12">
                {{ $topics->links() }}
            </div>
        </div>
    </div>
@endsection
