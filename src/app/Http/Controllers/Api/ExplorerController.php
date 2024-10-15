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

    public function trocarItems(Request $request)
    {
        $request->validate([
            'explorer1_id' => 'required|exists:explorers,id',
            'explorer2_id' => 'required|exists:explorers,id',
            'itemExplorer1' => 'required|array',
            'itemExplorer1.*' => 'exists:items,id',
            'itemExplorer2' => 'required|array',
            'itemExplorer2.*' => 'exists:items,id',
        ]);

        $explorer1 = Explorer::find($request->explorer1_id);
        $explorer2 = Explorer::find($request->explorer2_id);
        $itemsExplorer1 = Items::whereIn('id', $request->itemExplorer1)->get();
        $itemsExplorer2 = Items::whereIn('id', $request->itemExplorer2)->get();

        $explorer1Total = $itemsExplorer1->sum('valor');
        $explorer2Total = $itemsExplorer2->sum('valor');

        if ($explorer1Total != $explorer2Total) {
            return response()->json([
                'message' => "A troca não será justa!"
            ]);
        }

        Items::whereIn('id', $request->itemExplorer1)->update(['idExplorer' => $explorer2->id]);
        Items::whereIn('id', $request->itemExplorer2)->update(['idExplorer' => $explorer1->id]);

        return response()->json([
            'message' => 'Troca feita com sucesso!'
        ]);
    }

    public function show($id)
    {
        $explorer = Explorer::find($id);

        if (!$explorer) {
            return response()->json([
                'message'=> 'Explorador nao encontrado'
            ]);
        }

        return response()->json($explorer);
    }

}
