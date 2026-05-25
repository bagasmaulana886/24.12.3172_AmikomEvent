<?php

namespace App\Http\Controllers;

class EventController extends Controller
{
    public function show($id)
    {
        return view('event-detail');
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function ticket()
    {
        return view('ticket');
    }
}
