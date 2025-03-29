<?php
use App\Controllers\HelloController;
use App\Controllers\WeatherController;

// Hello World route
$app->get('/api/hello', [HelloController::class, 'hello']);

// Weather routes
$app->get('/api/weather', [WeatherController::class, 'getCurrentWeather']);
$app->get('/api/weather/forecast', [WeatherController::class, 'getForecast']);