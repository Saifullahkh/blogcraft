<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function create()
    {
        return view('pages.contact');
    }

    public function store(ContactMessageRequest $request)
    {
        ContactMessage::create($request->validated());

        return back()->with('success', 'Thanks for reaching out. We will reply soon.');
    }
}
