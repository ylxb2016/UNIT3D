@extends('layout.default')

@section('title')
    <title>{{ trans('forum.forums') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ config('other.title') }} - {{ trans('forum.forums') }}">
@endsection


@section('breadcrumb')
    <li class="active">
        <a href="{{ route('forum_index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ trans('forum.forums') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="box container">

        <form role="form" method="POST" action="{{ route('forum_search') }}">
            {{ csrf_field() }}

            <input type="text" name="name" id="name"
                   placeholder="{{ trans('forum.topic-quick-search') }}"
                   class="form-control">
        </form>

        <forum-categories-table :categories="{{ $categories }}"></forum-categories-table>

    </div>
@endsection