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
<form action="/application" method="POST">
@csrf
<table>
    <tr>
        <td> <label for="charity_id">Select Charity</label></td>
        <td> 
            <select name="charity_id" id="charity">
                <option value="--">-- Please select --</option>
                @foreach ($charities as $charity)
                <option value="{{$charity['id']}}">{{$charity['charity_name']}}</option>
                @endforeach
            </select>
        </td>
    </tr>
</table>
<button type="submit">Apply</button>
</form>
@endsection