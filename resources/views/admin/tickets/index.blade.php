@extends('admin.master')
@section('menu-name')
    All Ticekts
@endsection

@section('main-content')
    <div class="container">
        <div class="row">
            @include('layouts.admin_menu')
            <div class="mt-2 col order-5 col-md-9">
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5>All tickets</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Priority</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($tickets as $ticket)
                                    <tr>
                                        <th scope="row">{{ $i++ }}</th>
                                        <td>
                                            {{ $ticket->user?->name }}
                                            {{ $ticket->user?->email }}
                                        </td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ $ticket->message }}</td>
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
                                        <td>
                                            @if ($ticket->status == 'OPEN')
                                                <span class="badge bg-primary">{{ $ticket->status }}</span>
                                            @elseif ($ticket->status == 'CLOSE')
                                                <span class="badge bg-success">{{ $ticket->status }}</span>
                                            @elseif ($ticket->status == 'CANCELED')
                                                <span class="badge bg-danger">{{ $ticket->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-light btn-sm"
                                                href="{{ route('admin.ticket.show', $ticket->id) }}">VIEW</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="7">No Ticket</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        {!! $tickets->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
