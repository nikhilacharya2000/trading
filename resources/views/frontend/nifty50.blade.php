@extends('frontend.layouts.master')

@section('title', 'Home')

@section('content')
<!-- frontend/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Stock Market Data</title>
</head>
<body>
    <h1>Nifty 50 </h1>

    @if ($nifty50Data)
        <table>
            <thead >
                <tr>
                    <th>Date</th>
                    <th>Open</th>
                    <th>High</th>
                    <th>Low</th>
                    <th>Close</th>
                    <th>Volume</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nifty50Data as $data)
                    <tr>
                        <td>{{ $data['date'] }}</td>
                        <td>{{ $data['open'] }}</td>
                        <td>{{ $data['high'] }}</td>
                        <td>{{ $data['low'] }}</td>
                        <td>{{ $data['close'] }}</td>
                        <td>{{ $data['volume'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Failed to retrieve stock market data. Please try again later.</p>
    @endif
</body>
</html>

@endsection