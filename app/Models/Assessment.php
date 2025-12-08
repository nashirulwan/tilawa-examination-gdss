<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = ['appraiser_id', 'participant_id', 'criteria_id', 'sub_criteria_id', 'value'];

    public function appraiser()
    {
        return $this->belongsTo(User::class, 'appraiser_id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function subCriteria()
    {
        return $this->belongsTo(SubCriteria::class);
    }
}
