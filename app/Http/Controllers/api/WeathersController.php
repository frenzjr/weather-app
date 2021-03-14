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
        $weatherRequest = Http::get('http://api.openweathermap.org/data/2.5/forecast', [
            'q' => $request->city,
            'appid' => '692ca3a8d66b135800f9b829000c613a',
            'lang' => 'en'
        ]);
        $weather = null;
        $weatherRequest = json_decode($weatherRequest, true);

        if ($weatherRequest['cod'] == 200) {
            $weather = $weatherRequest['list'][0]['weather'][0];
            $weather['icon_path'] = 'http://openweathermap.org/img/wn/' . $weather['icon'] . '@2x.png';
            $weather['is_day'] = (bool)strpos($weather['icon'], 'd');
            $weather['description'] =ucwords($weather['description']);
        }

        return response($weather);
    }
}
