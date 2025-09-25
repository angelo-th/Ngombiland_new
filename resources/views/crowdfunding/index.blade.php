@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crowdfunding Projects</h1>

        <div class="row">
            @foreach ($projects as $project)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->title }}</h5>
                            <p class="card-text">{{ Str::limit($project->description, 100) }}</p>
                            <p><strong>Total Amount:</strong> {{ $project->total_amount }}</p>
                            <p><strong>Amount Raised:</strong> {{ $project->amount_raised }}</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $project->progress_percentage }}%;" aria-valuenow="{{ $project->progress_percentage }}" aria-valuemin="0" aria-valuemax="100">{{ round($project->progress_percentage) }}%</div>
                            </div>
                            <a href="{{ route('crowdfunding.show', $project) }}" class="btn btn-primary mt-3">View Project</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $projects->links() }}
    </div>
@endsection
