<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

    public $table = 'status';

    protected $dates = [
            'entry_date',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

    protected $fillable = [
        'name',
    ];

    public function contract()
    {
        return $this->hasMany(Contract::class, 'status_id', 'id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'status_id');
    }



}
