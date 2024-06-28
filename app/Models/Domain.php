<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    public function ads(){
//        return $this->hasMany(Ad::class)
    }

    public function approvedAds(){
//return $this->hasMany(Ad::class)->where('status', AdStatus::APPROVED);
    }

    public function activities(){
//        return $this->hasMany(Activity::class);
    }
    public function approvedActivities(){
//        return $this->hasMany(Activity::class)->where('status',ActivityStatus::APPROVED)
    }
}
