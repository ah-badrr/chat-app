<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chat;
use App\Models\Membership;

class Group extends Model
{
    use HasFactory;

    protected $table = "group";

    public function chat()
    {
        return $this->hasMany(Chat::class, 'to', 'id');
    }

    public function membership()
    {
        return $this->hasMany(Membership::class, 'group_id', 'id');
    }
}
