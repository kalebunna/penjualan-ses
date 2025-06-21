<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{
    protected $table = 'parameters';
    protected $fillable = ['alpha'];

    public function forcasting()
    {
        return $this->hasMany(ForcasResult::class);
    }
}
