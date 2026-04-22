<?php

use App\Jobs\ProcessSubscriptions;
use App\Jobs\GenerateInvoicesJob;
use App\Jobs\RecognizeRevenueJob;
use Illuminate\Support\Facades\Schedule;

// trialing - past due
Schedule::job(new ProcessSubscriptions)->daily();

// Monthly invoice generation (1st of every month at 00:00)
Schedule::job(new GenerateInvoicesJob)->monthlyOn(1, '00:00');

// Monthly revenue recognition (end of every month at 23:59)
Schedule::job(new RecognizeRevenueJob)->lastDayOfMonth('23:59');

