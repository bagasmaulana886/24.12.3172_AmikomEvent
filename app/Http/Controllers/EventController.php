<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $categories = Category::all();

        return view('event-detail', compact('categories', 'event'));
    }

    public function checkout(Event $event = null)
    {
        return view('checkout', compact('event'));
    }

    public function ticket()
    {
        return view('ticket');
    }
}
