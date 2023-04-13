<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Notifikasi extends Model
{
    protected $table = 'notifications';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];


}
