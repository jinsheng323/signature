<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inv extends Model
{
    use SoftDeletes;

    public $table = 'invs';

    protected $dates = [
            'entry_date',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

    protected $fillable = [
        'inv_id',
    ];

}
