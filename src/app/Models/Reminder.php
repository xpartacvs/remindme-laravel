<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'remind_at',
        'event_at'
    ];

    public static function listByRemindAt($limit=10)
    {
        return DB::table('reminders')->orderBy('remind_at')->take($limit)->get([
            'id',
            'title',
            'description',
            'remind_at',
            'event_at'
        ]);
    }
}
