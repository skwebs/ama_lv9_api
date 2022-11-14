<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StuParent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'father_name',
        'father_contact',
        'father_contact_2',
        'father_whatsapp',
        'father_email',
        'father_qualification',
        'father_occupation',
        'father_annual_income',
        'father_photo',

        'mother_name',
        'mother_contact',
        'mother_contact_2',
        'mother_whatsapp',
        'mother_email',
        'mother_qualification',
        'mother_occupation',
        'mother_annual_income',
        'mother_photo',

        'created_by',
        'updated_by',
        'deleted_by',
    ];
}

       