<!-- Main Content-->
@extends('front.layouts.master')
@section('title')
    Anasayfa
@endsection
@section('content')

        <div class="col-md-8 col-xl-7">
            @include('front.widgets.articleList')
        </div>

        @include('front.widgets.categoryWidget')
@endsection
