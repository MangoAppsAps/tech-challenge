@extends('layouts.app')

@section('content')
    <div class="container">
        <journal-create-form :client='@json($client)'></journal-create-form>
    </div>
@endsection
