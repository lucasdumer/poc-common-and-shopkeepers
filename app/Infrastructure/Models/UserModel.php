<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = "users";

    protected $primaryKey = 'id';
}
