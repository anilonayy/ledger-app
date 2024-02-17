<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name','abilities'];

    /**
     * @param $value
     * @return void
     */
    public function setAbilitiesAttribute($value)
    {
        $this->attributes['abilities'] = json_encode($value);
    }

    /**
     * @param $value
     * @return array|string
     */
    public function getAbilitiesAttribute($value): array|string
    {
        return json_decode($value);
    }
}
