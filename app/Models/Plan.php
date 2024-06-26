<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $appends = [
        'image_url',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'name',
        'amount',
        'currency',
        'interval',
        'description',
        'limit_clients',
        'limit_suppliers',
        'limit_employees',
        'limit_domains',
        'limit_purchases',
        'limit_invoices',
        'features'
    ];

    public function getImageUrlAttribute()
    {
        return global_asset($this->image);
    }

    /**
     * The features that belong to the plan.
     */
    public function features(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Feature::class);
    }

    public function tenants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tenant::class)->whereNull('trial_ends_at');
    }
}
