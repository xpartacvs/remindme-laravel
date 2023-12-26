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

    public function list(Request $request)
    {
        $request->validate([
            'limit' => 'integer|gte:1|lte:10'
        ]);

        $limit = $request->input('limit',10);
        $reminders = Reminder::listByRemindAt($limit);

        return response()->json([
            'ok' => true,
            'data' => [
                'reminders' => $reminders,
                'limit' => $limit
            ]
        ]);
    }

    public function detail(Request $request, $id)
    {
        return response()->json([
            'ok' => true,
            'data' => Reminder::findById($id)
        ]);
    }

    public function delete(Request $request, $id)
    {
        $reminder = Reminder::find($id);
        if (is_null($reminder)) {
            return response()->json(ResponseTemplate::err404(), 404);
        }

        return response()->json([
            'ok' => $reminder->delete(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'string',
            'description' => 'string',
            'remind_at' => 'integer',
            'event_at' => 'integer'
        ]);

        $reminder = Reminder::find($id);
        if (is_null($reminder)) {
            return response()->json(ResponseTemplate::err404(), 404);
        }

        foreach ($validated as $key => $value) {
            $reminder->{$key} = $value;
        }

        if (! $reminder->save()) {
            return response()->json(ResponseTemplate::err500(), 500);
        }

        return $this->detail($request, $id);
    }
}
