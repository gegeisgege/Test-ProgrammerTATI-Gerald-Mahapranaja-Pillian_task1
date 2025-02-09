<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'description', 'status']; 

    // Relationship: Each log belongs to an employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}

