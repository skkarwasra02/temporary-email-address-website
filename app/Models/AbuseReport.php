<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SentMail;

class AbuseReport extends Model
{
    const UPDATED_AT = null;

    public $fillable = ['against', 'message', 'block_all'];

    public function sentMail() {
        return $this->belongsTo(SentMail::class, 'against', 'id');
    }
}
