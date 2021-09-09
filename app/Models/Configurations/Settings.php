<?php

namespace App\Models\Configurations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'school_year', 'term'
    ];

    public function getSchoolYearAttribute()
    {
        $school_year = $this->attributes['school_year'];
        preg_match_all('/\d+/', $school_year, $matches);
        return $matches[0];
    }


    public function getCurrentSchoolYearAttribute()
    {
        $term = '';
        switch($this->term){
            case 1:
                $term = 'First Semester';
                break;
            case 2:
                $term = 'Second Semester';
                break;
            case 3:
                $term = 'Summer';
                break;
            default: break;
        }

        return "{$this->getRawOriginal('school_year')}, {$term}";
    }
}
