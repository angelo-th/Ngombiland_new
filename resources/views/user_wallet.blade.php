@extends('layouts.app')

@section('title', 'Mon Wallet - NGOMBILAND')

@section('content')
    @include('sections.wallet_header')
    @include('sections.wallet_balance')
    @include('sections.wallet_transactions')
    @include('modals.wallet_topup')
    @include('modals.wallet_withdraw')
@endsection
