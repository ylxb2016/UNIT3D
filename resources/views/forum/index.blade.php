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
        <forum-categories-table :categories="{{ $categories }}"></forum-categories-table>
    </div>
@endsection