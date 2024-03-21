<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\URL;
// use Illuminate\Routing\Redirector\URL;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $id)
    {
        $contact = Contact::where('maker', '=', Auth::user()->id)
    ->get();
        $chat = Chat::all()->where('from', '=', Auth::user()->id, '&&', 'to', '=', $id);
        return view('contact.index',compact('chat','contact'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $chat = new Chat;
        $chat->from = Auth::user()->id;
        $chat->to = $id;
        $chat->messages = $request->message;
        $chat->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $chat = Chat::all()->where('from', '=', Auth::user()->id, 'to', '=', $id);
        $contacts = Contact::where('maker', '=', Auth::user()->id)
    ->get();
        $contact = User::find($id);
        $chat = Chat::where('from', '=', Auth::user()->id)
        ->where('to', '=', $id)
        ->where('status','=','a')
        ->orWhere('from', '=', Auth::user()->id)
        ->where('to', '=', $id)
        ->where('status','=','s')
        ->orWhere('from', '=', $id)
        ->where('status','=','a')
        ->where('to', '=', Auth::user()->id)
        ->orWhere('from', '=', $id)
        ->where('status','=','r')
        ->where('to', '=', Auth::user()->id)
        ->orderBy('created_at', 'asc')
        ->get();
        return view('chat.show',compact('chat','id','contact','contacts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        $chat->messages = $request->message;
        $chat->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyme($id)
    {
        $chat = Chat::find($id);
        if ($chat->from == Auth::user()->id && $chat->status == 'a') {
            $chat->status = 'r';
            $chat->save();
        } else if ($chat->from == Auth::user()->id && $chat->status == 's') {
            $chat->delete();
        } else if ($chat->from != Auth::user()->id && $chat->status == 'a') {
            $chat->status = 's';
            $chat->save();
        } else if($chat->from != Auth::user()->id && $chat->status == 'r') {
            $chat->delete();
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        $chat = Chat::find($id);
        $chat->delete();
        return redirect()->back();
    }

    public function clear($id)
    {
        $chat = Chat::where('from','=',Auth::user()->id)
        ->where('to','=',$id)
        ->get();
        foreach ($chat as $c) {
            if ($c->status == 'a') {
                $c->status = 'r';
                $c->save();
            }
            if ($c->status == 's') {
                $c->delete();
            }
        }

        $chats = Chat::where('from','=',$id)
        ->where('to','=',Auth::user()->id)
        ->get();
        foreach ($chats as $c) {
            if ($c->status == 'a') {
                $c->status = 's';
                $c->save();
            }
            if ($c->status == 'r') {
                $c->delete();
            }
        }
        return redirect()->back();
    }
}
