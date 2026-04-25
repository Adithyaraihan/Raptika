<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RekayasaInstitutionCategory extends Model
{
    protected $table    = 'rekayasa_institution_categories';
    protected $fillable = ['name'];

    public function applicationReplications(): HasMany
    {
        return $this->hasMany(RekayasaApplicationReplication::class, 'rekayasa_institution_category_id');
    }
}
