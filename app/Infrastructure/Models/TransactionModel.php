<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    protected $table = "transactions";

    protected $primaryKey = 'id';
}
