<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntopServiceCatalog extends Model
{
    protected $table = 'intop_service_catalogs';

    protected $fillable = [
        'service_type_id',
        'category',
        'service_name',
        'year',
    ];

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }
}
