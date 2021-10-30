<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ContactController extends Controller
{
    private $datatableColumns;
    private $datatableHeaders;
    private $datatableUrl;

    public function __construct()
    {
        $this->datatableHeaders = [
            'ID',
            'Name',
            'Email',
            'Subject'
        ];
        $this->datatableColumns = [
            ['data' => 'id'],
            ['data' => 'name'],
            ['data' => 'email'],
            ['data' => 'subject'],
        ];

        $this->datatableUrl = route('contacts-datatables');
    }

    public function datatables()
    {
        $query = new Contact();
        $query = $query->newQuery();
        return datatables()->eloquent($query)
            ->addColumn('action', function ($contact) {
                $buttons = '';
                $buttons .= '<a class="btn btn-primary" href="' . route('contacts.edit', $contact->id) . '" title="' . __('Edit Contact') . '">Edit</a>';

                $buttons .= '<form action="' . route('contacts.destroy', $contact->id) . '"  id="delete-form-' .
                    $contact->id . '" method="post" style="display: inline-block">
<input type="hidden" name="_token" value="' . csrf_token() . '">
<input type="hidden" name="_method" value="DELETE">
<button class="btn btn-danger ml-1" onclick="return makeDeleteRequest(event, ' . $contact->id . ')"  type="submit" title="'
                    . __('Delete Contact') . '">Delete</button></form>';

                return $buttons;
            })->addColumn('name', function ($contact) {
                return Str::lower($contact->name);
            })->addColumn('email', function ($contact) {
                return $contact->email;
            })->rawColumns(['action', 'name', 'email'])->addIndexColumn()->make(true);
    }


    public function datatablesCopy()
    {
        $datatables = datatables()->of(Contact::query())
            ->addColumn('id', function ($contact) {
                return $contact->id;
            })
            ->addColumn('name', function ($contact) {
                return $contact->name;
            })
            ->addColumn('email', function ($contact) {
                return $contact->email;
            })
            ->addColumn('subject', function ($contact) {
                return $contact->subject;
            })
            ->toArray();
        return response()->json($datatables);
    }


    public function dataTableShow(Request $request)
    {
        return Inertia::render('ContactsDatatable')
            ->with('page_title', 'Contact Datatable')
            ->with('datatableUrl', $this->datatableUrl)
            ->with('datatableColumns', $this->datatableColumns)
            ->with('datatableHeaders', $this->datatableHeaders);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $data['page_title'] = 'All Contacts';
        $query              = Contact::query();
        if (\request()->get('query') != null) {
            $search = \request()->get('query');
            $query  = $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('subject', 'like', '%' . $search . '%')
                ->orWhere('message', 'like', '%' . $search . '%');
        }
        $data['contacts'] = $query->paginate(10);
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
