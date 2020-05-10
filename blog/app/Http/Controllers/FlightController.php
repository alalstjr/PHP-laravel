<?php

namespace App\Http\Controllers;

use App\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function create()
    {
        return view("flights.create");
    }

    public function store(Request $request)
    {
        $flight = new Flight();
        $flight->user_id = 10;
        $flight->title = $request->title;
        $flight->description = $request->description;
        $flight->save();

        return $request -> all();
        // or dd()
        // dd($request -> all());
    }
}
