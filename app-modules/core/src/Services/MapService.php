<?php

namespace Modules\Core\Services;

use Modules\Core\Enums\StatusEnum;
use Modules\Core\Http\Resources\MapResource;
use Modules\Core\Models\Business;

class MapService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function businesses($rq)
    {
        $lat = $rq->query('lat', 40.7580);
        $lon = $rq->query('lon', -73.9855);
        $km = $rq->query('km', 10);
        $category = $rq->query('category', 0);

        $businesses = Business::with('promotion')
            // ->whereStatus(StatusEnum::APPROVED->value)
            ->whereHas('promotion', function ($q) use ($category) {
                if ($category != 0) {
                    $q->whereCategoryId($category);
                }
            })
            ->geofence($lat, $lon, 0, $km)
            ->get();

        return MapResource::collection($businesses);
    }
}
