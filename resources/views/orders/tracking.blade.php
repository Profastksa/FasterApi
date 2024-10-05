@extends('layouts.login-layout')

@push('links')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/pages/timeline.css')}}">
@endpush


@section('content')

{{-- @livewire('show-order-tracking') --}}
@livewire('show-order-tracking', ['tracking_id' => $id])

@endsection
