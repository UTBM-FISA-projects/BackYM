<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionServiceProvider extends ServiceProvider
{
    public function boot(Request $request)
    {
        /**
         * Macro de pagination pour une collection.
         *
         * @return \Illuminate\Pagination\LengthAwarePaginator
         */
        Collection::macro('paginate', function () use ($request) {
            $page = $request->query('page', 1);
            $perPage = $request->query('perPage', 15);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage)->values(),
                $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                ]
            );
        });
    }
}
