<?php

namespace App\Http\Controllers;

use App\Exports\ItemsExport;
use App\Models\Item;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;



class ItemController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        if (Auth::check()) {
            $items = Item::get();

            return view('items', compact('items'));
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    public function export()
    {
        if (Auth::check()) {
            return Excel::download(new ItemsExport, 'DataItems.xlsx');
        }

        return redirect("/")->withSuccess('Opps! You do not have access');
    }
}
