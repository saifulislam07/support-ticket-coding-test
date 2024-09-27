<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {

        if (auth()->user()->role == 'customer') {
            $ticketsCount = DB::table('tickets')
                ->where('user_id', auth()->user()?->id)
                ->select(
                    DB::raw("COUNT(CASE WHEN status = 'OPEN' THEN 1 END) as open_count"),
                    DB::raw("COUNT(CASE WHEN status = 'CLOSE' THEN 1 END) as close_count"),
                    DB::raw("COUNT(CASE WHEN status = 'CANCELED' THEN 1 END) as canceled_count")
                )
                ->first();

            return view('customer.dashboard', ['ticketsCount' => $ticketsCount]);
        }
        $ticketsCount = DB::table('tickets')
            ->select(
                DB::raw("COUNT(CASE WHEN status = 'OPEN' THEN 1 END) as open_count"),
                DB::raw("COUNT(CASE WHEN status = 'CLOSE' THEN 1 END) as close_count"),
                DB::raw("COUNT(CASE WHEN status = 'CANCELED' THEN 1 END) as canceled_count")
            )
            ->first();
        $customer_count = User::where('role', 'customer')->count();
        return view('admin.dashboard', ['customer_count' => $customer_count, 'ticketsCount' => $ticketsCount]);
    }
}
