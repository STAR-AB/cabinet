<?php

namespace App\Http\Controllers;

use App\Models\Soin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SoinController extends Controller
{
    public function index(): View
    {
        $soins = Soin::withCount('rendezVous')->orderBy('libelle')->get();

        return view('soins.index', compact('soins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'libelle'       => ['required', 'string', 'max:255', 'unique:soins,libelle'],
            'description'   => ['nullable', 'string'],
            'prix'          => ['required', 'numeric', 'min:0'],
            'duree_minutes' => ['required', 'integer', 'min:5', 'max:240'],
        ]);

        Soin::create($data);

        return back()->with('success', 'Soin ajouté au catalogue.');
    }

    public function destroy(Soin $soin): RedirectResponse
    {
        if ($soin->rendezVous()->exists()) {
            return back()->withErrors([
                'soin' => 'Impossible : ce soin est utilisé dans des rendez-vous.',
            ]);
        }

        $soin->delete();

        return back()->with('success', 'Soin supprimé.');
    }
}
