@if (Auth::id() != $user->id)
    @if (Auth::user()->is_favorite($user->id))
        {{-- お気に入り解除ボタン --}}
        {!! Form::open(['route' => ['user.favorite',$user->id],'method' => 'delete']) !!}
                {!! Form::submit('Unfavorite', ['class' => "btn btn-danger btn-block"]) !!}
        {!! Form::close() !!}
    @else
        {{-- お気に入りボタン --}}
        {!! Form::open(['route' => ['user.favorite', $user->id]]) !!}
            {!! Form::submit('Favorite', ['class' => "btn btn-primary btn-block"]) !!}
        {!! Form::close() !!}
    @endif
@endif