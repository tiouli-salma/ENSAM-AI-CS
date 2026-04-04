<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminLeaveController extends Controller
{

    public function credit(Request $request, $userId)
    {
        $request->validate([
            'jours' => 'required|integer|min:1',
        ]);

        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'message' => 'Employé non trouvé'
            ], 404);
        }

        $user->solde_conges += $request->jours;
        $user->save();

        return response()->json([
            'message'       => 'Congés crédités avec succès',
            'employe'       => $user->name,
            'nouveau_solde' => $user->solde_conges
        ], 200);
    }

    public function debit(Request $request, $userId)
    {
        $request->validate([
            'jours' => 'required|integer|min:1',
        ]);

        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'message' => 'Employé non trouvé'
            ], 404);
        }

        if ($user->solde_conges < $request->jours) {
            return response()->json([
                'message' => 'Solde insuffisant pour ce débit'
            ], 422);
        }

        $user->solde_conges -= $request->jours;
        $user->save();

        return response()->json([
            'message'       => 'Congés débités avec succès',
            'employe'       => $user->name,
            'nouveau_solde' => $user->solde_conges
        ], 200);
    }
}