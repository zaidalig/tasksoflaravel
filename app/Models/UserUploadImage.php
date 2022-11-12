<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUploadImage extends Model
{
    use HasFactory;
    protected $fillabels = ['images'];
    protected  $primaryKey = 'user_id';


    public function user()
    {
        return $this->belongsTo(User::class);
    }




}
