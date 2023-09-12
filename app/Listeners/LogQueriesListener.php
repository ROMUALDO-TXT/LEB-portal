<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;

class LogQueriesListener
{
    public function handle(QueryExecuted $queryExecuted)
    {
        $sql = $queryExecuted->sql;
        $bindings = $queryExecuted->bindings;
        $time = $queryExecuted->time;

        // Aqui, você pode ajustar a formatação e o local de armazenamento do log conforme suas necessidades.
        dump('Query Executed:', [
            'sql' => $sql,
            'bindings' => $bindings,
            'time' => $time,
        ]);
    }
}
