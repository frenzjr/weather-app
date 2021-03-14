<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VenuesController extends Controller
{
    /**
     * getVenues
     * @param Request $request
     *
     * @return json venues
     */
    public function getVenues(Request $request) {
        $request = Http::get('http://api.foursquare.com/v2/venues/search', [
            'client_id' => 'WVBFVP04NUIFTWTCUAXGHI01FSOJ3TIQZNG4YN3Q4P44CYBA',
            'client_secret' => '45BOOOQLYHSFFR4WEZE0N0IH3A3XU1PMRMIIX5M3HD5SCGLT',
            'v' => '20210313',
            'near' => $request->city
        ]);
        $venues = json_decode($request, true)['response']['venues'];
        $response = collect($venues)->map(function ($venue) {
            return [
                'name' => $venue['name'],
                'address' => implode(', ', $venue['location']['formattedAddress'])
            ];
        });

        return response($response);
    }
}
