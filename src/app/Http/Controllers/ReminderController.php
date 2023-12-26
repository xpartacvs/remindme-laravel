<?php

namespace App\Http\Controllers;

use App\Models\ResponseTemplate;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'remind_at' => 'required|integer',
            'event_at' => 'required|integer'
        ]);

        $newReminder = new Reminder([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'remind_at' => $validated['remind_at'],
            'event_at' => $validated['event_at']
        ]);

        if (! $newReminder->save()) {
            return response()->json(ResponseTemplate::err500(), 500);
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'id' => $newReminder->id,
                'title' => $newReminder->title,
                'description' => $newReminder->description,
                'remind_at' => $newReminder->remind_at,
                'event_at' => $newReminder->event_at,
            ]
        ]);
    }
}
