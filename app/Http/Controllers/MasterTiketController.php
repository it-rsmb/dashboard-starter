<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataFeed;
use App\Models\User;
use App\Models\tiket\Unit;
use App\Models\tiket\Ruangan;
use App\Models\tiket\MasterAset;
use App\Models\tiket\AsetMutasi;
use App\Models\tiket\AsetSpesifikasi;
use Illuminate\Support\Facades\Auth;
use App\Models\tiket\AdminTiket;



class MasterTiketController extends Controller
{

     /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
       $this->middleware('auth');
   }
   /**
    * Display a listing of the users.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {

        $user = Auth::user()->id;
        $cek = AdminTiket::where('id_user', $user)->count();

        if ($cek == 0) {
            abort(403, 'Anda tidak memiliki akses untuk melihat halaman ini. Silahkan hubungi admin untuk meminta akses.');
        }
        $units = Unit::with('ruangans')->get();
        return view('pages.tiket.master_unit', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $unit = Unit::create($request->all());
        return response()->json(['success' => true, 'unit' => $unit]);
    }

    public function update(Request $request, $id)
    {
    //  dd($request->all());
        $unit = Unit::findOrFail($id);
        $unit->update($request->all());
        return response()->json(['success' => true, 'unit' => $unit]);
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        return response()->json(['success' => true]);
    }

    public function storeRuangan(Request $request, $id_unit)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:100',
            'lokasi' => 'nullable|string|max:150',
        ]);
        $ruangan = Ruangan::create([
            'id_unit' => $id_unit,
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi' => $request->lokasi,
        ]);

        return response()->json(['success' => true, 'ruangan' => $ruangan]);
    }

    public function destroyRuangan($id_unit, $id_ruangan)
    {
        $ruangan = Ruangan::where('id_unit', $id_unit)->where('id_ruangan', $id_ruangan)->firstOrFail();
        $ruangan->delete();

        return response()->json(['success' => true]);
    }

    public function getRuangan(Request $request)
    {
        $search = $request->q;

        $query = Ruangan::query();

        if ($search) {
            $query->where('nama_ruangan', 'ILIKE', "%$search%");
        }

        $ruangan = $query->select('id_ruangan', 'nama_ruangan')->paginate(10);

        return response()->json([
            'results' => $ruangan->items(),
            'pagination' => [
                'more' => $ruangan->hasMorePages()
            ]
        ]);
    }


    // ===== CRUD ASET =====
    public function index_aset() {

        $user = Auth::user()->id;
        $cek = AdminTiket::where('id_user', $user)->count();

        if ($cek == 0) {
            abort(403, 'Anda tidak memiliki akses untuk melihat halaman ini. Silahkan hubungi admin untuk meminta akses.');
        }
        $aset = MasterAset::with('mutasi_aset')->get();
        
        return view('pages.tiket.master_aset', compact('aset'));
    }

    public function data_aset()
    {
        // Ambil data dengan relasi
        $user_id = Auth::user()->id;
        $admin = AdminTiket::where('id_user', $user_id)->first(); 
        $query = MasterAset::with([
            'ruangan',
            'mutasi_aset',
            'mutasi_aset.ruangan_awal',
            'mutasi_aset.ruangan_tujuan',
            'aset_spesifikasi'
        ]);
        // Apply 'where kategori' filter if the admin has a category defined
        if ($admin && $admin->admin_tipe) {
            $query->where('kategori', $admin->admin_tipe);
        }

        $aset = $query->get();
        return response()->json($aset);
    }


    public function store_aset(Request $request) {

        $user_id = Auth::user()->id;
        $admin = AdminTiket::where('id_user', $user_id)->first(); 
        
        $data = $request->all();
        $data['kategori'] = $admin->admin_tipe; // tambahkan kategori dari admin_tipe

        $aset = MasterAset::create($data);
        return response()->json(['success' => true, 'aset' => $aset]);
    }

    public function show_aset($id) {
        $aset = MasterAset::with('mutasi_aset')->findOrFail($id);
        return response()->json([
            'success' => true,
            'aset' => $aset
        ]);
    }

    public function update_aset(Request $request, $id) {
        $aset = MasterAset::findOrFail($id);
        $aset->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroy_aset($id) {
        $aset = MasterAset::findOrFail($id);
        $aset->delete();
        return response()->json(['success' => true]);
    }

    // ===== CRUD MUTASI =====
    public function store_mutasi(Request $request, $id) {
        $aset = MasterAset::findOrFail($id);
        $id_ruangan_awal = $aset->id_ruangan;
        $aset->update(['id_ruangan' => $request->id_ruangan_tujuan]);

        $mutasi = AsetMutasi::create([
            'id_aset' => $id,
            'id_ruangan_awal' => $id_ruangan_awal,
            'id_ruangan_tujuan' => $request->id_ruangan_tujuan,
            'tanggal_mutasi' => $request->tanggal_mutasi,
            'keterangan' => $request->keterangan,
        ]);
        return response()->json(['success' => true, 'mutasi' => $mutasi]);
    }

    public function destroy_mutasi($id) {
        $mutasi = AsetMutasi::findOrFail($id);
        $mutasi->delete();
        return response()->json(['success' => true]);
    }


    // 🔹 List semua detail spek berdasarkan id_aset
    public function index_aset_detail($id_aset)
    {
        $details = AsetSpesifikasi::where('id_aset', $id_aset)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json($details);
    }

    // 🔹 Simpan spek baru
    public function store_aset_detail(Request $request)
    {
        // Nonaktifkan spek lama (jika ada)
        AsetSpesifikasi::where('id_aset', $request->id_aset)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        // Tambahkan spek baru
        $detail = AsetSpesifikasi::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $detail
        ]);
    }

    // 🔹 Lihat detail spesifik
    public function show_aset_detail($id_detail)
    {
        $detail = AsetSpesifikasi::findOrFail($id_detail);
        return response()->json($detail);
    }

    // 🔹 Update (edit spek tertentu)
    public function update_aset_detail(Request $request, $id_detail)
    {
        $detail = AsetSpesifikasi::findOrFail($id_detail);
        $detail->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $detail
        ]);
    }

    // 🔹 Hapus spek
    public function destroy_aset_detail($id_detail)
    {
        $detail = AsetSpesifikasi::findOrFail($id_detail);
        $detail->delete();

        return response()->json(['success' => true]);
    }
    
}
