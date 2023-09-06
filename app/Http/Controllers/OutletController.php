<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\OutletsExport;
use App\Models\Outlet;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;



class OutletController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $outlets = Outlet::get();

            return view('outlets', compact('outlets'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        if (Auth::check()) {
            return Excel::download(new OutletsExport, 'DataOutlets.xlsx');
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
}
