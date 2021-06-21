<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicecost extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    public $table = 'servicecosts';

    protected $dates = [
    'entry_date',
    'created_at',
    'updated_at',
    'deleted_at',
];


    protected $fillable = [
        'site_id',
        'service_id',
        'cost',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

      public function service()
      {
          return $this->belongsTo(Service::class, 'service_id');
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
