<div class="col-span-12 bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-gray-200 dark:border-gray-700 p-6">
    <h2 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold mb-4">Master Aset & Mutasi</h2>

    <button class="btn bg-indigo-500 text-white hover:bg-indigo-600 mb-4" id="btnTambahAset">
        + Tambah Aset
    </button>

    <div class="overflow-x-auto">
        <table id="asetDataTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3"></th> {{-- For expand/collapse icon --}}
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kode Aset</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Aset</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ruangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                {{-- Aset data will be loaded here by DataTables --}}
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah/Edit Aset -->
<div id="modalAset" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center hidden" role="dialog" aria-modal="true" aria-labelledby="modalAsetTitle">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg mx-auto max-h-[600px] overflow-y-auto">
        <form id="formAset">
            @csrf
            <input type="hidden" name="id_aset" id="id_aset">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="modalAsetTitle">Tambah Aset</h5>
                <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" data-modal-hide="modalAset">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="flex-grow"> {{-- Removed overflow-y-auto here as it's now on the parent div --}}
                <div class="py-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4 md:col-span-2">
                        <label for="nama_aset" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Aset</label>
                        <input type="text" name="nama_aset" id="nama_aset" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="kode_aset" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Aset</label>
                        <input type="text" name="kode_aset" id="kode_aset" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="tipe_aset" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Aset</label>
                        <input type="text" name="tipe_aset" id="tipe_aset" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="id_ruangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ruangan</label>
                        <select name="id_ruangan" id="id_ruangan" style="width: 100%; height: 38px; border: 1px solid #ced4da; border-radius: 4px;" class="ruangan-select mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                            <option value="">Pilih Ruangan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="merk" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Merk</label>
                        <input type="text" name="merk" id="merk" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="kapasitas_pk" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kapasitas PK</label>
                        <input type="number" step="0.01" name="kapasitas_pk" id="kapasitas_pk" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="jenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis</label>
                        <input type="text" name="jenis" id="jenis" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="sn" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serial Number (SN)</label>
                        <input type="text" name="sn" id="sn" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <!-- <div class="mb-4">
                        <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                        <select name="kategori" id="kategori" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                            <option value="">Pilih Kategori</option>
                            <option value="1">SIMRS</option>
                            <option value="2">PSRS</option>
                        </select>
                    </div> -->
                    <div class="mb-4">
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="tanggal_pemasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pemasangan</label>
                        <input type="date" name="tanggal_pemasangan" id="tanggal_pemasangan" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="tanggal_pembelian" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pembelian</label>
                        <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="nilai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai</label>
                        <input type="number" step="0.01" name="nilai" id="nilai" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="masa_depresiasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Masa Depresiasi (Tahun)</label>
                        <input type="number" name="masa_depresiasi" id="masa_depresiasi" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                    </div>
                    <div class="mb-4 md:col-span-2">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm"></textarea>
                    </div>
                    <div class="mb-4 md:col-span-2">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Mutasi -->
<div id="modalMutasi" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center hidden" role="dialog" aria-modal="true" aria-labelledby="modalMutasiTitle">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg mx-auto">
        <form id="formMutasi">
            @csrf
            <input type="hidden" name="id_aset" id="mutasi_id_aset">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="modalMutasiTitle">Tambah Mutasi Aset</h5>
                <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" data-modal-hide="modalMutasi">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="py-4">
                <div class="mb-4">
                    <label for="tanggal_mutasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mutasi</label>
                    <input type="date" name="tanggal_mutasi" id="tanggal_mutasi" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="id_ruangan_tujuan" class="block text-sm font-medium text-gray-700">Ruangan Tujuan</label>
                    <select name="id_ruangan_tujuan" id="id_ruangan_tujuan" style="width: 100%; height: 38px; border: 1px solid #ced4da; border-radius: 4px;" class="ruangan-select mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Pilih Ruangan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="keterangan_mutasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                    <textarea name="keterangan" id="keterangan_mutasi" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm"></textarea>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan Mutasi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Spek Detail -->
<div id="modalSpekDetail" class="hidden fixed inset-0 z-50 overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen px-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl">
      
      <!-- Header -->
      <div class="flex justify-between items-center border-b p-4">
        <h3 id="modalSpekDetailTitle" class="text-lg font-semibold text-gray-900 dark:text-gray-100">
          Tambah Spek Detail
        </h3>
        <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" data-modal-hide="modalSpekDetail">
            <span class="sr-only">Close</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
      </div>

      <!-- Body -->
      <div class="p-6">
        <form id="formSpekDetail">
          @csrf
          <input type="hidden" id="id_aset_detail_aset" name="id_aset">

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Processor</label>
              <input type="text" name="processor" id="processor" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">RAM</label>
              <input type="text" name="ram" id="ram" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">HDD</label>
              <input type="text" name="hdd" id="hdd" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">SSD</label>
              <input type="text" name="ssd" id="ssd" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">VGA</label>
              <input type="text" name="vga" id="vga" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Motherboard</label>
              <input type="text" name="motherboard" id="motherboard" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PSU</label>
              <input type="text" name="psu" id="psu" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="col-span-2">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Spesifikasi Lain</label>
              <textarea name="spesifikasi_lain" id="spesifikasi_lain" rows="3" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"></textarea>
            </div>
          </div>
        </form>
      </div>

      <!-- Footer -->
      <div class="flex justify-between border-t p-4">
        <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-100 dark:hover:bg-gray-500" data-modal-hide="modalSpekDetail">Batal</button>
        <button id="btnSaveSpekDetail" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"> Simpan </button>
      </div>

    </div>
  </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


<script>
    $(document).ready(function(){

        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize Select2 for ruangan dropdowns with AJAX
        $('.ruangan-select').select2({
            placeholder: "Pilih Ruangan",
            allowClear: true,
            ajax: {
                url: "{{ route('tiket.ruangan') }}", // route ke getRuangan()
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search keyword
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.results.map(function (item) {
                            return {
                                id: item.id_ruangan,
                                text: item.nama_ruangan
                            };
                        }),
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 0
        });
        
        // Helper function to show a modal
        function showModal(modalId) {
            $('#' + modalId).removeClass('hidden');
        }

        // Helper function to hide a modal
        function hideModal(modalId) {
            $('#' + modalId).addClass('hidden');
        }

        // Close modals when clicking on the close button (data-modal-hide)
        $('[data-modal-hide]').on('click', function() {
            const modalId = $(this).data('modal-hide');
            hideModal(modalId);
        });

        var asetDataTable; // Declare DataTables instance globally

        // Function to format the child row (mutasi history)
        function formatMutasi(d) {
            let mutasiHtml = `
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md shadow-inner">
                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Riwayat Mutasi</h4>
                    <ul class="space-y-2">
            `;
            if (d.mutasi_aset && d.mutasi_aset.length > 0) {
                d.mutasi_aset.forEach(function(mutasi) {
                    let ruanganAwal = mutasi.ruangan_awal ? mutasi.ruangan_awal.nama_ruangan : '-';
                    let ruanganTujuan = mutasi.ruangan_tujuan ? mutasi.ruangan_tujuan.nama_ruangan : '-';
                    mutasiHtml += `
                        <li class="flex items-center justify-between bg-white dark:bg-gray-800 p-2 rounded-md shadow-sm">
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                ${mutasi.tanggal_mutasi || '-'}:
                                ${ruanganAwal} →
                                ${ruanganTujuan}
                                (${mutasi.keterangan || '-'})
                            </span>
                            <button class="px-2 py-1 text-xs text-white bg-red-500 rounded-md hover:bg-red-600 btnHapusMutasi" data-id="${mutasi.id_mutasi}">Hapus</button>
                        </li>
                    `;
                });
            } else {
                mutasiHtml += `
                    <li class="text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat mutasi.</li>
                `;
            }
            mutasiHtml += `
                    </ul>
                </div>
            `;
            return mutasiHtml;
        }

        // Function to format the child row (mutasi and spec history)
        function formatCombinedDetails(d) {
            let html = `
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md shadow-inner space-y-6">
            `;

            // Mutasi History Section
            html += `
                    <div>
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Riwayat Mutasi</h4>
                        <ul class="space-y-2">
            `;
            if (d.mutasi_aset && d.mutasi_aset.length > 0) {
                d.mutasi_aset.forEach(function(mutasi) {
                    let ruanganAwal = mutasi.ruangan_awal ? mutasi.ruangan_awal.nama_ruangan : '-';
                    let ruanganTujuan = mutasi.ruangan_tujuan ? mutasi.ruangan_tujuan.nama_ruangan : '-';
                    html += `
                        <li class="flex items-center justify-between bg-white dark:bg-gray-800 p-2 rounded-md shadow-sm">
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                ${mutasi.tanggal_mutasi || '-'}:
                                ${ruanganAwal} →
                                ${ruanganTujuan}
                                (${mutasi.keterangan || '-'})
                            </span>
                            <button class="px-2 py-1 text-xs text-white bg-red-500 rounded-md hover:bg-red-600 btnHapusMutasi" data-id="${mutasi.id_mutasi}">Hapus</button>
                        </li>
                    `;
                });
            } else {
                html += `
                    <li class="text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat mutasi.</li>
                `;
            }
            html += `
                        </ul>
                    </div>
            `;

            // Spesifikasi Detail History Section
            html += `
                    <div>
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Riwayat Spesifikasi Detail</h4>
                        <ul class="space-y-2">
            `;
            if (d.aset_spesifikasi && d.aset_spesifikasi.length > 0) {
                // Sort by created_at descending to show latest first
                const sortedSpecs = [...d.aset_spesifikasi].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                sortedSpecs.forEach(function(spec) {
                    const specDate = spec.created_at ? new Date(spec.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }) : '-';
                    html += `
                        <li class="bg-white dark:bg-gray-800 p-3 rounded-md shadow-sm">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-1 text-sm text-gray-700 dark:text-gray-300">
                                <div><span class="font-semibold">Processor:</span> ${spec.processor || '-'}</div>
                                <div><span class="font-semibold">RAM:</span> ${spec.ram || '-'}</div>
                                <div><span class="font-semibold">HDD:</span> ${spec.hdd || '-'}</div>
                                <div><span class="font-semibold">SSD:</span> ${spec.ssd || '-'}</div>
                                <div><span class="font-semibold">VGA:</span> ${spec.vga || '-'}</div>
                                <div><span class="font-semibold">Motherboard:</span> ${spec.motherboard || '-'}</div>
                                <div><span class="font-semibold">PSU:</span> ${spec.psu || '-'}</div>
                                <div><span class="font-semibold">Spesifikasi:</span> ${spec.spesifikasi_lain || '-'}</div>
                            </div>
                        </li>
                    `;
                });
            } else {
                html += `
                    <li class="text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat spesifikasi detail.</li>
                `;
            }
            html += `
                        </ul>
                    </div>
                </div>
            `;
            return html;
        }

        // Initialize DataTables
        asetDataTable = $('#asetDataTable').DataTable({
            processing: true,
            serverSide: false, // Client-side processing for now
            ajax: {
                url: "{{ route('tiket.data.aset') }}", // New route for JSON data
                type: 'GET',
                dataSrc: '' // Changed from 'asets' to '' - assuming the JSON response is a direct array of objects
            },
            columns: [
                {
                    "className": 'details-control text-center',
                    "orderable": false,
                    "data": null,
                    "defaultContent": '<i class="fa fa-plus-circle text-indigo-500 cursor-pointer"></i>' // Expand icon
                },
                { data: 'kode_aset', name: 'kode_aset', defaultContent: '-' },
                
                { data: 'nama_aset', name: 'nama_aset', defaultContent: '-' },
                {
                    data: 'kategori',
                    name: 'kategori',
                    defaultContent: '-',
                    render: function(data, type, row) {
                        if (data === '1') {
                            return 'SIMRS';
                        } else if (data === '2') {
                            return 'PSRS';
                        }
                        return data || '-'; // Fallback for other values or null
                    }
                },
                {
                    data: 'ruangan.nama_ruangan', // Keep this for DataTables' internal sorting/searching
                    name: 'ruangan.nama_ruangan',
                    defaultContent: '-',
                    render: function(data, type, row) {
                        return `<span class="ruangan_nama" data-ruangan-id="${row.id_ruangan || ''}">${data || '-'}</span>`;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        let statusText = '';
                        let statusClass = '';
                        if (data === '1') {
                            statusText = 'Aktif';
                            statusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                        } else if (data === '0') {
                            statusText = 'Nonaktif';
                            statusClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                        } else {
                            statusText = '-';
                            statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                        }
                        return `<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}" data-status="${data}">
                                    ${statusText}
                                </span>`;
                    }
                },
                {
                    data: 'id_aset',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button class="px-2 py-1 text-xs text-white bg-yellow-500 rounded-md hover:bg-yellow-600 btnEditAset" data-id="${data}">Edit</button>
                            <button class="px-2 py-1 text-xs text-white bg-indigo-500 rounded-md hover:bg-indigo-600 btnTambahMutasi" data-id="${data}">+ Mutasi</button>
                            <button class="px-2 py-1 text-xs text-white bg-blue-500 rounded-md hover:bg-blue-600 btnSpekDetail" data-id="${data}">Spek Detail</button>
                        `;
                    }
                }
            ],
            order: [[1, 'asc']] // Order by Kode Aset by default
        });

        // Add event listener for opening and closing details (mutasi history)
        $('#asetDataTable tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = asetDataTable.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
                $(this).find('i').removeClass('fa-minus-circle').addClass('fa-plus-circle');
            } else {
                // Open this row
                // Assuming row.data() already contains 'mutasi_aset' and 'aset_spesifikasi' from the AJAX source
                row.child(formatCombinedDetails(row.data())).show(); // Call the new combined function
                tr.addClass('shown');
                $(this).find('i').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            }
        });

        // Tambah Aset
        $('#btnTambahAset').click(function(){
            $('#formAset')[0].reset();
            $('#id_aset').val('');
            $('#modalAsetTitle').text('Tambah Aset');
            $('#id_ruangan').val(null).trigger('change'); // Reset Select2
            showModal('modalAset');
        });

        // Edit Aset (using event delegation on DataTable)
        $('#asetDataTable tbody').on('click', '.btnEditAset', function(){
            let id = $(this).data('id');
            
            $.ajax({
                url: `{{ route('tiket.aset.show', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id),
                method: 'GET',
                success: function(response) {
                    if (response.success && response.aset) {
                        let aset = response.aset;
                        $('#id_aset').val(aset.id_aset);
                        $('#nama_aset').val(aset.nama_aset);
                        $('#merk').val(aset.merk);
                        $('#kapasitas_pk').val(aset.kapasitas_pk);
                        $('#jenis').val(aset.jenis);
                        $('#sn').val(aset.sn);
                        $('#kategori').val(aset.kategori).trigger('change');
                        $('#lokasi').val(aset.lokasi);
                        $('#tanggal_pemasangan').val(aset.tanggal_pemasangan);
                        $('#tanggal_pembelian').val(aset.tanggal_pembelian);
                        $('#nilai').val(aset.nilai);
                        $('#masa_depresiasi').val(aset.masa_depresiasi);
                        $('#keterangan').val(aset.keterangan);
                        $('#status').val(aset.status);


                        // Set Select2 value for ruangan
                        if (aset.id_ruangan && aset.ruangan && aset.ruangan.nama_ruangan) {
                            let option = new Option(aset.ruangan.nama_ruangan, aset.id_ruangan, true, true);
                            $('#id_ruangan').append(option).trigger('change');
                        } else {
                            $('#id_ruangan').val(null).trigger('change');
                        }
                        
                        $('#modalAsetTitle').text('Edit Aset');
                        showModal('modalAset');
                    } else {
                        alert('Gagal memuat data aset untuk diedit: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat memuat data aset.');
                    console.error(xhr.responseText);
                }
            });
        });

        // Simpan Aset (Tambah/Update)
        $('#formAset').submit(function(e){
            e.preventDefault();
            let id = $('#id_aset').val();
            let url = id ? `{{ route('tiket.aset.update', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id) : `{{ route("tiket.aset.store") }}`;
            let type = id ? "PUT" : "POST";

            $.ajax({
                url: url,
                type: type,
                data: $(this).serialize(),
                success: function(res){
                    if (res.success) {
                        hideModal('modalAset');
                        asetDataTable.ajax.reload(null, false); // Reload table data without resetting pagination
                    } else {
                        alert('Gagal menyimpan aset: ' + res.message);
                    }
                },
                error: function(xhr){
                    alert('Terjadi kesalahan saat menyimpan aset.');
                    console.error(xhr.responseText);
                }
            });
        });

        // Hapus Aset (using event delegation on DataTable)
        $('#asetDataTable tbody').on('click', '.btnHapusAset', function(){
            let id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus aset ini?')) {
                $.ajax({
                    url: `{{ route('tiket.aset.destroy', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id),
                    type: "DELETE",
                    success: function(res){
                        if (res.success) {
                            asetDataTable.ajax.reload(null, false); // Reload table data
                        } else {
                            alert('Gagal menghapus aset: ' + res.message);
                        }
                    },
                    error: function(xhr){
                        alert('Terjadi kesalahan saat menghapus aset.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        // Tambah Mutasi (using event delegation on DataTable)
        $('#asetDataTable tbody').on('click', '.btnTambahMutasi', function(){
            let id_aset = $(this).data('id');
            $('#formMutasi')[0].reset();
            $('#mutasi_id_aset').val(id_aset);
            $('#tanggal_mutasi').val(new Date().toISOString().slice(0,10)); // Set default date to today
            $('#id_ruangan_tujuan').val(null).trigger('change'); // Reset Select2
            $('#modalMutasiTitle').text('Tambah Mutasi untuk Aset #' + id_aset);
            showModal('modalMutasi');
        });

        // Simpan Mutasi
        $('#formMutasi').submit(function(e){
            e.preventDefault();
            let id_aset = $('#mutasi_id_aset').val();
            let url = `{{ route('tiket.aset.mutasi.store', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id_aset);
            
            $.ajax({
                url: url,
                type: "POST",
                data: $(this).serialize(),
                success: function(res){
                    if (res.success) {
                        hideModal('modalMutasi');
                        asetDataTable.ajax.reload(null, false); // Reload table data
                    } else {
                        alert('Gagal menyimpan mutasi: ' + res.message);
                    }
                },
                error: function(xhr){
                    alert('Terjadi kesalahan saat menyimpan mutasi.');
                    console.error(xhr.responseText);
                }
            });
        });

        // Hapus Mutasi (using event delegation on DataTable)
        $('#asetDataTable tbody').on('click', '.btnHapusMutasi', function(){
            let id_mutasi = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus riwayat mutasi ini?')) {
                $.ajax({
                    url: `{{ route('tiket.aset.mutasi.destroy', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id_mutasi),
                    type: "DELETE",
                    success: function(res){
                        if (res.success) {
                            asetDataTable.ajax.reload(null, false); // Reload table data
                        } else {
                            alert('Gagal menghapus mutasi: ' + res.message);
                        }
                    },
                    error: function(xhr){
                        alert('Terjadi kesalahan saat menghapus mutasi.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        // Show modal Spek Detail
        $('#asetDataTable tbody').on('click', '.btnSpekDetail', function () {
            let id_aset = $(this).data('id');
            $('#id_aset_detail_aset').val(id_aset); // Set id_aset in hidden input
            $('#formSpekDetail')[0].reset(); // Reset form fields
            $('#modalSpekDetailTitle').text('Tambah Spek Detail'); // Default title

            // Ensure a hidden input for id_spesifikasi_to_edit exists and clear it
            let $idSpekToEditInput = $('#id_spesifikasi_to_edit');
            if ($idSpekToEditInput.length === 0) {
                $idSpekToEditInput = $('<input type="hidden" id="id_spesifikasi_to_edit" name="id_spesifikasi_to_edit">');
                $('#formSpekDetail').append($idSpekToEditInput);
            }
            $idSpekToEditInput.val(''); // Clear any previous value

            // First, fetch all specs for this asset to find the active one.
            // This is necessary because the button provides id_aset, but aset.detail.show expects id_detail.
            $.ajax({
                url: `{{ route('aset.detail.index', ['id_aset' => 'ID_ASET_PLACEHOLDER']) }}`.replace('ID_ASET_PLACEHOLDER', id_aset),
                method: "GET",
                success: function (specs) {
                    let activeSpecId = null;
                    if (specs.length > 0) {
                        // Assuming the first item in the response (ordered by created_at desc) is the active/most recent spec
                        activeSpecId = specs[0].id_spesifikasi;
                    }

                    if (activeSpecId) {
                        // If an active spec ID is found, then use aset.detail.show to get its full details
                        // This strictly follows the instruction to "manggil route aset.detail.show"
                        $.ajax({
                            url: `{{ route('aset.detail.show', ['id_detail' => 'ID_DETAIL_PLACEHOLDER']) }}`.replace('ID_DETAIL_PLACEHOLDER', activeSpecId),
                            method: "GET",
                            success: function (detail) {
                                $('#modalSpekDetailTitle').text('Edit Spek Detail');

                                // Populate form fields
                                $('#processor').val(detail.processor);
                                $('#ram').val(detail.ram);
                                $('#hdd').val(detail.hdd);
                                $('#ssd').val(detail.ssd);
                                $('#vga').val(detail.vga);
                                $('#motherboard').val(detail.motherboard);
                                $('#psu').val(detail.psu);
                                $('#spesifikasi_lain').val(detail.spesifikasi_lain);

                                // Store id_spesifikasi for update operation
                                $idSpekToEditInput.val(detail.id_spesifikasi);
                                showModal('modalSpekDetail');
                            },
                            error: function (xhr) {
                                console.error("Error fetching specific spec detail:", xhr.responseText);
                                alert('Gagal mengambil detail spesifikasi.');
                                showModal('modalSpekDetail'); // Show modal even if second fetch fails, but form will be empty
                            }
                        });
                    } else {
                        // No active spec found, show empty form for adding new
                        showModal('modalSpekDetail');
                    }
                },
                error: function (xhr) {
                    console.error("Error fetching spec list:", xhr.responseText);
                    alert('Gagal mengambil daftar spesifikasi.');
                    showModal('modalSpekDetail'); // Show modal even if first fetch fails, but form will be empty
                }
            });
        });

        // Save Spek Detail
        $('#btnSaveSpekDetail').on('click', function (e) {
            e.preventDefault();

            let formData = $('#formSpekDetail').serialize();

            $.ajax({
                url: "{{ route('aset.detail.store') }}",
                method: "POST",
                data: formData,
                success: function (res) {
                    if (res.success) {
                        alert('Spek berhasil disimpan!');
                        hideModal('modalSpekDetail');
                        asetDataTable.ajax.reload(null, false); // reload tanpa reset paging
                    } else {
                        alert('Gagal menyimpan spek');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Terjadi kesalahan!');
                }
            });
        });

        function showModal(id) {
            $('#' + id).removeClass('hidden');
        }
        function hideModal(id) {
            $('#' + id).addClass('hidden');
        }


    });
</script>
