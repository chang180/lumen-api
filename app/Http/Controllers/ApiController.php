<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function fetchData()
    {
        $apiKey = env('WEATHER_API_KEY'); // 從環境變數中獲取 API 密鑰
        $apiUrl = 'https://opendata.cwa.gov.tw/api/v1/rest/datastore/O-A0003-001';

        $params = array(
            'Authorization' => $apiKey,
        );

        $url = $apiUrl . '?' . http_build_query($params);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        } else {
            return response($response, 200)->header('Content-Type', 'application/json');
        }

        curl_close($ch);
    }
}
