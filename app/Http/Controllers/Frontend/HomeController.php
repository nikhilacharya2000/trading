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
    $apiEndpoint = 'https://www.nseindia.com/api/option-chain-indices?symbol=FINNIFTY';
    //https://www.nseindia.com/api/quote-derivative?symbol=NIFTY derivative api
    

    try {
        // Initialize cURL session
        $curl = curl_init();
        
        // Set cURL options
        curl_setopt($curl, CURLOPT_URL, $apiEndpoint); // Set the URL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response instead of printing it
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (not recommended in production)
        
        // Execute the cURL request
        $apiResult = curl_exec($curl);
        
        // Check if the request was successful
        if ($apiResult === false) {
            throw new \Exception('cURL request failed: ' . curl_error($curl));
        }
        
        // Close the cURL session
        curl_close($curl);
        
        // Convert the JSON response to an associative array
        $apiResult = json_decode($apiResult, true);
        
        echo "<pre>";
        print_r($apiResult); // Print the API result for debugging purposes
        die; // Stop further execution of the script
        
    } catch (\Exception $e) {
        // Log the exception
        error_log($e->getMessage());
        print_r($e->getMessage());
        die;
        // Handle the exception if the API request fails
        $nifty50Data = null; // Set the variable to null if the request fails
    }
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
