<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contact = Contact::all()->where('user1', '=', Auth::user()->id);
        return view('contact.index',compact('contact'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::where('maker', '=', Auth::user()->id)
        ->get();
        return view('contact.create',compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $contact = new Contact();
        Contact::create([
            'maker' => $request->maker,
            'receiver' => $request->receiver,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $contact = Contact::all()->where('user1', '=', Auth::user()->id);
        $chat = Chat::all()->where('from', '=', Auth::user()->id && 'to', '=', $contact);
        return view('contact.show',compact('chat','contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
