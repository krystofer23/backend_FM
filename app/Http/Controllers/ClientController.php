<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Exception;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index () 
    {
        $clients = Client::all();
        return ClientResource::collection($clients);
    }

    public function store (ClientRequest $request) 
    {
        try {
            $client = Client::create([
                'name' => $request->name,
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
            ]);
            return new ClientResource($client);
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update (ClientRequest $request, $id)
    {
        try {
            $client = Client::find($id);
            $client->update([
                'name' => $request->name,
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
            ]);
            return new ClientResource($client);
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy ($id) 
    {
        try {
            $client = Client::find($id);
            $client->delete();
            
            return response()->json([
                null
            ], 204);
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
