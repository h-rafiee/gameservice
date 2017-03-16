@extends('admin.master')

@section('content')
    <p>
        <a href="{{url('admin')}}">< Back </a><br>
    </p>

    @if ($message = Session::get('success'))
        <p>{{ $message }}</p>
    @endif
    <h3>
        Users
    </h3>
    <hr>
    <a href="{{ route('users.create') }}"> Create New Item</a>

    <table class="u-full-width">
        <tbody>
        @foreach($items as $item)

            <tr>
                <td>{{ ++$i }}</td>
                <td>{{$item->username}}</td>
                <td>{{$item->email}}</td>
                <td><a href="{{ route('users.edit',$item->id) }}" class="button">Edit</a></td>
                <td>
                    <form action="{{route('users.destroy',$item->id)}}" method="post" style="display: inline;">
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