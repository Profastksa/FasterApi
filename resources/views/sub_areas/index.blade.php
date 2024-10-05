@extends('layouts.master')

@section('content')
{{-- @livewire('show-sub-area' , ['area_id', $area_id]) --}}
<livewire:show-sub-area :areaid="$area_id" />

@endsection
