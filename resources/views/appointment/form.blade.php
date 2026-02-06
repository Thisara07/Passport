@extends('layouts.app')

@section('content')
    <livewire:appointment-scheduler :reschedule_id="$reschedule_id" />
@endsection
