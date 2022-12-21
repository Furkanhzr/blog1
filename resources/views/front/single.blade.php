<!-- Main Content-->
@extends('front.layouts.master')
@section('title',$article->title)
@section('bg',asset($article->image))
@section('content')
                <div class="col-md-10 col-lg-8 col-xl-7">
                    {!!$article->content!!}
{{-- {{$article->content}} bunu kullanırsak database de yazdığımız html kodlarını yazı olarak verir--}}
{{--{!!$article->content!!} bu ise direkt front olarak basar--}}
                    <br> <br>
                    <span class="text-danger">Okunma Sayısı : <b>{{$article->hit}}</b></span>
                </div>
    @include('front.widgets.categoryWidget')
@endsection
