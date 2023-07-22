<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;

class HomeController extends Controller
{
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

    public function Nifty()
    {
        $apiEndpoint = 'https://www.nseindia.com/api/option-chain-indices?symbol=NIFTY';

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
            if (isset($apiResult['records']['expiryDates'])) {
                $expiryDate1 = $apiResult['records']['expiryDates'];
            }
            // Filter the option chain data to include only [PE] array
            $data = array_filter($optionChainData, function ($item) {
                return isset($item['PE']) && isset($item['CE']);
            });

            return view('frontend.nifty', compact('data', 'expiryDate1'));
        } catch (\Exception $e) {
            // Log the exception
            error_log($e->getMessage());
            // Handle the exception if the API request fails
            return view('frontend.nifty', ['data' => null]);
        }
    }

    public function BankNifty()
    {
        $apiEndpoint = 'http://nimblerest.lisuns.com:4531/GetLastQuoteOptionChain/?accessKey=988dcf72-de6b-4637-9af7-fddbe9bfa7cd&exchange=NFO&product=BANKNIFTY';

        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $apiEndpoint); // Set the URL
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response instead of printing it
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (not recommended in production)

            // Execute the cURL request
            $apiResult = curl_exec($curl);
            curl_close($curl);

            // Convert the JSON response to an associative array
            $apiResult = json_decode($apiResult, true);
            $putArr = [];
            $callArr = [];

            foreach ($apiResult as $key => $result) {
                $identi = explode('_', $result['INSTRUMENTIDENTIFIER']);

                if ($identi[3] == 'CE') {
                    array_push($callArr, $result);
                } elseif ($identi[3] == 'PE') {
                    array_push($putArr, $result);
                }
            }

            // Extract the desired value from the INSTRUMENTIDENTIFIER
            $putArr = array_map(function ($item) {
                $identi = explode('_', $item['INSTRUMENTIDENTIFIER']);
                $item['value'] = end($identi);
                return $item;
            }, $putArr);

            $callArr = array_map(function ($item) {
                $identi = explode('_', $item['INSTRUMENTIDENTIFIER']);
                $item['value'] = end($identi);
                return $item;
            }, $callArr);

            return view('frontend.banknifty', compact('putArr', 'callArr'));
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return view('frontend.banknifty', ['data' => null]);
        }
    }

    public function FinNifty()
    {
        $apiEndpoint = 'http://nimblerest.lisuns.com:4531/GetLastQuoteOptionChain/?accessKey=988dcf72-de6b-4637-9af7-fddbe9bfa7cd&exchange=NFO&product=FINNIFTY';
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $apiEndpoint); // Set the URL
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response instead of printing it
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (not recommended in production)

            // Execute the cURL request
            $apiResult = curl_exec($curl);
            curl_close($curl);

            // Convert the JSON response to an associative array
            $apiResult = json_decode($apiResult, true);
            $putArr = [];
            $callArr = [];

            foreach ($apiResult as $key => $result) {
                $identi = explode('_', $result['INSTRUMENTIDENTIFIER']);

                if ($identi[3] == 'CE') {
                    array_push($callArr, $result);
                } elseif ($identi[3] == 'PE') {
                    array_push($putArr, $result);
                }
            }

            // Extract the desired value from the INSTRUMENTIDENTIFIER
            $putArr = array_map(function ($item) {
                $identi = explode('_', $item['INSTRUMENTIDENTIFIER']);
                $item['value'] = end($identi);
                return $item;
            }, $putArr);

            $callArr = array_map(function ($item) {
                $identi = explode('_', $item['INSTRUMENTIDENTIFIER']);
                $item['value'] = end($identi);
                return $item;
            }, $callArr);

            return view('frontend.finnifty', compact('putArr', 'callArr'));
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return view('frontend.finnifty', ['data' => null]);
        }
    }

    public function NiftItSectoral()
    {
        // Set the endpoint URL
        $url = 'https://www.nseindia.com/api/equity-stockIndices?index=NIFTY%20AUTO';

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        // Set headers to mimic a web browser request
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36']);

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            // Handle the error accordingly
            curl_close($ch);
            return 'cURL Error: ' . $error;
        }

        // Close cURL session
        curl_close($ch);

        // Process the response
        $data = json_decode($response, true);

        // Pass the data to the view
        return view('frontend.niftItSectoral')->with('data', $data);
    }

    // News Details
    public function viewNews(Blog $blog)
    {
        return view('frontend.newsDetails', compact('blog'));
    }

    // 3  Marketstack Option_chains Data - Paid Plan (Market Indices) In Add New Key For Testing

    public function optionChain()
    {
        $apiEndpoint = 'http://test.lisuns.com:4531/GetInstruments/';

        $accessKey = '71d17196-a2cd-4fe2-b494-ff9c44ab2f18';
        $exchange = 'NFO';

        try {
            // Create a new Guzzle HTTP client
            $client = new Client();

            // Send the API request
            $response = $client->get($apiEndpoint, [
                'query' => [
                    'accessKey' => $accessKey,
                    'exchange' => $exchange,
                ],
            ]);

            // Get the response body as a string
            $responseBody = $response->getBody()->getContents();

            // Process the API response
            $optionChainData = json_decode($responseBody, true);

            // Display the option chain data
            echo '<pre>';
            print_r($optionChainData);
            echo '</pre>';
        } catch (\Exception $e) {
            // Log the exception
            error_log($e->getMessage());

            // Handle the exception if the API request fails
            echo 'API request failed: ' . $e->getMessage();
        }
    }
}

// ----------------------------------------------------------------------------------------------------------------------------------------NSE API (FINNIFTY)
// public function FinNifty()
// {
//     $apiEndpoint = 'https://www.nseindia.com/api/option-chain-indices?symbol=FINNIFTY';

//     try {
//         // Initialize cURL session
//         $curl = curl_init();

//         // Set cURL options
//         curl_setopt($curl, CURLOPT_URL, $apiEndpoint); // Set the URL
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response instead of printing it
//         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (not recommended in production)

//         // Execute the cURL request
//         $apiResult = curl_exec($curl);

//         // Check if the request was successful
//         if ($apiResult === false) {
//             throw new \Exception('cURL request failed: ' . curl_error($curl));
//         }

//         // Close the cURL session
//         curl_close($curl);

//         // Convert the JSON response to an associative array
//         $apiResult = json_decode($apiResult, true);

//         // Process the option chain data
//         $optionChainData = [];
//         if (isset($apiResult['records']['data'])) {
//             $optionChainData = $apiResult['records']['data'];
//         }
//         $expiryDate1 = [];
//         if (isset($apiResult['records']['expiryDates'])) {
//             $expiryDate1 = $apiResult['records']['expiryDates'];
//         }
//         // Filter the option chain data to include only [PE] array
//         $data = array_filter($optionChainData, function ($item) {
//             return isset($item['PE']) && isset($item['CE']);
//         });

//         return view('frontend.finnifty', compact('data', 'expiryDate1'));
//     } catch (\Exception $e) {
//         // Log the exception
//         error_log($e->getMessage());
//         // Handle the exception if the API request fails
//         return view('frontend.finnifty', ['data' => null]);
//     }
// }

//  1.  ------------------------------------------------------------------------------------------------------------------- Pehle Wala Code

// public function optionChain()
// {
//     $apiEndpoint = 'https://www.nseindia.com/api/option-chain-indices?symbol=FINNIFTY';
//     //https://www.nseindia.com/api/quote-derivative?symbol=NIFTY

//     try {
//         // Initialize cURL session
//         $curl = curl_init();

//         // Set cURL options
//         curl_setopt($curl, CURLOPT_URL, $apiEndpoint); // Set the URL
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response instead of printing it
//         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (not recommended in production)

//         // Execute the cURL request
//         $apiResult = curl_exec($curl);

//         // Check if the request was successful
//         if ($apiResult === false) {
//             throw new \Exception('cURL request failed: ' . curl_error($curl));
//         }

//         // Close the cURL session
//         curl_close($curl);

//         // Convert the JSON response to an associative array
//         $apiResult = json_decode($apiResult, true);

//         echo '<pre>';
//         print_r($apiResult); // Print the API result for debugging purposes
//         die(); // Stop further execution of the script
//     } catch (\Exception $e) {
//         // Log the exception
//         error_log($e->getMessage());
//         print_r($e->getMessage());
//         die();
//         // Handle the exception if the API request fails
//         $finniftyData = null; // Set the variable to null if the request fails
//     }
// }
