<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //get mobil where user_id = auth()->id() and filter by search params
        $mobils = Mobil::with('peminjaman')->where('user_id', auth()->id())
            ->when($request->search, function ($query, $search) {
                return $query->where('merk', 'like', "%$search%")
                    ->orWhere('model', 'like', "%$search%")
                    ->orWhere('nomor_plat', 'like', "%$search%");
            })
            ->get();
        // attach "available" attribute to each mobil
        $mobils->each(function ($mobil) {
            $mobil->available = $mobil->peminjaman->isEmpty() || $mobil->peminjaman->where('status', 'dipinjam')->isEmpty();
        });

        // if there's a search param "hanyaTersedia=1", filter only available mobils
        if ($request->hanyaTersedia) {
            $mobils = $mobils->filter->available;
        }

        // $mobils = Mobil::where('user_id', auth()->id())->get();
        return inertia('Mobil/Index', [
            'mobils' => $mobils
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Mobil/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* based on
        protected $fillable = [
        'merk',
        'model',
        'nomor_plat',
        'tarif_per_hari',
        ];
        */
        $request->validate([
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'nomor_plat' => 'required|string|max:255',
            'tarif_per_hari' => 'required|numeric',
        ]);

        Mobil::create([
            'merk' => $request->merk,
            'model' => $request->model,
            'nomor_plat' => $request->nomor_plat,
            'tarif_per_hari' => $request->tarif_per_hari,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('mobil.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //edit mobil where id = $id
        
        $mobil = Mobil::findOrFail($id);
        return inertia('Mobil/Edit', [
            'mobil' => $mobil
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /* based on
        protected $fillable = [
        'merk',
        'model',
        'nomor_plat',
        'tarif_per_hari',
        ];
        */
        $request->validate([
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'nomor_plat' => 'required|string|max:255',
            'tarif_per_hari' => 'required|numeric',
        ]);

        Mobil::findOrFail($id)->update([
            'merk' => $request->merk,
            'model' => $request->model,
            'nomor_plat' => $request->nomor_plat,
            'tarif_per_hari' => $request->tarif_per_hari,
        ]);

        return redirect()->route('mobil.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Mobil::findOrFail($id)->delete();
        return redirect()->route('mobil.index');
    }
}
