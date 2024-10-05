@extends('layouts.master')

@section('content')

{{-- @livewire('show-sub-area' , ['area_id', $area_id]) --}}
<livewire:client-account-transaction />

@endsection
