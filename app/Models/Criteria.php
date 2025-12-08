<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'criteria';

    protected $fillable = ['code', 'name', 'weight', 'normalization_weight'];

    public function subCriteria()
    {
        return $this->hasMany(SubCriteria::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
