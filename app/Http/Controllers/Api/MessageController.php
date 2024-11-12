<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Store a newly created message in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validazione dei dati inviati via API
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'surname' => 'required|max:50',
            'email' => 'required|email|max:50',
            'phone' => 'required|max:15',
            'message' => 'required|max:500',
            'real_estate_id' => 'required|exists:real_estates,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Creazione del messaggio
        $message = new Message();
        $message->name = $request->input('name');
        $message->surname = $request->input('surname');
        $message->email = $request->input('email');
        $message->phone = $request->input('phone');
        $message->message = $request->input('message');
        $message->real_estate_id = $request->input('real_estate_id');
        $message->save();

        return response()->json(['message' => 'Messaggio inviato con successo!'], 201);
    }
}