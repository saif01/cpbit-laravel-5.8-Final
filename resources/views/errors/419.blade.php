<script>
window.location.href = "{{ url('/') }}";
</script>


@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))
