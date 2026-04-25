<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SadajabarAppIntegration extends Model
{
    protected $table    = 'sadajabar_app_integrations';
    protected $fillable = [
        'month',
        'year',
        'app_count',
        'service_type_id',
        'sadajabar_institution_categories_id',
    ];

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function institutionCategory(): BelongsTo
    {
        return $this->belongsTo(SadajabarInstitutionCategory::class, 'sadajabar_institution_categories_id');
    }
}
