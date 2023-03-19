@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <client-show :client-data='@json($client)'></client-show>
</div>
@endsection