@extends('layouts.app')

@section('content')
<div class="container">
    <booking-form :client='@json($client)'></booking-form>
</div>
@endsection
