@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Secondary Marketplace</h1>

        <div class="row">
            @foreach ($listings as $listing)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $listing->investment->crowdfundingProject->title }}</h5>
                            <p class="card-text">Seller: {{ $listing->seller->name }}</p>
                            <p><strong>Shares on Sale:</strong> {{ $listing->shares_on_sale }}</p>
                            <p><strong>Price Per Share:</strong> {{ $listing->price_per_share }}</p>
                            <a href="{{ route('secondary-marketplace.show', $listing) }}" class="btn btn-primary">View Listing</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $listings->links() }}
    </div>
@endsection
