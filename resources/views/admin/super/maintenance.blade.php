@extends('admin.layout.master')

@section('content')

<div class="text-center">
    <h1>Maintenance For User Section</h1>
    <hr><br>
    @if ($maintenance)
    <p class="text-danger h4" >Already Activated Maintenance Mode For User Section</p>
    <a href="{{ route('super.maintanance.deactive') }}" class="btn gradient-green-tea text-white btn-lg">Maintenance Deactive</a>
    @else

    <p class="text-success h4">Deactivated Maintenance Mode For User Section</p>
    <a href="{{ route('super.maintanance.active') }}" class="btn gradient-sublime-vivid text-white btn-lg">Maintenance Active</a>
    @endif
</div>


@endsection
