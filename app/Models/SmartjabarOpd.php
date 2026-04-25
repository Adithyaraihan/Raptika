<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmartjabarOpd extends Model
{
    protected $table    = 'smartjabar_opd';
    protected $fillable = ['name'];

    public function usageStats(): HasMany
    {
        return $this->hasMany(SmartjabarUsageStat::class, 'opd_id');
    }
}
