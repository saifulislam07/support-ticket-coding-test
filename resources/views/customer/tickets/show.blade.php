@extends('admin.master')
@section('menu-name')
    Show Ticket
@endsection

@section('main-content')
    <div class="container">
        <div class="row">
            @include('layouts.customer_menu')
            <div class="mt-2 col order-5 col-md-9">
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5>View Ticket</h5>
                        <a href="{{ route('ticket.index') }}" class="btn btn-light btn-sm">
                            BACK</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="15%" scope="col">Priority</th>
                                    <td>
                                        @if ($ticket->priority == 'Low')
                                            <span class="badge bg-info text-dark">{{ $ticket->priority }}</span>
                                        @elseif ($ticket->priority == 'High')
                                            <span class="badge bg-warning text-dark">{{ $ticket->priority }}</span>
                                        @elseif ($ticket->priority == 'Medium')
                                            <span class="badge bg-secondary">{{ $ticket->priority }}</span>
                                        @elseif ($ticket->priority == 'Urgent')
                                            <span class="badge bg-danger">{{ $ticket->priority }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Status</th>
                                    <td>
                                        @if ($ticket->status == 'OPEN')
                                            <span class="badge bg-primary">{{ $ticket->status }}</span>
                                        @elseif ($ticket->status == 'CLOSE')
                                            <span class="badge bg-success">{{ $ticket->status }}</span>
                                        @elseif ($ticket->status == 'CANCELED')
                                            <span class="badge bg-danger">{{ $ticket->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Subject</th>
                                    <td>{{ $ticket->subject }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Message</th>
                                    <td>{{ $ticket->message }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Ticketing Time</th>
                                    <td>{{ $ticket->created_at->format('d-M-Y H:s') }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Attachment</th>
                                    <td>
                                        @if ($ticket->file)
                                            <img width="200px" src="{{ asset($ticket->file?->path) }}" alt="">
                                        @else
                                            {{ 'N/A' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>

                                    <th scope="col"></th>
                                    <td>

                                        <table class="table table-dark table-striped table-bordered">
                                            <tr class="text-center">
                                                <th colspan="3">Responses</th>
                                            </tr>
                                            <tr>
                                                <th>Agent</th>
                                                <th>Date</th>
                                                <th>Comments with Attachments</th>
                                            </tr>
                                            @forelse ($ticket->comments as $commnet)
                                                <tr>
                                                    <td>
                                                        @if ($commnet->agent?->id == auth()->user()->id)
                                                            <b style="color: rgb(223, 212, 57)">Myself</b>
                                                        @else
                                                            {{ $commnet->agent?->name }}
                                                        @endif
                                                    </td>
                                                    <td width="20%">{{ $commnet->created_at->format('d-M-Y H:s') }}</td>
                                                    <td>
                                                        @if ($commnet->file)
                                                            <img width="200px" class="mb-1"
                                                                src="{{ asset($commnet->file?->path) }}" alt="">

                                                            <hr>
                                                        @endif
                                                        {{ $commnet->message }}
                                                    </td>
                                                </tr>
                                            @empty
                                                {{ 'N/A' }}
                                            @endforelse
                                        </table>
                                    </td>

                                </tr>
                                @if ($ticket->status == 'OPEN')
                                    <tr>
                                        <th></th>
                                        <form method="post" action="{{ route('ticket.reply.store', $ticket->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <td>
                                                <textarea type="text" class="form-control" name="message" id="" rows="3"></textarea>
                                                @error('message')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <input type="file" name="attachment" class="form-control mt-2 bg-light">
                                                <button type="submit" class="btn btn-light mt-2">Reply</button>
                                            </td>
                                        </form>
                                    </tr>
                                @endif
                            </thead>

                            <tbody>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
