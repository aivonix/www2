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
<form action="/application/{{$application['id']}}" method="POST">
<input name="_method" type="hidden" value="PUT">
@csrf
<table>
    <tr>
        <td> <label for="stage">Select Stage</label></td>
        <td> 
            <input name="user_id" type="hidden" value="{{$application['user_id']}}">
            <input name="charity_id" type="hidden" value="{{$application['charity_id']}}">
            <select name="stage" id="stage">
                @foreach ($stages as $key => $stage)
                <option value="{{$key}}" @if ($application['stage'] == $key ) selected="selected" @endif>{{$stage}}</option>
                @endforeach
            </select>
        </td>
    </tr>
</table>
<button type="submit">Update</button>
</form>
@endsection