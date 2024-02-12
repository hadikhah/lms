@extends('Home::layout.master')
@section('content')
    <main id="index" class="mrt-205">
        <article class="container article">
            @include('Home::layout.header-ads')
            @include('Home::layout.top-info')
            @include('Home::layout.latestCourses')
            @include('Home::layout.popularCourses')
        </article>
        @include('Home::layout.latestArticles')
        <main id="single">
@endsection
