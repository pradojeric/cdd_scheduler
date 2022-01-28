<?php

namespace App\Models\Configurations;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name'
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function courses()
    {
        return $this->hasMany(Course::class)->orderBy('name');
    }

    public function faculties()
    {
        return $this->hasMany(Faculty::class)->orderBy('last_name');
    }
}
