<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $data['page_title'] = 'All Contacts';
        $data['contacts']   = Contact::latest()->paginate(10);
        return Inertia::render('AllContactsComponent', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Contact::create($request->validate([
            'name'    => ['bail', 'required', 'string'],
            'email'   => ['bail', 'required', 'string', 'email', 'unique:contacts'],
            'subject' => ['bail', 'required', 'string'],
            'message' => ['bail', 'required', 'string'],
        ]));

        Mail::raw($request->message, function ($message) use ($request) {
            $message->subject($request->subject);
            $message->to($request->email, $request->name);
        });

        return back()->with('success', 'Message sent successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contact $contact
     * @return \Inertia\Response
     */
    public function edit(Contact $contact)
    {
        $data['page_title'] = 'Edit Contact';
        $data['contact']    = $contact;
        $data['edit_mode']  = true;
        return Inertia::render('ContactComponent', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Contact $contact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Contact $contact)
    {
        $contact->update($request->validate([
            'name'    => ['bail', 'required', 'string'],
            'email'   => ['bail', 'required', 'string', 'email', 'unique:contacts,id,:id'],
            'subject' => ['bail', 'required', 'string'],
            'message' => ['bail', 'required', 'string'],
        ]));

        return back()->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Contact $contact)
    {
        $contact->deleteOrFail();

        return back()->with('success', 'Contact deleted successfully.');
    }
}
