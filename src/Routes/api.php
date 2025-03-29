<?php
use App\Controllers\HelloController;

// Define routes
$app->get('/api/hello', [HelloController::class, 'hello']);