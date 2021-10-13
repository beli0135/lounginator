<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected  $fillable = ['NTC_cdiUser','NTC_cdiPost','NTC_isRead','NTC_dssNotification'];
    
}
