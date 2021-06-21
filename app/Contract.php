<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    public $table = 'contracts';

    protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
];

    protected $fillable = [

        'name',
        'contact',
        'address',
        'city',
        'state',
        'zip',
        'phone',
        'billingcontact',
        'billingemail',
        'billingphone',
        'status_id',
        'created_by_id',
    ];

    public function site()
    {
        return $this->hasMany(Site::class, 'contract_id', 'id');
    }

    public function job()
    {
         return $this->hasMany(Job::class, 'contract_id', 'id');
    }

    public function status()
    {
          return $this->belongsTo(Status::class, 'status_id');
    }

    public function created_by()
    {
          return $this->belongsTo(User::class, 'created_by_id');
    }

}
