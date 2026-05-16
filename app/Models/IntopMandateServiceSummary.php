<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntopMandateServiceSummary extends Model
{
    protected $table = 'intop_mandate_service_summaries';

    protected $fillable = [
        'month',
        'year',
        'category',
        'service_name',
    ];

    protected $casts = [
        'month' => 'integer',
        'year'  => 'integer',
    ];

    // Scope: filter by category
    public function scopeAdministrasi($query)
    {
        return $query->where('category', 'administrasi');
    }

    public function scopePublik($query)
    {
        return $query->where('category', 'publik');
    }

    // Scope: filter by year
    public function scopeByYear($query, int $year)
    {
        return $query->where('year', $year);
    }

    // Scope: filter by month
    public function scopeByMonth($query, int $month)
    {
        return $query->where('month', $month);
    }
}
