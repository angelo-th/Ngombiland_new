<?php

use Illuminate\Support\Facades\Http;

$response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
    'latlng' => $report->latitude . ',' . $report->longitude,
    'key' => env('GOOGLE_MAPS_API_KEY')
]);
$data = $response->json();
