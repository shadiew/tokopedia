<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $guarded = [];
    public $timestamps = true;

    // Helper untuk ambil setting pertama (asumsi single row)
    public static function getSettings()
    {
        return self::first();
    }
} 