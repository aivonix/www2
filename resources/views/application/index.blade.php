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
@can ('create-application', $applications)
<a href="/application/create">create</a>
@endcan
@if ($applications)
@can('view-applications', $applications)
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
@endcan
@endif
@endsection