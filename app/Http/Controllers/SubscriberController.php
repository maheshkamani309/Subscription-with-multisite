<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewSubScriberRequest;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewSubScriberRequest $request)
    {
        $subscriber = Subscriber::create($request->all());
         return response()->json(['message' => 'Subscriber Added successfully', 'post' => $subscriber]);
    }

}
