@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <client-show :client='@json($client)' :journals='@json($journals)'></client-show>
</div>
@endsection
