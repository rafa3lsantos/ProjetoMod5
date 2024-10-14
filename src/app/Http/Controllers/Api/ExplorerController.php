<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Explorer;
use App\Models\Items;
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

    public function update(Request $request, $id)
    {
        $arrayRequest = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'   
        ]);
        
        $explorer = Explorer::find($id);

        if (!$explorer) {
            return response()->json([
                'message' => 'Explorador não encontrado'
            ], 404);
        }

        $explorer->update($arrayRequest);

        return response()->json([
            'message' => "Localizacoes atualizadas!",
            'explorer' => $explorer
        ]);
    }

    public function addItems(Request $request)
    {
        $arrayRequest = $request->validate([
            'nome' => 'required|string|min:3|max:255',
            'valor' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'idExplorer' => 'required|integer'
        ]);

        $item = Items::create($arrayRequest);

        return response()->json([
            'message' => "Item adicionado ao inventario!",
            'item' => $item
        ]);
    }

}
