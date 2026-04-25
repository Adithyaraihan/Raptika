<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SadajabarInstitutionCategory extends Model
{
    protected $table    = 'sadajabar_institution_categories';
    protected $fillable = ['name'];

    public function appIntegrations(): HasMany
    {
        return $this->hasMany(SadajabarAppIntegration::class, 'sadajabar_institution_categories_id');
    }
}
