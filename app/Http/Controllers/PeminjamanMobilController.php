<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\PeminjamanMobil;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get mobil where user_id = auth()->id() in the peminjaman index with search params
        $peminjamans = PeminjamanMobil::with('mobil')->where('user_id', auth()->id())
            ->when($request->search, function ($query, $search) {
                return $query->where('tanggal_peminjaman', 'like', "%$search%")
                    ->orWhere('tanggal_pengembalian', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%");
            })
            ->where('status', '!=', 'kembali')
            ->get();
        return inertia('PeminjamanMobil/Index', [
            'peminjamans' => $peminjamans
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all available mobils
        $mobils = Mobil::with('peminjaman')->where('user_id', '!=', auth()->id())
            ->whereDoesntHave('peminjaman', function ($query) {
                $query->where('status', 'dipinjam');
            })
            ->get();

        return inertia('PeminjamanMobil/Create', [
            'mobils' => $mobils
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // create peminjaman
        $request->validate([
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
        ]);

        $mobil = Mobil::findOrFail($request->mobil_id);
        //make sure mobil is available
        if ($mobil->peminjaman->isNotEmpty() && $mobil->peminjaman->where('status', 'dipinjam')->isNotEmpty()) {
            return redirect()->back()->with('error', 'Mobil sedang tidak tersedia');
        }

        //make sure $request->tanggal_peminjaman and $request->tanggal_pengembalian are Carbon instances
        $tanggal_peminjaman = Carbon::parse($request->tanggal_peminjaman);
        $tanggal_pengembalian = Carbon::parse($request->tanggal_pengembalian);

        $peminjaman = new PeminjamanMobil();
        $peminjaman->mobil_id = $mobil->id;
        $peminjaman->user_id = auth()->id();
        $peminjaman->tanggal_peminjaman = $tanggal_peminjaman;
        $peminjaman->tanggal_pengembalian = $tanggal_pengembalian;
        $peminjaman->status = 'dipinjam';
        $peminjaman->total_harga = $mobil->tarif_per_hari * $tanggal_peminjaman->diffInDays($tanggal_pengembalian);

        $peminjaman->save();

        return redirect()->route('peminjaman.index');

    }


    public function kembali(string $id)
    {
        //kembali page

        $peminjaman = PeminjamanMobil::findOrFail($id);
        //make sure current user is the owner of the peminjaman
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        return inertia('PeminjamanMobil/Kembali', [
            'peminjaman' => $peminjaman
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //return peminjaman
        $peminjaman = PeminjamanMobil::findOrFail($id);
        $peminjaman->status = 'kembali';
        $peminjaman->save();

        return redirect()->route('peminjaman.index');
    }
}
