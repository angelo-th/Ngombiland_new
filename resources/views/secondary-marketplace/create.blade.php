@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>List Your Shares for Sale</h1>

        <form action="{{ route('secondary-marketplace.store') }}" method="POST">
            @csrf
            <input type="hidden" name="investment_id" value="{{ $investment->id }}">

            <div class="form-group">
                <label for="shares">Number of Shares to Sell</label>
                <input type="number" name="shares" id="shares" class="form-control" min="1" max="{{ $investment->shares_purchased }}">
            </div>

            <div class="form-group">
                <label for="price_per_share">Price Per Share</label>
                <input type="number" name="price_per_share" id="price_per_share" class="form-control" min="0" step="0.01">
            </div>

            <button type="submit" class="btn btn-primary">List Shares</button>
        </form>
    </div>
@endsection
