@extends('layouts.app')

{{--@push('head')--}}
{{--    <script src="../../js/client-events.js"></script>--}}
{{--@endpush--}}

@section('content')
<div class="container">
    <clients-list :clients='@json($clients)'></clients-list>
</div>
@endsection

