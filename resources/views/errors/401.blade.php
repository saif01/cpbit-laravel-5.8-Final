<script>
window.location.href = "{{ url('/') }}";
</script>



@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized'))
