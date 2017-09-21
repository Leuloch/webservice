<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Counter
 * @package App\Models
 * @version September 21, 2017, 12:16 pm UTC
 */
class Counter extends Model
{
    use SoftDeletes;

    public $table = 'counters';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'qty',
        'ip_address',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'qty' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'qty' => 'required'
    ];

    
}
