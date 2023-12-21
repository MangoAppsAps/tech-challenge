@extends('layouts.app')

@section('content')
    <div class="container">
        <journal-form :client="{{ $client }}"></journal-form>
    </div>
@endsection
