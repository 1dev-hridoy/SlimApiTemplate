<?php
use App\Controllers\HelloController;
use App\Controllers\WeatherController;
use App\Controllers\QRCodeController;

// Hello World route
$app->get('/api/hello', [HelloController::class, 'hello']);

// Weather routes
$app->get('/api/weather', [WeatherController::class, 'getCurrentWeather']);
$app->get('/api/weather/forecast', [WeatherController::class, 'getForecast']);

// QR Code routes
$app->get('/api/qr/generate', [QRCodeController::class, 'generate']);
$app->get('/api/qr/base64', [QRCodeController::class, 'generateBase64']);