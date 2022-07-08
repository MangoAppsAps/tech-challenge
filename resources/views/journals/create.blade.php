@extends('layouts.app')

@section('content')
<div class="container">
    <journal-form :client='@json($client)'></journal-form>
</div>
@endsection
