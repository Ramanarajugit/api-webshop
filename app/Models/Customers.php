<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'job_title',
        'email_address',
        'first_last_name',
        'registered_since',
        'phone'
    ];
}
