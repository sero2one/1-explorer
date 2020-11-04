<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees\Concerns;

use App\Models\Transaction;
use App\Services\Timestamp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait HasQueries
{
    private function dateRangeQuery(Carbon $start, Carbon $end): Builder
    {
        return Transaction::query()->whereBetween('timestamp', [
            Timestamp::fromUnix($start->unix())->unix(),
            Timestamp::fromUnix($end->unix())->unix(),
        ]);
    }
}