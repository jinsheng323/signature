<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    public $table = 'services';

    protected $dates = [
      'created_at',
      'updated_at',
      'deleted_at',
  ];


    protected $fillable = [
        'name',
        'description',
    ];

    public function servicecost()
    {
        return $this->hasMany(Servicecost::class, 'service_id', 'id');
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

}
