<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class MaterialUserController extends Controller
{
    public function complete(Material $material)
    {
        $user = Auth::user();

        $user->materials()->syncWithoutDetaching([
            $material->id => [
                'status' => 'completed',
                'completed_at' => now(),
            ]
        ]);

        return response()->json(['success' => true]);
    }
}
