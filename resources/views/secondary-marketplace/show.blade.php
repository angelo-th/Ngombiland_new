@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $listing->investment->crowdfundingProject->title }}</h1>

        <div class="row">
            <div class="col-md-8">
                <p><strong>Seller:</strong> {{ $listing->seller->name }}</p>
                <p><strong>Shares on Sale:</strong> {{ $listing->shares_on_sale }}</p>
                <p><strong>Price Per Share:</strong> {{ $listing->price_per_share }}</p>

                <div class="mt-4">
                    <h3>Buy Shares</h3>
                    <form action="{{ route('secondary-marketplace.buy', $listing) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="shares">Number of Shares to Buy</label>
                            <input type="number" name="shares" id="shares" class="form-control" min="1" max="{{ $listing->shares_on_sale }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Buy Shares</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
