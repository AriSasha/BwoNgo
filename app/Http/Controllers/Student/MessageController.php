<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $conversation = $user->conversation;
        $conversation?->update(['student_read_at' => now()]);

        return view('student.messages', [
            'alias' => $user->alias(),
            'messages' => $conversation?->messages ?? collect(),
            'settings' => Setting::values(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:4000']]);
        $user = $request->user();

        $conversation = $user->conversation()->firstOrCreate([]);
        $conversation->messages()->create([
            'sender' => 'student',
            'sender_id' => $user->id,
            'body' => $data['body'],
        ]);
        $conversation->update(['last_student_message_at' => now(), 'student_read_at' => now()]);

        return redirect()->route('student.messages');
    }
}
