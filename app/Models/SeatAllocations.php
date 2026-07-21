<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatAllocations extends Model
{
    protected $table = "seat_allocations";
    protected $fillable = [
        'exam_id',
        'student_id',
        'classroom_id',
        'seat_no',
        'row_no',

    ];

     protected $hidden = [
        'created_at',
        'updated_at',
    ];

     public function get_exams_details()
    {
        return $this->belongsTo(Exams::class, 'exam_id', 'id');
    }
     public function get_student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

       public function get_classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }

}
