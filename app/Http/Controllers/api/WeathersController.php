<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeathersController extends Controller
{
    /**
     * getWeather for getting weather forecast
     * @param Request $request
     *
     * @return json response
     */
    public function getWeather(Request $request) {
        $request = Http::get('http://api.openweathermap.org/data/2.5/forecast', [
            'q' => $request->city,
            'appid' => '692ca3a8d66b135800f9b829000c613a'
        ]);
        $weather = json_decode($request, true)['list'][0]['weather'][0];

        return response($weather);
    }
}
