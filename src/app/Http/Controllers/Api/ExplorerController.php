<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Explorer;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class ExplorerController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'nome' => 'required|string|min:3|max:255',
            'idade' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $explorer = Explorer::create($arrayRequest);
        
        return response()->json([
            'message' => "Explorador adicionado!",
            'explorer' => $explorer
        ]);
    }

    public function update(string $id)
    {
        
    }
}
