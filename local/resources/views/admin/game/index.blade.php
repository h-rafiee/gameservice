@extends('admin.master')

@section('content')
    <p>
        <a href="{{url('admin')}}">< Back </a><br>
    </p>

    @if ($message = Session::get('success'))
        <p>{{ $message }}</p>
    @endif
    <h3>
        Games
    </h3>
    <hr>
    <a href="{{ route('games.create') }}"> Create New Item</a>

    <table class="u-full-width">
        <tbody>
        @foreach($items as $item)

            <tr>
                <td>{{ ++$i }}</td>
                <td>{{$item->package_name}}</td>
                <td>{{$item->title}}</td>
                <td><a href="{{url('admin/achievements/game/'.$item->id)}}" class="button">Achievements</a></td>
                <td><a href="{{url('admin/items/game/'.$item->id)}}" class="button">Shop</a></td>
                <td><a href="{{ route('games.edit',$item->id) }}" class="button">Edit</a></td>
                <td>
                    <form action="{{route('games.destroy',$item->id)}}" method="post" style="display: inline;">
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