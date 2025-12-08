<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department', 'gender', 'student_id', 'period_id', 'is_active'];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
