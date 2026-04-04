<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return response()->json([
            'solde_conges' => $user->solde_conges,
            'message'      => 'Solde de congés récupéré avec succès'
        ], 200);
    }

    public function request(Request $request)
    {
        $request->validate([
            'jours' => 'required|integer|min:2', // minimum 2 jours
        ]);

        $user  = auth()->user();
        $jours = $request->jours;

        if ($user->solde_conges < $jours) {
            return response()->json([
                'message' => 'Solde de congés insuffisant'
            ], 422);
        }

        $user->solde_conges -= $jours;
        $user->save();

        return response()->json([
            'message'      => 'Demande de congé soumise avec succès',
            'nouveau_solde' => $user->solde_conges
        ], 200);
    }
}