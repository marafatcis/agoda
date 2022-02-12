<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\api;

use Illuminate\Support\Facades\Cache;
use function json_decode;
use function json_encode;
use function simplexml_load_string;

/**
 * Description of agoda connection
 *
 * @author arafat
 */
class agoda
{
    //put your code here
    public static function put_hotels_into_cache()
    {
         $domain ='http://affiliatefeed.agoda.com';
         $url = '/datafeeds/feed/getfeed';
        // this for the fast example but in real work not show api key here
         $apikey ='59e095c9-82fc-4f24-8a7a-ae2e41bbfe5c';
         $mcity_id = 23028;
         $olanguage_id = 40;
         $feed_id = 5;

        $url = $domain.$url.'?apikey='.$apikey.'&mcity_id='.$mcity_id.'&olanguage_id='.$olanguage_id.'&feed_id='.$feed_id;
        $client = new \GuzzleHttp\Client();
        $request = $client->get($url);
        $response = $request->getBody()->getContents();
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        Cache::put('hotels', $array);
    }



}
