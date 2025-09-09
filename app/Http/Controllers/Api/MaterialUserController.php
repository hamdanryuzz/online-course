<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class MaterialUserController extends Controller
{
    public function complete(Material $material)
    {
        $user = Auth::user();

        // Tandai material sebagai completed untuk user ini
        $user->materials()->syncWithoutDetaching([
            $material->id => [
                'status' => 'completed',
                'completed_at' => now(),
            ]
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Material marked as completed',
            'material_id' => $material->id
        ]);
    }
}
