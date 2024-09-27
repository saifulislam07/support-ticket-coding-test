@extends('admin.master')
@section('menu-name')
    Create Ticket
@endsection
@section('main-content')
    <div class="container">
        <div class="row">
            @include('layouts.customer_menu')
            <div class="mt-2 col order-5 col-md-9">
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5>Create ticket</h5>
                        <a href="{{ route('ticket.index') }}" class="btn btn-light btn-sm">
                            TICKETS</a>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('ticket.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                    <option value="Urgent">Urgent</option>
                                </select>
                                @error('priority')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input type="text" placeholder="Subject of the ticket" value="{{ old('subject') }}"
                                    name="subject" class="form-control">
                                @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Message</label>
                                <textarea type="text" name="message" placeholder="Details of ticket" class="form-control" id="exampleInputPassword1">{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Attachment</label>
                                <input type="file" name="attachment" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
