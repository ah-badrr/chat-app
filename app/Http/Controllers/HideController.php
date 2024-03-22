<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Hide;
use App\Models\Contact;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $hide = new Hide;
        $hide->user_id = Auth::user()->id;
        $hide->chat_id = $id;
        $hide->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Hide $hide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hide $hide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hide $hide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hide $hide)
    {
        //
    }
}
