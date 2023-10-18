@extends('layouts.app')

@section('content')
    <div class="container">
        <journal-form :current_client="{{ json_encode($current_client) }}"></journal-form>
    </div>
@endsection
