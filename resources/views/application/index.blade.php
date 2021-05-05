@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<a href="/application/create">create</a>
@if ($applications)
<table>
@foreach ($applications as $app)
<tr>
    <td> {{$app['id']}}</td>
    <td> {{$app['user_id']}}</td>
    <td> {{$app['charity_id']}}</td>
    <td> {{$app['stage']}}</td>
    <td> {{$app['created_at']}}</td>
    <td><a href="/application/{{$app['id']}}/edit">edit</a></td>
</tr>
@endforeach
</table>
@endif
@endsection