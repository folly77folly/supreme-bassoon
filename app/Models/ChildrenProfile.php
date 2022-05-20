<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ChildrenProfile extends Model
{
    use HasFactory;
    protected $guarded =[];

    protected $fillable = [
        'user_id',
        'full_name',
        'gender_id',
        'age',
        'phone_number'
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
