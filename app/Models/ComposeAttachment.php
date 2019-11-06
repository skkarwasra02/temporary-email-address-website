<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComposeAttachment extends Model
{
    const UPDATED_AT = null;

    public $fillable = ['compose_token', 'file_name', 'ip', 'path', 'size'];
}
