<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('messages');
    }
    public function sendMessage(Request $request)
    {
        // Validate request if necessary

        $messageContent = $request->input('message');
        $recipientIds = $request->input('recipients');

        foreach ($recipientIds as $recipientId) {
            // Send message to each recipient
            $message = new Message();
            $message->user_id = auth()->id();
            $message->recipient_id = $recipientId;
            $message->message = $messageContent;
            $message->save();

            // Dispatch event to notify recipients
            broadcast(new NewChatMessage($message, $recipientId));
        }

        return response()->json(['status' => 'success']);
    }

    public function startConversation(Request $request)
    {
        // Validate request if necessary

        $messageContent = $request->input('message');
        $recipientEmail = $request->input('recipient_email');

        // Find recipient user by email
        $recipient = User::where('email', $recipientEmail)->first();

        if ($recipient) {
            // Save new message with recipient ID
            $message = new Message();
            $message->user_id = auth()->id();
            $message->recipient_id = $recipient->id;
            $message->message = $messageContent;
            $message->save();

            // Dispatch event to notify recipient
            broadcast(new NewChatMessage($message, $recipient->id));

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Recipient not found']);
        }
    }
    public function getMessages()
    {
        $userId = auth()->id();

        $messages = Message::with('user') // Eager load the user relationship
        ->where('recipient_id', $userId)
            ->get();

        return response()->json(['messages' => $messages]);
    }
}
