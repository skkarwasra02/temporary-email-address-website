<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronJob extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['cron_name', 'cron_schedule', 'last_execution', 'status'];
}
