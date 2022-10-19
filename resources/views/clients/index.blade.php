@extends('layouts.app')

@section('content')
<div class="container">
    <clients-list :initial-clients='@json($clients->data)'></clients-list>
    @if($clients->meta->last_page > 1)
        <base-pagination :pagination='@json($clients->meta)'></base-pagination>
    @endif
</div>
@endsection
