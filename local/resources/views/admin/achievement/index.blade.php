@extends('admin.master')

@section('content')
    <p>
        <a href="{{url('admin/games')}}">< Back </a><br>
    </p>

    @if ($message = Session::get('success'))
        <p>{{ $message }}</p>
    @endif
    <h3>
        Achievement Game {!! $game->title !!}
    </h3>
    <hr>
    <a href="{{ url("admin/achievements/game/1/add") }}"> Create New Item</a>

    <table class="u-full-width">
        <tbody>
        @foreach($items as $item)

            <tr>
                <td>{{ ++$i }}</td>
                <td>{{$item->title}}</td>
                <td><a href="{{ route('achievements.edit',$item->id) }}" class="button">Edit</a></td>
                <td>
                    <form action="{{route('achievements.destroy',$item->id)}}" method="post" style="display: inline;">
                        {!! csrf_field() !!}
                        {{ method_field('DELETE') }}
                        <button>delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $items->render() !!}
@endsection