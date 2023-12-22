@extends('layouts.app')

@section('content')
<div class="container">
    <journal-form :client-id="{{$clientId}}"></journal-form>
</div>
@endsection