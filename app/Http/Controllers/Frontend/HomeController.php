<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    // public function index()
    // {
    //     $accessKey = 'a726603e54efab53c940dd64509e5916';
    //     $symbol = 'TCS.XNSE';

    //     $apiEndpoint = 'http://api.marketstack.com/v1/exchanges/'.$symbol.'/eod';
    //     $queryParams = [
    //         'access_key' => $accessKey
    //     ];

    //     try {
    //         $response = Http::get($apiEndpoint, $queryParams);

    //         $apiResult = $response->json();

    //         $apiData = [];
    //         if (isset($apiResult['data'])) {
    //             $apiData = $apiResult['data']['eod'];
    //         }
    //     } catch (\Exception $e) {
    //         // Log the exception
    //         \Log::error($e->getMessage());

    //         // Handle the exception if the API request fails
    //         $apiData = null;
    //     }

    //     return view('frontend.index', ['apiData' => $apiData]);
    // }

    public function index()
    {
        $accessKey = 'a726603e54efab53c940dd64509e5916';
        $symbol = 'RELIANCE.XNSE';

        $apiEndpoint = 'http://api.marketstack.com/v1/eod';
        $queryParams = [
            'access_key' => $accessKey,
            'symbols' => $symbol,
        ];

        try {
            $response = Http::get($apiEndpoint, $queryParams);

            $apiResult = $response->json();

            $apiData = [];
            if (isset($apiResult['data'])) {
                $apiData = $apiResult['data'];
            }
        } catch (\Exception $e) {
            // Log the exception
            \Log::error($e->getMessage());

            // Set error message
            $errorMessage = 'Failed to retrieve stock market data. Please try again later.';

            return view('frontend.index', ['errorMessage' => $errorMessage]);
        }

        return view('frontend.index', ['apiData' => $apiData]);
    }

    public function nifty50()
    {
        $accessKey = 'a726603e54efab53c940dd64509e5916';
        $exchangeMIC = 'INDX';

        $apiEndpoint = 'http://api.marketstack.com/v1/exchanges/' . $exchangeMIC . '/tickers';
        $queryParams = [
            'access_key' => $accessKey,
        ];

        try {
            $response = Http::get($apiEndpoint, $queryParams);

            $apiResult = $response->json();

            $nifty50Data = [];
            if (isset($apiResult['data'])) {
                $nifty50Data = $apiResult['data'];
            }
        } catch (\Exception $e) {
            // Log the exception
            \Log::error($e->getMessage());

            // Handle the exception if the API request fails
            $nifty50Data = null;
        }

        return view('frontend.nifty50', ['nifty50Data' => $nifty50Data]);
    }

    // News Details
    public function viewNews(Blog $blog)
    {
        return view('frontend.newsDetails', compact('blog'));
    }

    //    public function callApi()
    //    {
    //        $client = new Client();

    //        try {
    //            $response = $client->get('https://api.example.com/endpoint', [
    //                'headers' => [
    //                    'Authorization' => 'Bearer ' . config('app.api_key'),
    //                ],
    //            ]);

    //            $data = json_decode($response->getBody(), true);

    //            // Process the API response

    //            return $data;
    //        } catch (RequestException $e) {
    //            // Handle request exception
    //            // For example, log the error or show an error message to the user
    //            return null;
    //        }
    //    }
}
