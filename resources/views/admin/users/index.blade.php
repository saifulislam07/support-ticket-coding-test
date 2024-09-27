@extends('admin.master')
@section('menu-name')
    All Users
@endsection

@section('main-content')
    <div class="container">
        <div class="row">
            @include('layouts.admin_menu')
            <div class="mt-2 col order-5 col-md-9">
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5>All Users</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Join</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $i++ }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td> {{ $user->email }}</td>
                                        <td class="text-center">
                                            @if ($user->role == 'customer')
                                                <span class="badge bg-info text-white ">{{ $user->role }}</span>
                                            @elseif ($user->role == 'admin')
                                                <span class="badge bg-success text-white">{{ $user->role }}</span>
                                            @endif

                                        </td>
                                        <td>{{ $user->created_at->format('d-M-Y H:s') }}</td>

                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="7">No User</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
