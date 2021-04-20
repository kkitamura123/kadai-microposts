<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    // public function store($micropostId)
    // {
    //     \Auth::micropost()->favorite($micropostId);
    //     return back();
    // }
    // public function destroy($micropostId)
    // {
    //     \Auth::micropost()->unfavorite($micropostId);
    //     return back();
    // }
    
    //対象とする投稿のidを使って「お気に入り登録をする」
    public function store($micropostId)
    {
        //認証済みユーザ（閲覧者） \Auth::user();
        //ログイン中のユーザのインスタンスを取得
        //お気に入りの投稿をお気に入り処理
        \Auth::user()->favorite($micropostId);
        //元のページへリダイレクト
        return back();
    }
    public function destroy($micropostId)
    {
        // 認証済みユーザ（閲覧者）を取得\Auth::user()
        //お気に入り投稿をお気に入り解除->unfavorite($micropostId);
        //ログイン中のユーザのインスタンスを取得
        //認証されたユーザがお気に入り投稿をお気に入り解除
        \Auth::user()->unfavorite($micropostId);
        //元のページへリダイレクト
        return back();
    }
}
