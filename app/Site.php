<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    public $table = 'sites';

    protected $dates = [
            'entry_date',
            'created_at',
            'updated_at',
            'deleted_at',
        ];


    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'zip',
        'phone',
        'contract_id',
        'sitecontact',
        'notes',
        'created_by_id',
        'tax_rate',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function servicecost()
    {
    return $this->hasMany(Servicecost::class, 'site_id', 'id');
    }



    public function job()
    {
    return $this->hasMany(Job::class, 'site_id', 'id');
    }

    public function getEntryDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEntryDateAttribute($value)
    {
        $this->attributes['entry_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

}
