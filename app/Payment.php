<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    public $table = 'payments';

    protected $dates = [
            'entry_date',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

    protected $fillable = [
        'job_name',
        'date',
        'check_number',
    ];

}
