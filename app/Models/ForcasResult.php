<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForcasResult extends Model
{
    protected $table = 'forcas_result';
    protected $fillable = [
        'parameter_id',
        'MAD',
        'MSE',
        'MAP',
        'forcas_result',
        'err',
        'preode',
        'actual'
    ];

    public function parameter(){
        return $this->belongsTo(Parameters::class, 'parameter_id');
    }
}
