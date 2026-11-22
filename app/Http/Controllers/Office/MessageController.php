<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('office.messages.index', [
            'conversations' => $this->threads(),
            'current' => null,
        ]);
    }

    public function show(Conversation $conversation)
    {
        $conversation->update(['office_read_at' => now()]);

        return view('office.messages.index', [
            'conversations' => $this->threads(),
            'current' => $conversation->load('messages', 'user.referrals'),
        ]);
    }

    public function reply(Request $request, Conversation $conversation)
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:4000']]);

        $conversation->messages()->create([
            'sender' => 'office',
            'sender_id' => $request->user()->id,
            'body' => $data['body'],
        ]);
        $conversation->update(['last_office_message_at' => now(), 'office_read_at' => now()]);

        return redirect()->route('office.messages.show', $conversation);
    }

    private function threads()
    {
        return Conversation::with(['user', 'messages'])
            ->has('messages')
            ->get()
            ->sortByDesc(fn ($c) => $c->lastActivity());
    }
}
