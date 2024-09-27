@extends('admin.master')
@section('menu-name')
    Dashboard
@endsection

@section('main-content')
    <div class="container">
        <div class="row">
            @include('layouts.admin_menu')

            <div class="mt-2 col order-5 col-md-9 ">
                <div class="card">
                    <div class="card-body ">
                        <div class="row row-cols-1 row-cols-md-2  g-4">
                            <div class="col col-md-3 ">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <h5 class="card-title"> Customer</h5>
                                        <hr>
                                        <h5 class="card-text pl-5">{{ $customer_count ?? '0' }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-3">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <h5 class="card-title"> Close Tickets</h5>
                                        <hr>
                                        <h5 class="card-text pl-5">{{ $ticketsCount->open_count ?? '0' }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-3">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <h5 class="card-title"> Close Tickets</h5>
                                        <hr>
                                        <h5 class="card-text pl-5">{{ $ticketsCount->close_count ?? '0' }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-3">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <h5 class="card-title"> Canceled Tickets</h5>
                                        <hr>
                                        <h5 class="card-text pl-5">{{ $ticketsCount->canceled_count ?? '0' }}</h5>
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
