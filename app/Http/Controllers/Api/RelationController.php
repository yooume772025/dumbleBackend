<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Relation;
use Illuminate\Http\Request;

class RelationController extends Controller
{
    public function relationshipList(Request $request)
    {
        $relationships = Relation::select('id', 'name', 'logo')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $relationships,
            'message' => 'Relationship list retrieved successfully'
        ], 200);
    }
}
