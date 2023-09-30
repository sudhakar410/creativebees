<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employee';
    public $timestamps = false;
    protected $primaryKey = 'id';
	//protected $fillable = ['employee_id']; // Add other fields as needed
	protected $fillable = [
		'employee_id',
        'firstname',
        'lastname',
        'date_of_birth',
        'education_qualification',
        'address',
        'email',
        'phone',
        'photo',
        'resume',
    ];

}
