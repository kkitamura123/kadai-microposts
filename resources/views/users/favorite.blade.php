@extends('layouts.app')

@section('content')
    <div class="row">
        {{--アイコンの大きさが変わるcol-sm-4--}}
        <aside class="col-sm-4">
            {{-- ユーザ情報 --}}
            @include('users.card')
        </aside>
        {{--TimeLine Followings Followersのタブのサイズが変わる/col-sm-8--}}
        <div class="col-sm-8">
            {{-- タブ --}}
            @include('users.navtabs')

            {{-- 投稿一覧 --}}
            @include('microposts.microposts')
        </div>
    </div>
@endsection