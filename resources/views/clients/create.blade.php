@extends('layouts.app')

@section('content')
<div class="container">
    <client-form :user_id="@json($userId)"></client-form>
</div>
@endsection
