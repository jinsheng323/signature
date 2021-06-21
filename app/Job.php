<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    public $table = 'jobs';

    protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
    ];

    protected $fillable = [
        'name',
        'contract_id',
        'site_id',
        'status',
        'signpath',
        
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function site()
    {
    return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

}
