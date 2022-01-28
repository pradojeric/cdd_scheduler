<?php

namespace App\Models\Configurations;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public static function getSettings()
    {
        return Cache::rememberForever('settings.all', function() {
            return self::first();
        });
    }

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('settings.all');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updated(function () {
            self::flushCache();
        });

    }
}
