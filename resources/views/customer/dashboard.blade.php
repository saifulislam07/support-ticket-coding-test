@extends('admin.master')
@section('menu-name')
    Dashboard
@endsection

@section('main-content')
    <style>
        .card {
            background-color: #f8f9fa;
            border-radius: 15px;
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 2.5rem;
        }
    </style>
    <div class="container">
        <div class="row">
            @include('layouts.customer_menu')

            <div class="mt-2 col order-5 col-md-9 ">
                <div class="card">
                    <div class="card-body ">
                        <div class="row row-cols-1 row-cols-md-2  g-4">
                            <div class="col col-md-4 ">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <h5 class="card-title"> Open Tickets</h5>
                                        <h5 class="card-text">{{ $ticketsCount->open_count ?? '0' }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-4">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <h5 class="card-title"> Close Tickets</h5>
                                        <h5 class="card-text">{{ $ticketsCount->close_count ?? '0' }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-4">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <h5 class="card-title"> Canceled Tickets</h5>
                                        <h5 class="card-text">{{ $ticketsCount->canceled_count ?? '0' }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
