<?php

namespace App\Http\Controllers;

use App\Mail\TicketOpened;
use App\Models\Comments;
use App\Models\File;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomerTicketController extends Controller
{
    public function create()
    {
        return view('customer.tickets.create');
    }
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)
            ->orderByRaw("CASE status 
        WHEN 'OPEN' THEN 1
        WHEN 'CLOSE' THEN 2
        WHEN 'CANCELED' THEN 3 
        END")
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('customer.tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::with('comments.agent')
            ->where('user_id', auth()->user()->id)->where('id', $id)->first();

        return view('customer.tickets.show', compact('ticket'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:Low,Medium,High,Urgent',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $fileId = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0755, true);
            }

            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);

            $fileModel = new File();
            $fileModel->path = 'uploads/' . $fileName;
            $fileModel->created_by = auth()->id();
            $fileModel->type = $file->getClientMimeType();
            $fileModel->save();

            $fileId = $fileModel->id;
        }

        Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => 'open',
            'file_id' => $fileId,
        ]);

        $data = [
            'title' => 'New Ticket Open',
            'body' => 'A new support ticket has been opened. Below are the details:',
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
        ];

        Mail::to('saiful.rana@gmail.com')->queue(new TicketOpened($data));

        return redirect()->route('ticket.index')->with(['message' => 'Ticket has been submitted successfully.', 'alert-type' => 'success']);
    }

    public function replyStore(Request $request, $ticekt_id)
    {

        $ticket = Ticket::find($ticekt_id);
        if ($ticket->status != 'OPEN') {
            return redirect()->back()->with(['error' => 'Ticket closed by Admin']);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $fileId = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0755, true);
            }

            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);

            $fileModel = new File();
            $fileModel->path = 'uploads/' . $fileName;
            $fileModel->created_by = auth()->id();
            $fileModel->type = $file->getClientMimeType();
            $fileModel->save();

            $fileId = $fileModel->id;
        }

        Comments::create([
            'ticket_id' => $ticekt_id,
            'agent_id' => auth()->id(),
            'message' => $request->message,
            'file_id' => $fileId,
        ]);

        return redirect()->back()->with(['message' => 'Reply stored successfully']);
    }
}
