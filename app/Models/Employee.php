<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * Get the company name.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the company name.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'contact',
        'department_id',
        'designation',
        'email',
        'employee_number',
        'name',
    ];
}
