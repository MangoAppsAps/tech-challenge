@extends('layouts.app')

@section('content')
<div class="container">
    <clients-list :clients-data='@json($clients)'></clients-list>
</div>
@endsection