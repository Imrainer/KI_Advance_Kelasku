<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    protected $table = 'sekolah';
    protected $primaryKey= 'sekolah_id';
    protected $fillable = [
        'sekolah'
   
    ];

    public function user(){
        return $this->hasMany(User::class, "user_id");
     }

}
