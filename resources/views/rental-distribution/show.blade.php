@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Distribute Rent for {{ $project->title }}</h1>

        <div class="row">
            <div class="col-md-8">
                <form action="{{ route('rental-distribution.distribute', $project) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="rental_amount">Total Rent Amount</label>
                        <input type="number" name="rental_amount" id="rental_amount" class="form-control" min="0" step="0.01">
                    </div>
                    <button type="submit" class="btn btn-primary">Distribute</button>
                </form>
            </div>
        </div>
    </div>
@endsection