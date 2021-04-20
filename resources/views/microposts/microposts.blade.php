@if (count($microposts) > 0)
    <ul class="list-unstyled">
        @foreach ($microposts as $micropost)
            <li class="media mb-3">
                {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($micropost->user->email, ['size' => 50]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                        {!! link_to_route('users.show', $micropost->user->name, ['user' => $micropost->user->id]) !!}
                        <span class="text-muted">posted at {{ $micropost->created_at }}</span>
                        {{-- NameのFavoritesボタン--}}
                    </div>
                    <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                    </div>
                    <div>
                        @if (Auth::id() == $micropost->user_id)
                            {{-- 投稿削除ボタンのフォーム --}}
                            {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                    <div>
                        {{-- 自分が書いた　お気に入りボタンを出す条件を考える --}}
                        {{-- お気に位入り解除ボタンを出す要件　お気に入り指定たらお気に入りボタンを出す　unfollow --}}
                        {{-- ボタンの中身　をお気に入りする機能に結びつける　解除も同じく --}}
                        {{-- フォローフォロワのボタン --}}
                        {{-- 1.お気に入りの登録・解除機能①ボタンの配置②登録/解除メソッドの実装--}}
                        {{-- 2.お気に入り一覧ページ ①favoritesボタンの配置 ②お気に入りデータの取得・表示--}}
                        {{--お気に入り登録しているか、どうか--}}
                        @if(Auth::user()->is_favorite($micropost->id))
                            {{-- Favorite解除ボタンのフォーム --}}
                            {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}
                                {!! Form::submit('unFavorite', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @else
                            {{-- Favoriteボタンのフォーム --}}
                            {!! Form::open(['route' => ['favorites.favorite', $micropost->id], 'method' => 'post']) !!}
                                {!! Form::submit('Favorite', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>    
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $microposts->links() }}
@endif