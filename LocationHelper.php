<?php

//requires a revgeocode API on .env -> env('GEOREV_API')
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationHelper
{
    /**
     * Return a JSON with location details according to Here WeGo Map.
     *
     * @param  string $latitude
     * @param  string $longitude
     * @param  string $language
     * @return \Illuminate\Http\JsonResponse
     */
    private function heremap(string $language, string $latitude, string $longitude)
    {
        $data = Http::get('https://revgeocode.search.hereapi.com/v1/revgeocode?at='.$latitude.'%2C'.$longitude.'&apiKey='.env('GEOREV_API').'&lang='.$language)->json();
        if(!$data['items'] && $data['error']) { return null; } else {
            foreach( $data as $item) { return $item[0]['address'] ? $item[0]['address'] : null ;}
        }
    }

    /**
     * Return a JSON with location details according to Openstreetmap.
     *
     * @param  string $latitude
     * @param  string $longitude
     * @param  string $language
     * @return \Illuminate\Http\JsonResponse
     */
    private function openstreetmap(string $language, string $latitude, string $longitude)
    {
        $data = Http::get('https://nominatim.openstreetmap.org/reverse?format=json&lat='.$latitude.'&lon='.$longitude.'&accept-language='.$language)->json();
        return $data['address'];
    }

    /**
     * Return JSON from Geocodes Reverse process.
     *
     * @expects language, Latitude, longitude
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function GeoCommutator(Request $request)
    {
        $collection = collect();
        $data = $this->heremap($request->language,$request->latitude,$request->longitude);
        $collection->push(!$data == null ? $data : null);
        if($collection->isEmpty() || $collection[0] == null) {
            $dados = $collection->push($this->openstreetmap($request->language,$request->latitude,$request->longitude));
            $collection->push(!$dados == null ? $data : null);
            if($collection->isEmpty() || $collection[0] == null || $collection[1] == null || $collection[2] == null) {
                return response()->json($collection[1], '200');
            } else {
                return response()->json(['response' => 'Not found!'], '404');
            }
        } else {
            return response()->json($collection[0], '200');
        }
    }
}
