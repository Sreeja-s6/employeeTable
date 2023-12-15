<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'gender',
        'dob',
        'address',
        'email',
        'phone',
        'department_id',
        'designation_id',
        'doj',
        //'image',
        // ...
    ];

    public function images()
    {
        return $this->hasMany(EmployeeImage::class);
    }

}
