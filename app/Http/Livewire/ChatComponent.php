<?php

namespace App\Http\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class ChatComponent extends Component
{
    public $selectedUser;
    public $message, $chat_user_id, $unreadedMessages, $search, $group_id, $paginate_var = 5;

    protected $listeners = ['selectedUser', 'selected_group', 'loadMore'];

    public function resetField()
    {
        $this->message = '';
    }

    // selected user
    public function selectedUser($userId)
    {
        $this->chat_user_id = $userId;
        $this->selectedUser = User::find($userId);

        // number of messages Iwant to show
        $this->paginate_var = 5;
        // scrollng to bottom
        $this->emit('scroll');
        $this->resetErrorBag('message');
    }

    // Load more then 10 messaeges by scrolling to top
    public function loadMore()
    {
        $this->paginate_var = $this->paginate_var + 10;
        $this->emit('load');
    }

    // sending messages
    public function send()
    {
        if ($this->chat_user_id) {

            // My id
            $senderUserId = auth()->user()->id;

            // select the user I want to chat with
            $receiverUserId = $this->chat_user_id;


            $existConversationMessages = Conversation::where(function ($query) use ($senderUserId, $receiverUserId) {
                $query->where('sender_id', $senderUserId);
                $query->orWhere('sender_id', $receiverUserId);
            })
                ->where(function ($query) use ($senderUserId, $receiverUserId) {
                    $query->where('receiver_id', $senderUserId);
                    $query->orWhere('receiver_id', $receiverUserId);
                })
                ->first();

            $existConversation = Conversation::where('sender_id', $senderUserId)
                ->where('receiver_id', $receiverUserId)
                ->first();

            if (empty($existConversation)) {
                //---
                $conversation = new Conversation();
                $conversation->sender_id = auth()->user()->id;
                $conversation->receiver_id = $this->chat_user_id;
                $conversation->save();
            }

            // //---
            // $conversation = new Conversation();
            // if ($existConversationMessages) {
            //     $conversation->id = $existConversationMessages->id;
            //     $conversation->exists = true;
            // }
            // // $message->body = $this->message;
            // $conversation->sender_id = auth()->user()->id;
            // $conversation->receiver_id = $this->chat_user_id;
            // $conversation->save();

            $message = new Message();
            $message->conversation_id = isset($existConversation) ? $existConversation->id : $conversation->id;
            $message->user_id = auth()->user()->id;
            $message->body = $this->message;
            $message->save();

            $this->resetField();
        } else {
            $this->addError('message', 'Please before selecte user.');
        }



        //--

        //----------------------------Conversation------------------------
        //check if there is an old conversation between us
        // $conv_old = \App\Conversation::where('first_user', $message->from_user)
        //     ->where('second_user', $message->to_user)
        //     ->orWhere('first_user', $message->to_user)
        //     ->where('second_user', $message->from_user)
        //     ->get()->first();
        // // if there is an old convesation  between as , just link it to this message
        // if ($conv_old) {
        //     $conversation = \App\Conversation::find($conv_old->id);
        //     $conversation->last_message_time = $message->created_at;
        //     $conversation->save();
        //     $message->conversation_id = $conv_old->id;
        //     $message->save();
        // }
        // // else create a conversation and store our ids in it
        // else {
        //     $conversation = new \App\Conversation;
        //     $conversation->first_user = $message->from_user;
        //     $conversation->second_user = $message->to_user;
        //     $conversation->last_message_time = $message->created_at;
        //     $conversation->save();
        //     $message->conversation_id = $conversation->id;
        //     $message->save();
        // }
        // //---------------------------- End Conversation------------------------
        // // -------------------------------Event-----------------
        // //get Unreaded messages
        // $recivedUnreadedMessages = Message::where('statu', 'unreaded')
        //     ->where('from_user', Auth::user()->id)
        //     ->where('to_user', $this->chat_id)
        //     ->count();
        // $this->message = '';
        // $chat_user = User::find($this->chat_id);
        // //sending event with message content and the user Isend it to , and the numb of the Unreaded Messages
        // event(new \App\Events\Chat($this->chat_id, $message, $recivedUnreadedMessages, $chat_user));
    }

    public function render()
    {
        // My id
        $senderUserId = auth()->user()->id;

        // select the user I want to chat with
        $receiverUserId = $this->chat_user_id;

        //------- Haldeling Messages between me and the selected user


        // counting
        $messagesCount = Conversation::with('messages')->whereHas('messages')
            ->where('sender_id', $senderUserId)
            ->where('receiver_id', $receiverUserId)
            ->orWhere(function ($query) use ($senderUserId, $receiverUserId) {
                $query->where('sender_id', $senderUserId);
                $query->where('receiver_id', $receiverUserId);
            })
            ->count();

        // showing a special numer of messages firstly , then I can show more by scrolling to top
        $conversationIds = [];
        $conversationIds = Conversation::with('messages')->whereHas('messages')
            ->where(function ($query) use ($senderUserId, $receiverUserId) {
                $query->where('sender_id', $senderUserId);
                $query->orWhere('sender_id', $receiverUserId);
            })
            ->where(function ($query) use ($senderUserId, $receiverUserId) {
                $query->where('receiver_id', $senderUserId);
                $query->orWhere('receiver_id', $receiverUserId);
            })
            ->pluck('id')->toArray();

        $messages = Message::whereIn('conversation_id', $conversationIds)
            ->skip($messagesCount - $this->paginate_var)
            ->take($this->paginate_var)
            ->get();



        // // showing Recent conversations I have
        // $conversations = \App\Conversation::where('first_user', Auth::user()->id)
        //     ->orWhere('second_user', Auth::user()->id)
        //     ->orderBy('last_message_time', 'desc')
        //     ->get();



        $conversations = Conversation::with(['messages', 'sender',  'receiver'])
            ->where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();

        $users = User::where('id', '!=', auth()->user()->id)->get();

        return view('livewire.chat-component', compact('conversations', 'users', 'messages'));
    }
}
