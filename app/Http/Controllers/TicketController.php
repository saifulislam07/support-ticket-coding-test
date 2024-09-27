<?php

namespace App\Http\Controllers;

use App\Mail\TicketClosed;
use App\Models\Comments;
use App\Models\File;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{

    public function index()
    {
        $tickets = Ticket::orderByRaw(
            "CASE status 
            WHEN 'OPEN' THEN 1
            WHEN 'CLOSE' THEN 2
            WHEN 'CANCELED' THEN 3 
            END"
        )
            ->orderBy('id', 'desc')->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::with('comments.agent')->where('id', $id)->first();

        return view('admin.tickets.show', compact('ticket'));
    }

    public function replyStore(Request $request, $ticekt_id)
    {
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



        return redirect()->back()->with(['message' => 'Reply has been submitted successfully']);
    }


    public function updateStatus(Request $request)
    {

        $request->validate([
            'ticket_id' => 'required|integer',
            'status' => 'required|string'
        ]);

        $ticket = Ticket::with('comments')->find($request->ticket_id);


        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->status = $request->status;
        $ticket->save();



        if ($request->status === 'CLOSE') {
            $data = [
                'title' => 'Ticket Closed',
                'body' => 'Your ticket has been closed. Please find the details below:',
                'details' => $ticket,
            ];

            Mail::to($ticket->user->email)->queue(new TicketClosed($data));
        }
        return response()->json(['message' => 'Status updated  ' . $request->status]);
    }
}
