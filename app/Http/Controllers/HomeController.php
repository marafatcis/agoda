<?php

namespace App\Http\Controllers;


use App\api\agoda;
use App\Http\Resources\HotelsCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use function implode;
use function is_array;
use function request;
use function strpos;

class HomeController extends Controller
{

    public function index(Request $request)
    {
//        Cache::forget('hotels');
        if (Cache::has('hotels')==false){
           agoda::put_hotels_into_cache();
        }

        $hotels =  Cache::get('hotels');

        $hotels_collection = HotelsCollection::collection($hotels['hotels']['hotel']);

        //filters

        if (request('name')) {
            $hotels_collection = $hotels_collection->filter(function ($item) {
                $hotel_name = is_array($item['hotel_name']) ? implode('|', $item['hotel_name']) : $item['hotel_name'];

                $hotel_name_translated = is_array($item['translated_name']) ? implode('|', $item['translated_name']) : $item['translated_name'];

                return false !==
                    strpos($hotel_name, request('name')) || strpos($hotel_name_translated, request('name'));
            });
        }

        if (request('latitude'))
            $hotels_collection = $hotels_collection->where('latitude', request('latitude'));

        if (request('longitude'))
            $hotels_collection = $hotels_collection->where('longitude', request('longitude'));

        if (request('id'))
            $hotels_collection = $hotels_collection->where('hotel_id', request('id'));

        return $hotels_collection;
    }




}
