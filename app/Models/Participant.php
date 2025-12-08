<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['period_id', 'name', 'student_id', 'gender'];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
