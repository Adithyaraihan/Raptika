<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceType extends Model
{
    protected $fillable = ['name'];

    public function sadajabarEncryptionStats(): HasMany
    {
        return $this->hasMany(SadajabarEncryptionStat::class);
    }

    public function sadajabarAppIntegrations(): HasMany
    {
        return $this->hasMany(SadajabarAppIntegration::class);
    }

    public function rekayasaApplicationReplications(): HasMany
    {
        return $this->hasMany(RekayasaApplicationReplication::class);
    }

    public function rekayasaMentoringPerformances(): HasMany
    {
        return $this->hasMany(RekayasaMentoringPerformance::class);
    }

    public function smartjabarJoinedApps(): HasMany
    {
        return $this->hasMany(SmartjabarJoinedApp::class);
    }

    public function smartjabarUsageStats(): HasMany
    {
        return $this->hasMany(SmartjabarUsageStat::class);
    }
}
