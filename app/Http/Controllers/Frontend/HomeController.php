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

     public function index()
     {
         // $accessKey = 'a726603e54efab53c940dd64509e5916';
         // $symbol = 'AAPL';

         // $apiEndpoint = 'https://api.marketstack.com/v1/tickers/'.$symbol.'/eod'
         // $queryParams = [
         //     'access_key' => $accessKey
         // ];

         // try {
         //     $response = Http::get($apiEndpoint, $queryParams);
         //     $apiResult = $response->json();

         //     $apiData = [];
         //     if (isset($apiResult['data'])) {
         //         $apiData = $apiResult['data'];
         //     }
         // } catch (\Exception $e) {
         //     // Log the exception
         //     \Log::error($e->getMessage());
    
         //     // Handle the exception if the API request fails
         //     $apiData = null;
         // }

         return view('frontend.index');
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
