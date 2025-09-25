@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $crowdfunding->title }}</h1>

        <div class="row">
            <div class="col-md-8">
                <p>{{ $crowdfunding->description }}</p>

                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ $crowdfunding->progress_percentage }}%;" aria-valuenow="{{ $crowdfunding->progress_percentage }}" aria-valuemin="0" aria-valuemax="100">{{ round($crowdfunding->progress_percentage) }}%</div>
                </div>

                <div class="mt-4">
                    <p><strong>Total Amount:</strong> {{ $crowdfunding->total_amount }}</p>
                    <p><strong>Amount Raised:</strong> {{ $crowdfunding->amount_raised }}</p>
                    <p><strong>Total Shares:</strong> {{ $crowdfunding->total_shares }}</p>
                    <p><strong>Shares Sold:</strong> {{ $crowdfunding->shares_sold }}</p>
                    <p><strong>Price Per Share:</strong> {{ $crowdfunding->price_per_share }}</p>
                    <p><strong>Expected ROI:</strong> {{ $crowdfunding->expected_roi }}%</p>
                    <p><strong>Funding Deadline:</strong> {{ $crowdfunding->funding_deadline->format('M d, Y') }}</p>
                </div>

                <div class="mt-4">
                    <h3>Invest in this project</h3>
                    <form action="{{ route('crowdfunding.invest', $crowdfunding) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="shares">Number of Shares</label>
                            <input type="number" name="shares" id="shares" class="form-control" min="1" max="{{ $crowdfunding->remaining_shares }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Invest</button>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Project Stats</h5>
                        <p><strong>Total Investors:</strong> {{ $stats['total_investors'] }}</p>
                        <p><strong>Average Investment:</strong> {{ $stats['average_investment'] }}</p>
                        <p><strong>Days Remaining:</strong> {{ $stats['days_remaining'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection