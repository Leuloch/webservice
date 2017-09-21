<?php

namespace App\Repositories;

use App\Models\Counter;
use InfyOm\Generator\Common\BaseRepository;

class CounterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'qty'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Counter::class;
    }
}
