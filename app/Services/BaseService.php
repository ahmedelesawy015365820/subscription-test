<?php


namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BaseService
{

    protected function execute(callable $callback)
    {
        try {
            DB::beginTransaction();

            $result = $callback();

            DB::commit();

            return $result;
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            throw $e;
        }
    }

}
