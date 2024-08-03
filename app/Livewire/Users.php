<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public function message($userId)
    {
        $authenticationUserId = auth()->id();

        $existingConversation = Conversation::where(function ($query) use ($authenticationUserId, $userId) {
            $query->where('sender_id', $authenticationUserId)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($authenticationUserId, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $authenticationUserId);
        })->first();

        if ($existingConversation) {
            return redirect()->route('chat', ['query' => $existingConversation->id]);
        }

        // create conversation

        $createConversation = Conversation::create([
            'sender_id' => $authenticationUserId,
            'receiver_id' => $userId,
        ]);
        return redirect()->route('chat', ['query' => $createConversation->id]);
    }
    public function render()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('livewire.users', compact('users'));
    }
}
