<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Contact extends Model
{
    use HasFactory;

    protected $table = "contact";

    protected $fillable = [
        'maker',
        'receiver'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'maker', 'id');
    }

    public function rec()
    {
        return $this->belongsTo(User::class, 'receiver', 'id');
    }
}
