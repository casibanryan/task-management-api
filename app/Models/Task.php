<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;
      protected $fillable = [
        'title',
        'description',
        'due_date',
        'user_id'
    ];


    protected $casts = [
        'created_at' => 'datetime:F d, Y'
    ];
    protected $hidden = [
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}