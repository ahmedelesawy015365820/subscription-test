<?php

use App\Models\User;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $user = User::first();
    if (!$user) {
        echo "No user found in DB. Please seed the database.\n";
        exit;
    }

    Auth::setUser($user);
    
    $controller = app(App\Http\Controllers\PlanController::class);
    $response = $controller->index();
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Data: " . $response->getContent() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
