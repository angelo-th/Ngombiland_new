@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Crowdfunding Project for {{ $property->title }}</h1>

        @livewire('create-crowdfunding-project', ['property' => $property])
    </div>
@endsection
