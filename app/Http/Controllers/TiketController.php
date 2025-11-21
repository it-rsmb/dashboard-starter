<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataFeed;
use App\Models\User;
use App\Models\tiket\Unit;
use App\Models\tiket\Ruangan;
use App\Models\tiket\MasterAset;
use App\Models\tiket\TiketPerbaikan;
use Illuminate\Support\Facades\Auth;
use App\Models\tiket\AdminTiket;
use App\Models\tiket\TiketPerbaikanDetail;
use App\Models\tiket\TiketPerbaikanGambar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;




class TiketController extends Controller
{
    public function index()
    {
        $dataFeed = new DataFeed();
        // $units = Unit::all();

        $maps['dataFeed'] = $dataFeed;
        // $maps['units'] = $units;
        return view('pages.tiket.index', $maps);
    }

    public function index_suport()
    {
        $dataFeed = new DataFeed();
        $maps['dataFeed'] = $dataFeed;
        $user = Auth::user()->id;
        $cek = AdminTiket::where('id_user', $user)->count();

        if ($cek > 0) {
            return view('pages.tiket.index_suport', $maps);
        } else {
            // Jika user tidak terdaftar sebagai AdminTiket, tolak akses
            abort(403, 'Anda tidak memiliki akses untuk melihat halaman ini.');
        }
    }

    public function getWaitingTickets()
    {
        $user = Auth::user()->id;

        $tickets = TiketPerbaikan::with('departemen','ruangans')
            ->where('status_tiket', '1')
            ->where('pembuat_tiket', $user)
            ->get();
            // dd($tickets);

        return response()->json($tickets);
    }

    public function getProcessTickets()
    {
        $user = Auth::user()->id;
        $tickets = TiketPerbaikan::with('departemen', 'petugas_proses','ruangans')
            ->where('status_tiket', '2')
            ->where('pembuat_tiket', $user)
            ->get();
        return response()->json($tickets);
    }

    public function getPendingTickets()
    {
        $user = Auth::user()->id;
        $tickets = TiketPerbaikan::with('departemen', 'petugas_proses', 'petugas_pending','ruangans')
            ->where('status_tiket', '3')
            ->where('pembuat_tiket', $user)
            ->get();
        return response()->json($tickets);
    }

    public function getDoneTickets()
    {
        $user = Auth::user()->id;
        $tickets = TiketPerbaikan::with('departemen', 'pembuat_tiket', 'petugas_proses', 'petugas_pending', 'petugas_done','ruangans','departemen_done','ruangans_done')
            ->whereIn('status_tiket', ['4', '5'])
            ->where('pembuat_tiket', $user)
            ->get();
        return response()->json($tickets);
    }

    public function getWaitingTicketsAll()
    {
        $user_id = Auth::user()->id;
        $admin = AdminTiket::where('id_user', $user_id)->first(); 
        $tickets = TiketPerbaikan::with('departemen','pembuat_tiket','ruangans')
            ->where('status_tiket', '1')
            ->where('kategori_tiket', $admin->admin_tipe)
            ->orderBy('created_at', 'asc')
            ->get();

        // dd($tickets);

        return response()->json($tickets);
    }

    public function getProcessTicketsAll()
    {
        $user_id = Auth::user()->id;
        $admin = AdminTiket::where('id_user', $user_id)->first(); 
        $tickets = TiketPerbaikan::with('departemen', 'pembuat_tiket', 'petugas_proses','ruangans')
            ->where('status_tiket', '2')
            ->where('kategori_tiket', $admin->admin_tipe)
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json($tickets);
    }

    public function getPendingTicketsAll()
    {
        $user_id = Auth::user()->id;
        $admin = AdminTiket::where('id_user', $user_id)->first(); 
        $tickets = TiketPerbaikan::with('departemen', 'pembuat_tiket', 'petugas_proses', 'petugas_pending','ruangans')
            ->where('status_tiket', '3')
            ->where('kategori_tiket', $admin->admin_tipe)
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json($tickets);
    }

    public function getDoneTicketsAll()
    {
        $user_id = Auth::user()->id;
        $admin = AdminTiket::where('id_user', $user_id)->first(); 
        $tickets = TiketPerbaikan::with('departemen', 'pembuat_tiket', 'petugas_proses', 'petugas_pending', 'petugas_done', 'ruangans','departemen_done','ruangans_done')
            ->whereIn('status_tiket', ['4', '5'])
            ->where('kategori_tiket', $admin->admin_tipe)
            ->orderByDesc('tgl_done')
            ->limit(50)
            ->get();
        return response()->json($tickets);
    }

    public function getDetails($id)
    {
        // Ambil data tiket utama
        $tiket = TiketPerbaikan::find($id);

        if (!$tiket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan'
            ], 404);
        }
        // Ambil detail perbaikan
        $details = TiketPerbaikanDetail::with('aset')->where('tiket_id', $id)->get();

        // Ambil gambar perbaikan
        $detailsfoto = TiketPerbaikanGambar::where('tiket_id', $id)
            ->get();
        return response()->json([
            'success' => true,
            'no_tiket' => $tiket->id,
            'details' => $details,
            'detailsfoto' => $detailsfoto,
        ]);
    }

    public function close_tiket($id)
    {
        $tiket = TiketPerbaikan::findOrFail($id);
        $tiket->status_tiket = '4';
        $tiket->save();
        return response()->json(['success' => true]);
    }

    public function process_tiket($id)
    {
        $tiket = TiketPerbaikan::findOrFail($id);
        $tiket->status_tiket = '2';
        $tiket->petugas_proses = Auth::user()->id; // Record the user who processed it
        $tiket->tgl_proses = now(); // Record the timestamp
        $tiket->save();
        return response()->json(['success' => true, 'message' => 'Tiket berhasil ditandai sebagai sedang diproses.']);
    }

    public function pending_tiket(Request $request, $id)
    {
        $tiket = TiketPerbaikan::findOrFail($id);
        $tiket->status_tiket = '3'; // Set status to 'pending'
        $tiket->desc_pending = $request->input('desc_pending'); // Get pending reason from request
        $tiket->petugas_pending = Auth::user()->id; // Record the user who marked it pending
        $tiket->tgl_pending = now(); // Record the timestamp
        $tiket->save();
        return response()->json(['success' => true, 'message' => 'Tiket berhasil ditandai sebagai pending.']);
    }

    public function done_tiket(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            // Ensure asset detail arrays have consistent counts if provided
            $asetIds = $request->input('aset_id', []);
            $masalahs = $request->input('masalah', []);
            $penanganans = $request->input('penanganan', []);
            $statusAsets = $request->input('status_aset', []);


            // if (count($asetIds) !== count($masalahs) || count($asetIds) !== count($penanganans) || count($asetIds) !== count($statusAsets)) {
            //     throw new \Exception('Jumlah detail aset, masalah, penanganan, dan status aset tidak konsisten.');
            // }

            // 2. Find the ticket
            $tiket = TiketPerbaikan::findOrFail($id);

            // 3. Update the ticket status and details
            $tiket->status_tiket = '4'; // Status 'Done'
            $tiket->desc_done = $request->input('desc_done');
            $tiket->departemen_done = $request->input('unit');
            $tiket->ruangan_done = $request->input('ruangan');
            $tiket->petugas_done = Auth::user()->id;
            $tiket->tgl_done = now();
            $tiket->save();

            // Proses detail tiket hanya jika data detailnya ada, jika tidak ada abaikan
            if (!empty($asetIds) && count($asetIds) > 0) {
                for ($i = 0; $i < count($asetIds); $i++) {
                    // Only create a detail if at least one field is provided for that row
                    if (!empty($asetIds[$i]) || !empty($masalahs[$i]) || !empty($penanganans[$i])) {
                        TiketPerbaikanDetail::create([
                            'tiket_id' => $tiket->id,
                            'aset_id' => $asetIds[$i],
                            'masalah' => $masalahs[$i],
                            'penanganan' => $penanganans[$i],
                            'ruangan' => $request->input('ruangan'),
                            'petugas' => Auth::user()->id,
                            'waktu_penanganan' => now()
                        ]);

                        // Update Aset status if status_aset for this row is '0' (inactive)
                        if (!empty($asetIds[$i]) && isset($statusAsets[$i]) && $statusAsets[$i] == '0') {
                            $aset = MasterAset::find($asetIds[$i]);
                            if ($aset) {
                                $aset->status = 0; // Assuming 'status' field in Aset model represents its active/inactive state
                                $aset->save();
                            }
                        }
                    }
                }
            }

            // 5. Handle Solution Images (assuming TiketPerbaikanGambar model exists)
            if ($request->hasFile('gambar_perbaikan')) {
                foreach ($request->file('gambar_perbaikan') as $file) {
                    if ($file && $file->isValid()) {
                        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        // Store file in public/images/tiket/
                        $file->move(public_path('images/tiket/'), $fileName);
                        $uploadedImagePath = $fileName;

                        TiketPerbaikanGambar::create([
                            'tiket_id' => $tiket->id,
                            'gambar' => $uploadedImagePath,
                        ]);
                    }
                }
            }

            // 6. Commit the transaction
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Tiket berhasil ditandai sebagai selesai.']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // Ensure Log facade is imported at the top of the file: use Illuminate\Support\Facades\Log;
            return response()->json(['success' => false, 'message' => 'Validasi gagal: ' . $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            // Ensure Log facade is imported at the top of the file: use Illuminate\Support\Facades\Log;
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menandai tiket sebagai selesai: ' . $e->getMessage()], 500);
        }
    }


    function store(Request $request){
        // 1. Validate the request data for ticket fields
        $validatedData = $request->validate([
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'prioritas_tiket' => 'required|string|max:255',
            'departemen'     => 'required|string|max:255',
            'subjek_tiket'   => 'required|string|max:255',
            'desc_tiket'     => 'required|string',
            'kategori_tiket' => 'required|string|max:255',
            'ruangan'     => 'required|string|max:255',

        ]);

        $uploadedImagePath = null; // To store the full URL of the uploaded image for the response

        // 2. Handle image upload if present (retaining original logic structure)
        if ($request->hasFile('gambar')) {
            $file     = $request->file('gambar');
            // Generate a more robust filename to prevent collisions
            $fileName = time() . '_' . $file->getClientOriginalName(); 
    
            // Simpan file ke public/images/tiket
            $file->move(public_path('images/tiket'), $fileName);
            
            // Construct the relative path for the uploaded image
            $uploadedImagePath =$fileName;
        }

        // 3. Generate 'no_tiket' and set 'pembuat_tiket' and default 'status_tiket'
        $noTiket = 'TKT-' . time(); // Simple unique ticket number based on timestamp
        $pembuatTiket =Auth::user()->id; // Get the ID of the authenticated user

        // 4. Create TiketPerbaikan record using ONLY the fields specified in file_context_0
        $tiket = TiketPerbaikan::create([
            'no_tiket'       => $noTiket,
            'pembuat_tiket'  => $pembuatTiket,
            'tgl_pembuatan'  => date('Y-m-d H:i:s'),
            'departemen'     => $validatedData['departemen'],
            'ruangan'     => $validatedData['ruangan'],
            'subjek_tiket'   => $validatedData['subjek_tiket'],
            'desc_tiket'     => $validatedData['desc_tiket'],
            'kategori_tiket' => $validatedData['kategori_tiket'],
            'status_tiket'   => '1', 
            'prioritas_tiket' => $validatedData['prioritas_tiket'],
            'gambar'          => $uploadedImagePath,
            // Note: 'gambar_path' is not included here as it was not in file_context_0
        ]);

        // notif wa - Send to multiple admins
        // Get admins for the specific ticket category, eager load their user details
        // Assumes AdminTiket model has a 'user' relationship to the User model,
        // and the User model has a 'phone_number' field.
        $admins = AdminTiket::where('admin_tipe', $validatedData['kategori_tiket'])->get();
        $departemenName = Unit::find($validatedData['departemen'])->nama_unit ?? 'N/A';
        $ruanganName = Ruangan::find($validatedData['ruangan'])->nama_ruangan ?? 'N/A';

        // // Prepare the message content
        // $creatorName = Auth::user()->name ? Auth::user()->name : 'Pengguna Tidak Dikenal'; // Get creator's name
        // foreach ($admins as $admin) {
        //     if ($admin->phone_number) {
        //         $adminName = $admin->nama_admin ?? 'Admin'; // Get admin's name, default to 'Admin' if null

        //         $whatsappMessage = "🔔 Notifikasi Tiket Baru untuk *" . $adminName . "* 🔔\n\n" .
        //                            "No. Tiket: *" . $noTiket . "*\n" .
        //                            "Subjek: *" . $validatedData['subjek_tiket'] . "*\n" .
        //                            "Departemen: *" . $departemenName . "*\n" . // Added department name
        //                            "Ruangan: *" . $ruanganName . "*\n" .     // Added room name
        //                            "Dibuat Oleh: *" . $creatorName . "*\n" .
        //                            "Mohon segera ditindaklanjuti.\n" .
        //                            "Link: http://192.168.1.101:8001/signin";

        //         // Format phone number to international format (e.g., '62' for Indonesia)
        //         $formattedNumber = preg_replace('/[^0-9]/', '', $admin->phone_number);
        //         if (substr($formattedNumber, 0, 1) === '0') {
        //             $formattedNumber = '62' . substr($formattedNumber, 1);
        //         } elseif (substr($formattedNumber, 0, 2) !== '62') {
        //             // If it doesn't start with 0 or 62, assume it's a local number and prepend 62
        //             $formattedNumber = '62' . $formattedNumber;
        //         }

        //         // Send message via HTTP client
        //         Http::post('http://localhost:8000/send-message', [
        //             'number' => $formattedNumber,
        //             'message' => $whatsappMessage,
        //         ]);
        //         // Optional: Add logging for successful/failed sends to individual admins if needed
        //     }
        // }

        
        // 5. Return a success response for the ticket creation, including image path if uploaded
        return response()->json([
            'success' => true,
            'message' => 'Tiket perbaikan berhasil dibuat.',
            'tiket'   => $tiket,
            'gambar_uploaded_path' => $uploadedImagePath, // Return the path of the uploaded image, if any
        ], 201); // Use 201 Created status code for successful resource creation
    }
    
   // Menampilkan semua unit
   public function getUnits()
   {
       $units = Unit::all();
       return response()->json($units);
   }

   // Menampilkan ruangan berdasarkan unit
   public function getRuangansByUnit($id_unit)
   {
       $ruangans = Ruangan::where('id_unit', $id_unit)->get();
       return response()->json($ruangans);
   }

   // Menampilkan aset berdasarkan ruangan
   public function getAsetsByRuangan($id_ruangan)
   {
       $asets = MasterAset::where('id_ruangan', $id_ruangan)->get();
       return response()->json($asets);
   }

   // Menampilkan unit lengkap dengan ruangan & aset
   public function getUnitWithRelations($id_unit)
   {
       $unit = Unit::with('ruangans.asets')->find($id_unit);
       return response()->json($unit);
   }

    public function analytics()
    {
        return view('pages/dashboard/analytics');
    }

    /**
     * Displays the fintech screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fintech()
    {
        return view('pages/dashboard/fintech');
    }
}
