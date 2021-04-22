<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // 追加

use App\Micropost;

class UsersController extends Controller
{
    public function index()
    {
        // ユーザ一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10);

        // ユーザ一覧ビューでそれを表示
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    public function show($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザの投稿一覧を作成日時の降順で取得
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        // ユーザ詳細ビューでそれらを表示
        return view('users.show', [
            'user' => $user,
            'microposts' => $microposts,
        ]);
    }
    /**
     * ユーザのフォロー一覧ページを表示するアクション。
     *
     * @param  $id  ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function followings($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのフォロー一覧を取得
        $followings = $user->followings()->paginate(10);

        // フォロー一覧ビューでそれらを表示
        return view('users.followings', [
            'user' => $user,
            'users' => $followings,
        ]);
    }

    /**
     * ユーザのフォロワー一覧ページを表示するアクション。
     *
     * @param  $id  ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function followers($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのフォロワー一覧を取得
        $followers = $user->followers()->paginate(10);

        // フォロワー一覧ビューでそれらを表示
        return view('users.followers', [
            'user' => $user,
            'users' => $followers,
        ]);
    }
    
    //フォローと同じやり方
    public function favorite($micropostId)
    {
        // すでにフォローしているかの確認
        //お気に入り済みか = 指定した投稿のidがお気に入り済みかどうか判断する
        $exist = $this->favorite($micropostId);

        //if(お気に入り済みか)
        if ($exist && !$its_me) {
            // お気に入り済みの場合はお気に入り登録を解除する
            $this->favorites()->attach($micropostId);
            return true;
        } else {
            // お気に入り済みであれば何もしない
            return false;
        }
    }
    //アンフォローと同じやり方 User.phpから参照
    public function unfavorite($micropostId)
    {
        // すでにフォローしているかの確認
        //お気に入り済みか = 指定した投稿のidがお気に入り済みかどうか判断する
        $exist = $this->favorite($micropostId);

        //if(お気に入り済みか)
        if ($exist && !$its_me) {
            // お気に入り済みの場合はお気に入り登録を解除する
            $this->favorites()->detach($micropostId);
            return true;
        } else {
            // お気に入り済みであれば何もしない
            return false;
        }
        
    }
    
    //avoritesアクションはどのページを表示させるためのものか？
    //お気に入り一覧を表示する/favoritesアクション
    //favoritesボタンをタップした後のページを表示
    public function favorites($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのお気に入り一覧を取得
        //　$favoritesに入ってくるのはMicropostモデルの配列
        $favorites = $user->favorites()->paginate(10);
        

        // お気に入り一覧ビューでそれらを表示
        return view('users.favorite', [
            'user' => $user,
            'microposts' => $favorites,
        ]);
    }
}
