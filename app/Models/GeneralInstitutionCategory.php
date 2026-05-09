<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GeneralInstitutionCategory extends Model
{
    protected $table    = 'general_institution_categories';
    protected $fillable = ['name'];

    public function appIntegrations(): HasMany
    {
        return $this->hasMany(SadajabarAppIntegration::class, 'general_institution_categories_id');
    }
}
