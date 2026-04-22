<?php

use App\Models\User;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Case 1: Simulate a request without Accept: application/json (e.g., Browser)
$request1 = Request::create('/api/plans', 'GET');
$response1 = $kernel->handle($request1);
echo "Case 1 (Browser): Status " . $response1->getStatusCode() . "\n";
if ($response1->isRedirection()) {
    echo "Redirecting to: " . $response1->headers->get('Location') . "\n";
}

// Case 2: Simulate a request with Accept: application/json (e.g., Postman/SPA)
$request2 = Request::create('/api/plans', 'GET');
$request2->headers->set('Accept', 'application/json');
$response2 = $kernel->handle($request2);
echo "Case 2 (API): Status " . $response2->getStatusCode() . " - " . $response2->getContent() . "\n";
