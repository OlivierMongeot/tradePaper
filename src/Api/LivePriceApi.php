<?php

namespace App\Api;

use Doctrine\ORM\EntityManagerInterface;



class LivePriceApi
{

    public function __construct(EntityManagerInterface $entityManager, $user)
    {
        $this->entityManager = $entityManager;
        $this->user = $user;
    }


    public function getPrices(array $tokens)
    {
        // Get current user API KEY
        $apiKey = $this->user->getApiKey();

     
        // Serialise the array of tokens into a string
        $tokens = implode(',', $tokens);
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
        // $tokens = 'BTC,ETH,LTC';
        $parameters = [
            'convert' => 'USD',
            'symbol' => $tokens
        ];
        
        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: '.$apiKey
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers 
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new \Exception(curl_error($curl), curl_errno($curl));
        }

        curl_close($curl); // Close request
        
        return (json_decode($response));         
        
    }
}
