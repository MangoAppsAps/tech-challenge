@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <client-show :client='@json($client)' :tab='@json($_GET['tab'] ?? '')'></client-show>
</div>
@endsection
