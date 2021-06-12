<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Completed extends Model
{

    public $table = "completed_tasks";

    protected $fillable = [
        'user_id', 'title', 'priority', 'status', 'completed_at'
     ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}