<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvigilatorAllocations extends Model
{
    protected $table = "invigilator_allocations";
    protected $fillable = [
        'exam_id',
        'staff_id',
        'classroom_id',
    ];
     protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function get_exams_details()
    {
        return $this->belongsTo(Exams::class, 'exam_id', 'id');
    }
    public function get_staff()
    {
        return $this->belongsTo(Faculties::class, 'staff_id', 'id');
    }
    public function get_classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }
}
