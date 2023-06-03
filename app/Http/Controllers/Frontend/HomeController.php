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

    public function finnifty()
{
    $apiEndpoint = 'https://www.nseindia.com/api/option-chain-indices?symbol=FINNIFTY';

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

        // Process the option chain data
        $optionChainData = [];
        if (isset($apiResult['records']['data'])) {
            $optionChainData = $apiResult['records']['data'];
        }
        $expiryDate1 = [];
        if(isset($apiResult['records']['expiryDates'])){
            $expiryDate1 = $apiResult['records']['expiryDates'];
        }
        // Filter the option chain data to include only [PE] array
        $data = array_filter($optionChainData, function ($item) {
            return isset($item['PE']) && isset($item['CE']);
        });
        
        return view('frontend.finnifty', compact('data','expiryDate1'));
    } catch (\Exception $e) {
        // Log the exception
        error_log($e->getMessage());
        // Handle the exception if the API request fails
        return view('frontend.finnifty', ['data' => null]);
    }
}





public function optionChain()
    {
        $apiEndpoint = 'https://www.nseindia.com/api/option-chain-indices?symbol=FINNIFTY';
        //https://www.nseindia.com/api/quote-derivative?symbol=NIFTY

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
            $finniftyData = null; // Set the variable to null if the request fails
        }
    }











// News Details
    public function viewNews(Blog $blog)
    {
        return view('frontend.newsDetails', compact('blog'));
    }

}




//  Marketstack Option_chains Data - Paid Plan (Market Indices)

// public function nifty50()
// {
//     $apiEndpoint = 'https://api.marketstack.com/v1/eod/symbols/NSE:NIFTY50/option_chains';
//     $accessKey = 'a726603e54efab53c940dd64509e5916';

//     try {
//         // Initialize cURL session
//         $curl = curl_init();

//         // Set cURL options
//         curl_setopt($curl, CURLOPT_URL, $apiEndpoint . '?access_key=' . $accessKey); // Set the URL with access key
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response instead of printing it

//         // Execute the cURL request
//         $apiResult = curl_exec($curl);

//         // Check if the request was successful
//         if ($apiResult === false) {
//             throw new \Exception('cURL request failed: ' . curl_error($curl));
//         }

//         // Close the cURL session
//         curl_close($curl);

//         // Process the API result
//         $optionChainData = json_decode($apiResult, true);

//         // Pass the option chain data to the view
//         return view('frontend.nifty50', ['apiResult' => $optionChainData]);
//     } catch (\Exception $e) {
//         // Log the exception
//         error_log($e->getMessage());

//         // Handle the exception if the API request fails
//         return view('frontend.nifty50', ['apiResult' => null]);
//     }
// }
