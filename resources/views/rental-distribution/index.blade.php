@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Rent Distribution</h1>

        <div class="row">
            @foreach ($projects as $project)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->title }}</h5>
                            <p class="card-text">{{ Str::limit($project->property->description, 100) }}</p>
                            <a href="{{ route('rental-distribution.show', $project) }}" class="btn btn-primary">Distribute Rent</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection