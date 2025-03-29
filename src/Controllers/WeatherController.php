<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class WeatherController
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = 'Your OpenWeather API key here';
    }

    public function getCurrentWeather(Request $request, Response $response, array $args)
    {
        $queryParams = $request->getQueryParams();
        $city = $queryParams['city'] ?? 'London'; // Default city if none provided

        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$this->apiKey}&units=metric";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $weatherData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            $response->getBody()->write(json_encode([
                'error' => 'Failed to fetch weather data',
                'status' => $httpCode
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($httpCode);
        }

        $data = json_decode($weatherData, true);
        
        $formattedResponse = [
            'city' => $data['name'],
            'country' => $data['sys']['country'],
            'temperature' => [
                'current' => $data['main']['temp'],
                'feels_like' => $data['main']['feels_like'],
                'min' => $data['main']['temp_min'],
                'max' => $data['main']['temp_max']
            ],
            'weather' => [
                'main' => $data['weather'][0]['main'],
                'description' => $data['weather'][0]['description']
            ],
            'wind' => [
                'speed' => $data['wind']['speed'],
                'degrees' => $data['wind']['deg']
            ],
            'humidity' => $data['main']['humidity'],
            'pressure' => $data['main']['pressure'],
            'timestamp' => date('Y-m-d H:i:s'),
            'timezone' => $data['timezone']
        ];

        $response->getBody()->write(json_encode($formattedResponse));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function getForecast(Request $request, Response $response, array $args)
    {
        $queryParams = $request->getQueryParams();
        $city = $queryParams['city'] ?? 'London'; // Default city if none provided

        $url = "https://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$this->apiKey}&units=metric";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $forecastData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            $response->getBody()->write(json_encode([
                'error' => 'Failed to fetch forecast data',
                'status' => $httpCode
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($httpCode);
        }

        $data = json_decode($forecastData, true);
        
        $formattedForecast = [
            'city' => $data['city']['name'],
            'country' => $data['city']['country'],
            'forecast' => array_map(function($item) {
                return [
                    'datetime' => $item['dt_txt'],
                    'temperature' => $item['main']['temp'],
                    'feels_like' => $item['main']['feels_like'],
                    'weather' => [
                        'main' => $item['weather'][0]['main'],
                        'description' => $item['weather'][0]['description']
                    ],
                    'wind_speed' => $item['wind']['speed'],
                    'humidity' => $item['main']['humidity']
                ];
            }, array_slice($data['list'], 0, 5)) // Get next 5 forecasts
        ];

        $response->getBody()->write(json_encode($formattedForecast));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}