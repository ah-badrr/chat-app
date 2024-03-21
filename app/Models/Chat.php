<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\User;

class Chat extends Model
{
    use HasFactory;

    protected $table = "chat";

    public function suser()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function ruser()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'to', 'id');
    }
}
