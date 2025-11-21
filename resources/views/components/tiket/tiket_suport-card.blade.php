
<!-- <body class="bg-gray-100 min-h-screen p-6"> -->




<body class="bg-gray-100 min-h-screen p-5">
   
    <div class="col-span-12 bg-white rounded-xl shadow-md p-5">
        <div class="flex justify-between items-center mb-5">
            <!-- Header -->
            <h1 class="text-2xl font-bold text-gray-800">IT Support Task</h1>
            <!-- Tombol Tambah Aset -->
            <button id="btnTambahAset" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-plus mr-2"></i> Tambah Aset
            </button>
        </div>

        <div class="flex space-x-5 border-b border-gray-200 mb-6">
            <button onclick="showTab('waiting')" id="tab-waiting" class="relative text-yellow-500 font-semibold pb-3 border-b-2 border-yellow-500 focus:outline-none">
                Waiting
                <span class="absolute -top-3 -right-4 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full"></span>
            </button>
            <button onclick="showTab('process')" id="tab-process" class="relative text-gray-500 hover:text-gray-700 font-semibold pb-3 border-b-2 border-transparent focus:outline-none">
                On Process
                <span class="absolute -top-3 -right-4 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full"></span>
            </button>
            <button onclick="showTab('pending')" id="tab-pending" class="relative text-gray-500 hover:text-gray-700 font-semibold pb-3 border-b-2 border-transparent focus:outline-none">
                Pending
                <span class="absolute -top-3 -right-4 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full"></span>
            </button>
            <button onclick="showTab('done')" id="tab-done" class="relative text-gray-500 hover:text-gray-700 font-semibold pb-3 border-b-2 border-transparent focus:outline-none">
                Done
                <span class="absolute -top-3 -right-4 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full"></span>
            </button>
        </div>

    <div id="content-waiting" class="tab-content space-y-4">
        <div id="waitingTicketsContainer" class="space-y-4">
            <!-- Tickets will be loaded here via AJAX -->
            <div class="text-center text-gray-500 py-8" id="loadingWaitingTickets">
                <i class="fas fa-spinner fa-spin mr-2"></i> Memuat tiket menunggu...
            </div>
        </div>
    </div>

    <div id="content-process" class="tab-content space-y-4 hidden">
        <div class="text-center text-gray-500 py-8" id="loadingProcessTickets">
            <i class="fas fa-spinner fa-spin mr-2"></i> Memuat tiket sedang diproses...
        </div>
        <div id="processTicketsContainer" class="space-y-4">
            <!-- Process tickets will be loaded here via AJAX -->
        </div>
    </div>
      <!-- Mark as Done Modal -->
    <div id="markAsDoneModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="relative bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 max-h-[90vh] flex flex-col">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Mark Ticket #<span id="doneTicketNumber"></span> as Done</h3>
                <button onclick="closeModal('markAsDoneModal')" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-5 overflow-y-auto flex-grow min-h-0">
                <form id="markAsDoneForm" data-ticket-id="" action="{{ route('tiket.markAsDone', ['id' => ':id']) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                        <select name="unit" id="unit" class="unit-select mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm h-10">
                            <option value="">Pilih Unit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ruangan" class="block mb-1 text-sm font-medium text-gray-700">Ruangan</label>
                        <select name="ruangan" id="ruangan" class="ruangan mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Pilih Ruangan</option>
                            {{-- Options will be dynamically added or pre-loaded --}}
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="problemDescription" class="block text-sm font-medium text-gray-700">Deskripsi Permasalahan</label>
                        <textarea id="problemDescription" name="desc_done" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Jelaskan permasalahan secara detail"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Detail Aset, Masalah & Penyelesaian</label>
                        <div id="detailRowsContainer" class="space-y-4">
                        </div>
                        <button type="button" id="addRowBtn" class="add-row-btn px-4 py-2 mt-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm">Tambah Baris Detail</button>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Penyelesaian</label>
                        <div id="solutionImageRowsContainer" class="space-y-4">
                            <div class="p-3 border border-gray-200 rounded-md bg-gray-50 solution-image-row">
                                <div class="mb-2">
                                    <label for="solutionImage_1" class="block text-sm font-medium text-gray-700">Upload Gambar</label>
                                    <input type="file" name="gambar_perbaikan[]" id="solutionImage_1"
                                           class="mt-1 block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-md file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-blue-50 file:text-blue-700
                                                  hover:file:bg-blue-100"
                                           accept="image/*" onchange="previewSolutionImage(event, 'solutionImagePreview_1', 'removeSolutionImageBtn_1', 'solutionImagePreviewContainer_1')">
                                </div>
                                <div id="solutionImagePreviewContainer_1" class="mt-2 hidden">
                                    <img id="solutionImagePreview_1" src="#" alt="Image Preview" class="max-w-full h-auto rounded-md border border-gray-300">
                                    <button type="button" id="removeSolutionImageBtn_1" onclick="removeSolutionImage('solutionImage_1', 'solutionImagePreview_1', 'removeSolutionImageBtn_1', 'solutionImagePreviewContainer_1')"
                                            class="mt-2 px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs hidden">Hapus Gambar</button>
                                </div>
                                <div class="flex justify-end mt-3">
                                    <button type="button" class="remove-solution-image-row-btn px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm hidden">Hapus Baris</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="addSolutionImageBtn" class="add-solution-image-btn px-4 py-2 mt-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm">Tambah Gambar</button>
                    </div>

                  
                </form>
            </div>
            <div class="flex justify-end p-5 border-t">
                <button type="button" onclick="closeModal('markAsDoneModal')" class="mr-2 px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">Batal</button>
                <button type="button" onclick="markTicketAsDoneFromModal()" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-md">Ya, Tandai Selesai</button>
            </div>
        </div>
    </div>

    <!-- Mark as Pending Modal -->
    <div id="markAsPendingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="relative bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 max-h-[90vh] flex flex-col">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Mark Ticket #<span id="pendingTicketNumber"></span> as Pending</h3>
                <button onclick="closeModal('markAsPendingModal')" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-5 overflow-y-auto flex-grow min-h-0">
                <form id="markAsPendingForm" data-ticket-id="" action="{{ route('tiket.pending', ['id' => ':id']) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="desc_pending" class="block text-sm font-medium text-gray-700">Alasan Pending</label>
                        <textarea id="desc_pending" name="desc_pending" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm" placeholder="Jelaskan alasan tiket ini ditunda"></textarea>
                    </div>
                </form>
            </div>
            <div class="flex justify-end p-5 border-t">
                <button type="button" onclick="closeModal('markAsPendingModal')" class="mr-2 px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">Batal</button>
                <button type="button" onclick="markTicketAsPendingFromModal()" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Ya, Tandai Pending</button>
            </div>
        </div>
    </div>
  
    <div id="content-pending" class="tab-content space-y-4 hidden">
        <div id="loadingPendingTickets" class="text-center py-8 hidden">
            <i class="fas fa-spinner fa-spin text-yellow-500 text-3xl"></i>
            <p class="text-gray-500 mt-2">Memuat tiket pending...</p>
        </div>
        <div id="pendingTicketsContainer" class="space-y-4">
            <!-- Pending tickets will be loaded here by JavaScript -->
        </div>
    </div>

    <div id="content-done" class="tab-content space-y-4 hidden">
        <div id="loadingDoneTickets" class="text-center py-8 hidden">
            <i class="fas fa-spinner fa-spin text-blue-500 text-2xl"></i>
            <p class="text-gray-500">Memuat tiket selesai...</p>
        </div>
        <div id="doneTicketsContainer" class="space-y-4">
            <!-- Done tickets will be loaded here by JavaScript -->
        </div>

        <!-- Ticket Details and Images Modal -->
        <div id="ticketDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-900" id="ticketDetailsModalTitle">Detail Tiket</h3>
                    <button onclick="closeModal('ticketDetailsModal')" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="ticketDetailsModalLoading" class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-blue-500 text-2xl"></i>
                    <p class="text-gray-500">Memuat detail tiket...</p>
                </div>
                <div id="ticketDetailsModalContent" class="mt-4 max-h-96 overflow-y-auto hidden">
                    <!-- Content will be loaded here dynamically -->
                </div>
            </div>
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
                        <div class="mb-4">
                            <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                            <select name="kategori" id="kategori" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                <option value="">Pilih Kategori</option>
                                <option value="1">SIMRS</option>
                                <option value="2">PSRS</option>
                            </select>
                        </div>
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
    
        
</body>

   
    <script>
        // ini untuk show tab
            function showTab(tab) {
                // Sembunyikan semua tab content
                document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));

                // Hapus style aktif pada semua tab
                document.querySelectorAll('button').forEach(btn => {
                    btn.classList.remove('text-yellow-500', 'border-yellow-500');
                    btn.classList.add('text-gray-500', 'border-transparent');
                });

                // Tampilkan tab yang dipilih
                document.getElementById('content-' + tab).classList.remove('hidden');
                
                // Aktifkan style tab yang diklik
                document.getElementById('tab-' + tab).classList.add('text-yellow-500', 'border-yellow-500');
                document.getElementById('tab-' + tab).classList.remove('text-gray-500', 'border-transparent');

                // Load tickets for the active tab
                if (tab === 'waiting') {
                    loadWaitingTickets();
                } else if (tab === 'process') {

                    loadProcessTickets();
                } else if (tab === 'pending') {
                    loadPendingTickets();
                } else if (tab === 'done') {
                    loadDoneTickets();
                }
            }


        // ini untuk image preview
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scrolling on body when modal is open
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling on body
                // Specific form and image resets should be handled by dedicated modal close functions,
                // not by this generic close function.

            }

            // Close modal when clicking outside of the modal content
            window.onclick = function(event) {
                const modal = document.getElementById('markAsDoneModal');
                if (event.target == modal) {
                    // Call the specific function that handles resetting the Mark As Done modal's form and images.
                    // This function already exists and correctly calls resetSolutionImageRows().
                    closeMarkAsDoneModal();
                }
            }

            function previewImage(event) {
                const imageInput = event.target;
                const imagePreview = document.getElementById('imagePreview');
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                const removeImageBtn = document.getElementById('removeImageBtn');

                if (imageInput.files && imageInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.classList.remove('hidden');
                        removeImageBtn.classList.remove('hidden');
                    };
                    reader.readAsDataURL(imageInput.files[0]);
                } else {
                    removeImage();
                }
            }

            function removeImage() {
                const imageInput = document.getElementById('ticketImage');
                const imagePreview = document.getElementById('imagePreview');
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                const removeImageBtn = document.getElementById('removeImageBtn');

                imageInput.value = ''; // Clear the file input
                imagePreview.src = '#'; // Clear the image source
                imagePreviewContainer.classList.add('hidden');
                removeImageBtn.classList.add('hidden');
            }

        
    </script>

    <script>
        const currentUserId = "{{ Auth::user()->id }}"; // Get the ID of the currently authenticated user

        // Helper function to generate a new detail row HTML
        let detailRowIndex = 0; // Initialize a counter for unique IDs for dynamically added rows
        function generateDetailRowHtml() {
            detailRowIndex++; // Increment the counter for each new row
            return `
                <div class="p-3 border border-gray-200 rounded-md bg-gray-50 detail-row">
                    <div class="mb-2 w-full">
                        <label class="block text-sm font-medium text-gray-700">Nama Aset</label>
                        <select name="aset_id[]" class="asset-select mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Pilih Aset</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Masalah</label>
                        <input type="text" name="masalah[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Masalah Spesifik">
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Penyelesaian</label>
                        <input type="text" name="penanganan[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Penyelesaian">
                    </div>
                    <div class="mb-2 flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700">Status Aset</label>
                        <label for="status_aset_toggle_${detailRowIndex}" class="relative inline-flex items-center cursor-pointer">
                            <!-- Hidden input to ensure '0' is sent if checkbox is unchecked -->
                            <input type="hidden" name="status_aset[]" value="0">
                            <input type="checkbox" id="status_aset_toggle_${detailRowIndex}" name="status_aset[]" value="1" class="sr-only peer" checked>
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-2 text-sm font-medium text-gray-700">Aktif</span>
                        </label>
                    </div>
                    <div class="flex justify-end mt-3">
                        <button type="button" class="remove-row-btn px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm hidden">Hapus</button>
                    </div>
                </div>
            `;
        }

        // Function to load tickets with 'on_process' status
        function loadProcessTickets() {
            const container = document.getElementById('processTicketsContainer');
            const loadingIndicator = document.getElementById('loadingProcessTickets');
            if (!container) return;

            if (loadingIndicator) loadingIndicator.classList.remove('hidden');
            container.innerHTML = ''; // Clear previous tickets

            fetch('{{ route("tiket.process.data.all") }}') // Assuming this route exists and returns process tickets
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(tickets => {
                    if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    if (tickets.length === 0) {
                        container.innerHTML = '<div class="text-center text-gray-500 py-8">Tidak ada tiket sedang diproses.</div>';
                        return;
                    }

                    tickets.forEach(ticket => {
                        const ticketCategoryText = ticket.kategori_tiket == 1 ? 'SIMRS' : (ticket.kategori_tiket == 2 ? 'PSRS' : 'Kategori Tidak Dikenal');
                        const imageUrl = ticket.gambar ? `{{ asset('images/tiket/') }}/${ticket.gambar}` : '#';
                        const imageLink = ticket.gambar ? `<a href="${imageUrl}" target="_blank" class="text-blue-500 hover:underline">Lihat Gambar</a>` : 'Tidak ada gambar';

                        // Determine if the current user is the one who took the ticket
                        // IMPORTANT: Assuming 'ticket.petugas_proses_id' holds the user ID of the person who took the ticket.
                        // If your backend sends a different field for the user ID (e.g., 'ticket.processor_id'), adjust 'ticket.petugas_proses_id' accordingly.
                        const isCurrentUserProcessor = ticket.petugas_proses.id == currentUserId;

                        let actionButtonsHtml = '';
                        if (isCurrentUserProcessor) {
                            actionButtonsHtml = `
                                <button type="button" onclick="prepareAndOpenDoneModal(${ticket.id}, '${ticket.no_tiket}', ${ticket.departemen.id_unit}, '${ticket.departemen.nama_unit}')" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-md text-sm">
                                    Done
                                </button>
                                <button type="button" onclick="prepareAndOpenPendingModal(${ticket.id}, '${ticket.no_tiket}')" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-sm">
                                    Pending
                                </button>
                            `;
                        } else {
                            actionButtonsHtml = `<span class="text-gray-500 text-sm italic">Hanya petugas yang mengambil tiket ini yang dapat melakukan tindakan.</span>`;
                        }

                        const ticketCardHtml = `
                            <div class="w-full bg-white shadow-md rounded-lg border">
                                <input type="checkbox" id="accordion-ticket-process-${ticket.id}" class="hidden peer" />
                                <label for="accordion-ticket-process-${ticket.id}" class="flex items-center justify-between p-4 bg-blue-100 hover:bg-blue-200 rounded-t-lg cursor-pointer">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-blue-500 p-2 rounded-md">
                                            <img src="{{url('images/iconpack/ticketing/jde.svg')}}" class="w-6 h-6" alt="icon" />
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">${ticketCategoryText} - ${ticket.subjek_tiket}</p>
                                            <p class="text-gray-600 text-xs">Ticket #${ticket.no_tiket} - ${ticket.pembuat_tiket.name}</p>
                                        </div>
                                    </div>
                                    <i class="fas fa-caret-right transform transition-transform duration-300 peer-checked:rotate-90"></i>
                                </label>
                                <div class="accordion_content hidden peer-checked:block border-t p-4">
                                    <table class="w-full text-sm border-collapse">
                                        <tr><td class="font-semibold w-1/3 py-2">Ticket Number</td><td class="py-2">${ticket.no_tiket}</td></tr>
                                        <tr><td class="font-semibold py-2">Name</td><td class="py-2">${ticket.pembuat_tiket.name}</td></tr>
                                        <tr><td class="font-semibold py-2">Department</td><td class="py-2">${ticket.departemen.nama_unit}</td></tr>
                                        <tr><td class="font-semibold py-2">Create Date</td><td class="py-2">${ticket.pembuat_tiket.name}</td></tr>
                                        <tr><td class="font-semibold py-2">Diambil Oleh</td><td class="py-2">${ticket.petugas_proses.name || 'N/A'}</td></tr>
                                        <tr><td class="font-semibold py-2">Waktu Diambil</td><td class="py-2">${ticket.tgl_proses || 'N/A'}</td></tr>
                                        <tr><td class="font-semibold py-2">Subjek Tiket</td><td class="py-2">${ticket.subjek_tiket}</td></tr>
                                        <tr><td class="font-semibold py-2">Deskripsi Tiket</td><td class="py-2">${ticket.desc_tiket}</td></tr>
                                        <tr><td class="font-semibold py-2">Problem Image</td><td class="py-2">${imageLink}</td></tr>
                                        <tr>
                                            <td class="font-semibold py-2">Action</td>
                                            <td class="py-2 flex flex-wrap gap-2">
                                                ${actionButtonsHtml}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', ticketCardHtml);
                    });
                })
                .catch(error => {
                    console.error('Error loading process tickets:', error);
                    if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    container.innerHTML = '<div class="text-center text-red-500 py-8">Gagal memuat tiket. Silakan coba lagi.</div>';
                });
        }

        // Function to prepare and open the Mark as Done modal
        function prepareAndOpenDoneModal(ticketId, ticketNumber, unitId, unitName) {
            const form = document.getElementById('markAsDoneForm');
            const doneTicketNumberSpan = document.getElementById('doneTicketNumber');
            const problemDescriptionTextarea = document.getElementById('problemDescription');
            const detailRowsContainer = document.getElementById('detailRowsContainer');
            const unitSelect = document.getElementById('unit');
            const ruanganSelect = document.getElementById('ruangan');
            

            // Set ticket ID on the form
            form.dataset.ticketId = ticketId;

            // Update modal title dan deskripsi
            doneTicketNumberSpan.textContent = ticketNumber;

            // Reset ruangan
            ruanganSelect.value = '';
            // Panggil ulang loadUnits dan set unitId terpilih setelah selesai load
            loadUnits(unitId);

            // Reset detail row
            detailRowsContainer.innerHTML = generateDetailRowHtml();
            detailRowsContainer.querySelector('.remove-row-btn').classList.add('hidden');

            // Buka modal
            openModal('markAsDoneModal');
        }

        function loadUnits(selectedUnitId = null) {
            $.ajax({
                url: '{{ route("tiket.units") }}',
                method: 'GET',
                success: function(data) {
                    var unitSelect = $('.unit-select');
                    unitSelect.empty();
                    unitSelect.append('<option value="">Pilih Unit</option>');

                    $.each(data, function(index, unit) {
                        unitSelect.append('<option value="' + unit.id_unit + '">' + unit.nama_unit + '</option>');
                    });

                    // Inisialisasi Select2
                    unitSelect.select2({
                        placeholder: "Pilih Unit",
                        allowClear: true
                    });

                    // Jika ada unit yang ingin diset otomatis (misalnya saat edit / modal)
                    if (selectedUnitId) {
                        unitSelect.val(selectedUnitId).trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error loading units: " + error);
                }
            });
        }

        // Function to prepare and open the Mark as Pending modal
        function prepareAndOpenPendingModal(ticketId, ticketNumber) {
            const form = document.getElementById('markAsPendingForm');
            const pendingTicketNumberSpan = document.getElementById('pendingTicketNumber');
            const desc_pendingTextarea = document.getElementById('desc_pending');

            // Set ticket ID on the form
            form.dataset.ticketId = ticketId;
            // Update modal title
            pendingTicketNumberSpan.textContent = ticketNumber;

            // Clear pending reason
            desc_pendingTextarea.value = '';

            // Open the modal
            openModal('markAsPendingModal');
        }

        // Function to handle marking a ticket as Done (called from the generic modal)
        function markTicketAsDoneFromModal() {
            const form = document.getElementById('markAsDoneForm');
            const ticketId = form.dataset.ticketId;

            if (!ticketId) {
                alert('Ticket ID not found for marking as done.');
                return;
            }

            if (!confirm('Apakah Anda yakin ingin menandai tiket ini sebagai selesai?')) return;

            const url = form.action.replace(':id', ticketId);
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            // Handle asset details (multiple rows)
            const detailRows = form.querySelectorAll('.detail-row');
            data.aset_ids = [];
            detailRows.forEach(row => {
                data.aset_ids.push({
                    asset: row.querySelector('select[name="aset_id[]"]').value,
                    problem: row.querySelector('input[name="masalah[]"]').value,
                    solution: row.querySelector('input[name="penanganan[]"]').value,
                });
            });

            const solutionImageRows = form.querySelectorAll('#solutionImageRowsContainer .solution-image-row');
            data.gambar_perbaikans = []; // This array will hold File objects
            solutionImageRows.forEach(row => {
                data.gambar_perbaikans.push({
                    gambar: row.querySelector('input[name="gambar_perbaikan[]"]'),
                });
            });

            // Kirim pakai fetch tanpa Content-Type manual!
            fetch(url, {
                method: 'POST',
                body: formData // ⬅️ biarkan browser yang atur Content-Type
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeModal('markAsDoneModal');
                    loadProcessTickets();
                    if (typeof loadDoneTickets === 'function') loadDoneTickets();
                } else {
                    alert('Gagal menandai tiket sebagai selesai: ' + (data.message || ''));
                }
            })
            .catch(error => {
                console.error('Error marking ticket as done:', error);
                alert('Terjadi kesalahan saat menandai tiket sebagai selesai.');
            });
        }

        // Function to handle marking a ticket as Pending (called from the generic modal)
        function markTicketAsPendingFromModal() {
            const form = document.getElementById('markAsPendingForm');
            const ticketId = form.dataset.ticketId;

            if (!ticketId) {
                alert('Ticket ID not found for marking as pending.');
                return;
            }

            if (!confirm('Apakah Anda yakin ingin menandai tiket ini sebagai pending?')) return;

            const url = form.action.replace(':id', ticketId);
            const desc_pending = document.getElementById('desc_pending').value;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ desc_pending: desc_pending })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeModal('markAsPendingModal');
                    loadProcessTickets(); // Refresh process tickets
                    if (typeof loadPendingTickets === 'function') loadPendingTickets(); // Optionally refresh pending tickets
                } else {
                    alert('Gagal menandai tiket sebagai pending: ' + (data.message || ''));
                }
            })
            .catch(error => {
                console.error('Error marking ticket as pending:', error);
                alert('Terjadi kesalahan saat menandai tiket sebagai pending.');
            });
        }
        


        // Helper function to initialize/re-initialize Select2 for a given element
        // Moved to a global scope to be accessible by all dynamic row logic and initial setup.
        function initSelect2ForElement($element, placeholderText, options = [], valueKey = 'id', textKey = 'name') {
            // Destroy existing Select2 instance if it exists
            if ($element.data('select2')) {
                $element.select2('destroy');
            }
            // Clear existing options and add the default placeholder option
            $element.empty().append('<option value="">' + placeholderText + '</option>');
            // Populate with new options
            $.each(options, function(index, item) {
                $element.append('<option value="' + item[valueKey] + '">' + item[textKey] + '</option>');
            });
            // Re-initialize Select2
            $element.select2({
                placeholder: placeholderText,
                allowClear: true,
                // Use the closest modal content container as dropdownParent to prevent z-index issues
                dropdownParent: $element.closest('.relative.bg-white')
            });
        }

        // Helper function to load assets for a given asset select element
        function loadAssetsForSelect($assetSelectElement, ruanganId) {
            if (ruanganId) {
                let url = '{{ route("tiket.ruangans.asets", ":id_ruangan") }}';
                url = url.replace(':id_ruangan', ruanganId);

                $.ajax({
                    url: url,
                    type: "get",
                    dataType: "json",
                    success: function(data) {
                        initSelect2ForElement($assetSelectElement, "Pilih Aset", data, 'id_aset', 'nama_aset');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading asets: " + error);
                        initSelect2ForElement($assetSelectElement, "Pilih Aset", [], 'id', 'nama_aset');
                    }
                });
            } else {
                initSelect2ForElement($assetSelectElement, "Pilih Aset", [], 'id_aset', 'nama_aset');
            }
        }

        $(document).ready(function() {
            // Helper function for dynamic detail rows visibility
            function updateRemoveDetailRowButtonsVisibility() {
                const rowCount = $('#detailRowsContainer .detail-row').length;
                $('#detailRowsContainer .remove-row-btn').each(function() {
                    if (rowCount > 1) {
                        $(this).removeClass('hidden');
                    } else {
                        $(this).addClass('hidden');
                    }
                });
            }
            updateRemoveDetailRowButtonsVisibility(); // Initial call

            // Add Detail Row functionality (using event delegation)
            $(document).on('click', '.add-row-btn', function() {
                const container = $('#detailRowsContainer');
                const newRowHtml = generateDetailRowHtml(); // Call the helper function
                const newRowElement = $(newRowHtml); // Convert string to jQuery object
                container.append(newRowElement);

                // Initialize select2 in the new row
                const $newAssetSelect = newRowElement.find('.asset-select');
                initSelect2ForElement($newAssetSelect, "Pilih Aset", [], 'id_aset', 'nama_aset');

                // After adding a new row, if a ruangan is already selected,
                // load assets for the new asset select based on the current ruangan.
                const $currentModal = $(this).closest('.relative.bg-white');
                const currentRuanganId = $currentModal.find('.ruangan').val();
                if (currentRuanganId) {
                    loadAssetsForSelect($newAssetSelect, currentRuanganId);
                }

                updateRemoveDetailRowButtonsVisibility();
            });

            // Remove Detail Row functionality (using event delegation)
            $('#detailRowsContainer').on('click', '.remove-row-btn', function() {
                const rowCount = $('#detailRowsContainer .detail-row').length;
                if (rowCount > 1) { // Only remove if there's more than one row
                    $(this).closest('.detail-row').remove();
                }
                updateRemoveDetailRowButtonsVisibility();
            });

            // Initial Select2 setup for existing elements
            initSelect2ForElement($('.ruangan'), "Pilih Ruangan", [], 'id_ruangan', 'nama_ruangan');
            initSelect2ForElement($('.asset-select'), "Pilih Aset", [], 'id_aset', 'nama_aset');
            loadUnits(); // Assuming loadUnits is defined elsewhere and accessible

            // Handle change event for unit selection
            $('.unit-select').on('change', function() {
                let unitId = $(this).val();
                // Scope the selectors to the current modal instance to ensure independence
                let $currentModal = $(this).closest('.relative.bg-white');
                let $ruanganSelect = $currentModal.find('.ruangan');
                // Select all asset selects in the current modal
                let $allAssetSelects = $currentModal.find('.asset-select');

                if (unitId) {
                    let url = '{{ route("tiket.units.ruangans", ":id_unit") }}';
                    url = url.replace(':id_unit', unitId);

                    $.ajax({
                        url: url,
                        type: "get",
                        dataType: "json",
                        success: function(data) {
                            // Populate and re-initialize Select2 for ruangan dropdown
                            initSelect2ForElement($ruanganSelect, "Pilih Ruangan", data, 'id_ruangan', 'nama_ruangan');
                            // Clear and re-initialize Select2 for all asset dropdowns as unit change invalidates previous asset selection
                            initSelect2ForElement($allAssetSelects, "Pilih Aset", [], 'id_aset', 'nama_aset');
                        },
                        error: function(xhr, status, error) {
                            console.error("Error loading ruangans: " + error);
                            // On error, clear and re-initialize both dropdowns
                            initSelect2ForElement($ruanganSelect, "Pilih Ruangan", [], 'id_ruangan', 'nama_ruangan');
                            initSelect2ForElement($allAssetSelects, "Pilih Aset", [], 'id_aset', 'nama_aset');
                        }
                    });
                } else {
                    // If unit is cleared, clear and re-initialize ruangan and all asset selects
                    initSelect2ForElement($ruanganSelect, "Pilih Ruangan", [], 'id_ruangan', 'nama_ruangan');
                    initSelect2ForElement($allAssetSelects, "Pilih Aset", [], 'id_aset', 'nama_aset');
                }
            });

            // Handle change event for ruangan selection
            $(document).on('change', '.ruangan', function() {
                let ruanganId = $(this).val();
                let $currentModal = $(this).closest('.relative.bg-white');
                // When the main ruangan changes, update ALL asset selects in the modal
                $currentModal.find('.asset-select').each(function() {
                    loadAssetsForSelect($(this), ruanganId);
                });
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
        });
    </script>

    <script>
        function loadWaitingTickets() {
            const container = document.getElementById('waitingTicketsContainer');
            const loadingIndicator = document.getElementById('loadingWaitingTickets');
            if (!container) return;

            // Show loading indicator
            if (loadingIndicator) {
                loadingIndicator.classList.remove('hidden');
            } else {
                container.innerHTML = '<div class="text-center text-gray-500 py-8" id="loadingWaitingTickets"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat tiket menunggu...</div>';
            }
            container.innerHTML = ''; // Clear previous content

            fetch("{{ route('tiket.waiting.data.all') }}") // Assuming this endpoint exists and returns JSON for support view
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(tickets => {
                    if (loadingIndicator) loadingIndicator.classList.add('hidden'); // Hide loading indicator
                    if (tickets.length === 0) {
                        container.innerHTML = '<div class="text-center text-gray-500 py-8">Tidak ada tiket menunggu saat ini.</div>';
                        return;
                    }

                    tickets.forEach(ticket => {
                        const ticketCategoryText = ticket.kategori_tiket == 1 ? 'SIMRS' : (ticket.kategori_tiket == 2 ? 'PSRS' : 'Kategori Tidak Dikenal');
                        const imageUrl = ticket.gambar ? `{{ asset('images/tiket/') }}/${ticket.gambar}` : '#';
                        const imageLink = ticket.gambar ? `<a href="${imageUrl}" target="_blank" class="text-blue-500 hover:underline">Lihat Gambar</a>` : 'Tidak ada gambar';

                        const ticketCardHtml = `
                            <div class="w-full bg-white shadow-md rounded-lg border">
                                <input type="checkbox" id="accordion-ticket-${ticket.id}" class="hidden peer" />
                                <label for="accordion-ticket-${ticket.id}" class="flex items-center justify-between p-4 bg-blue-100 hover:bg-blue-200 rounded-t-lg cursor-pointer">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-blue-500 p-2 rounded-md">
                                            <img src="{{url('images/iconpack/ticketing/jde.svg')}}" class="w-6 h-6" alt="icon" />
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">${ticketCategoryText}</p>
                                            <p class="text-gray-600 text-xs">Menunggu Tiket</p>
                                        </div>
                                    </div>
                                    <i class="fas fa-caret-right transform transition-transform duration-300 peer-checked:rotate-90"></i>
                                </label>
                                <div class="accordion_content hidden peer-checked:block border-t p-4">
                                    <table class="w-full text-sm border-collapse">
                                        <tr>
                                            <td class="font-semibold w-1/3 py-2">Nomor Tiket</td>
                                            <td class="py-2">${ticket.no_tiket}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold py-2">Nama</td>
                                            <td class="py-2">${ticket.pembuat_tiket.name}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold py-2">Departemen</td>
                                            <td class="py-2">${ticket.departemen.nama_unit}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold py-2">Ruangan</td>
                                            <td class="py-2">${ticket.ruangans?.nama_ruangan || '-'}</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold py-2">Tanggal Dibuat</td>
                                            <td class="py-2">${new Date(ticket.tgl_pembuatan).toLocaleString('id-ID', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' })}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold py-2">Subjek Tiket</td>
                                            <td class="py-2">${ticket.subjek_tiket}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold py-2">Deskripsi Tiket</td>
                                            <td class="py-2">${ticket.desc_tiket}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold py-2">Gambar Masalah</td>
                                            <td class="py-2">${imageLink}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold py-2">Proses</td>
                                            <td class="py-2">
                                                <button
                                                    type="button"
                                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md btn-process"
                                                    data-id="${ticket.id}"
                                                    data-url="{{ route('tiket.process', ':id') }}">
                                                    Proses Tiket
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', ticketCardHtml);
                    });
                })
                .catch(error => {
                    console.error('Error loading waiting tickets:', error);
                    if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    container.innerHTML = '<div class="text-center text-red-500 py-8">Gagal memuat tiket. Silakan coba lagi.</div>';
                });
        }

        // Call the function when the page loads
        document.addEventListener('DOMContentLoaded', loadWaitingTickets);

        document.addEventListener('DOMContentLoaded', function() {
            // Delegasi klik tombol proses
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-process')) {
                    const id = e.target.dataset.id;
                    let url = e.target.dataset.url.replace(':id', id);
                    processTicket(url);
                }
            });

            function processTicket(url) {
                if (!confirm('Apakah Anda yakin ingin memproses tiket ini?')) return;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: 'on_process' }) // Set status to 'on_process'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Refresh daftar tiket menunggu
                        if (typeof loadWaitingTickets === 'function') loadWaitingTickets();
                        // Optionally, if there's a loadProcessTickets function, call it too
                        // if (typeof loadProcessTickets === 'function') loadProcessTickets();
                    } else {
                        alert('Gagal memproses tiket.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses tiket.');
                });
            }
        });
    </script>

    <script>
        function loadDoneTickets() {
            const container = document.getElementById('doneTicketsContainer');
            const loadingIndicator = document.getElementById('loadingDoneTickets');
            if (!container) return;

            if (loadingIndicator) loadingIndicator.classList.remove('hidden');
            container.innerHTML = ''; // Clear previous tickets

            // Assuming 'tiket.done.data.all' route is modified to NOT eager load 'details' and 'detailsfoto'
            fetch('{{ route("tiket.done.data.all") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(tickets => {
                    if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    if (tickets.length === 0) {
                        container.innerHTML = '<div class="text-center text-gray-500 py-8">Tidak ada tiket selesai.</div>';
                        return;
                    }

                    tickets.forEach(ticket => {
                        const ticketCategoryText = ticket.kategori_tiket == 1 ? 'SIMRS' : (ticket.kategori_tiket == 2 ? 'PSRS' : 'Kategori Tidak Dikenal');
                        const imageUrl = ticket.gambar ? `{{ asset('images/tiket/') }}/${ticket.gambar}` : '#';
                        const imageLink = ticket.gambar ? `<a href="${imageUrl}" target="_blank" class="text-blue-500 hover:underline">Lihat Gambar</a>` : 'Tidak ada gambar';

                        // Removed direct generation of detailRowsHtml and repairImagesButtonHtml
                        // These will now be loaded dynamically via the 'Detail' button

                        const ticketCardHtml = `
                            <div class="w-full bg-white shadow-md rounded-lg border">
                                <input type="checkbox" id="accordion-ticket-done-${ticket.id}" class="hidden peer" />
                                <label for="accordion-ticket-done-${ticket.id}" class="flex items-center justify-between p-4 bg-blue-100 hover:bg-blue-200 rounded-t-lg cursor-pointer">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-blue-500 p-2 rounded-md">
                                            <img src="{{url('images/iconpack/ticketing/jde.svg')}}" class="w-6 h-6" alt="icon" />
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">${ticketCategoryText} - ${ticket.subjek_tiket}</p>
                                            <p class="text-gray-600 text-xs">Ticket #${ticket.no_tiket} - ${ticket.pembuat_tiket.name}</p>
                                        </div>
                                    </div>
                                    <i class="fas fa-caret-right transform transition-transform duration-300 peer-checked:rotate-90"></i>
                                </label>
                                <div class="accordion_content hidden peer-checked:block border-t p-4">
                                    <table class="w-full text-sm border-collapse">
                                        <tr><td class="font-semibold w-1/3 py-2">Nomor Tiket</td><td class="py-2">${ticket.no_tiket}</td></tr>
                                        <tr><td class="font-semibold py-2">Nama</td><td class="py-2">${ticket.pembuat_tiket.name}</td></tr>
                                        <tr><td class="font-semibold py-2">Departemen</td><td class="py-2">${ticket.departemen_done.nama_unit}</td></tr>
                                        <tr><td class="font-semibold py-2">Ruangan</td><td class="py-2">${ticket.ruangans_done.nama_ruangan || '-'}</td></tr>
                                        <tr><td class="font-semibold py-2">Tanggal Dibuat</td><td class="py-2">${ticket.tgl_pembuatan || 'N/A'}</td></tr>
                                        <tr><td class="font-semibold py-2">Dipending Oleh</td><td class="py-2">${ticket.petugas_pending ? ticket.petugas_pending.name : 'N/A'}</td></tr>
                                        <tr><td class="font-semibold py-2">Waktu Dipending</td><td class="py-2">${ticket.tgl_pending || 'N/A'}</td></tr>
                                        <tr><td class="font-semibold py-2">Diselesaikan Oleh</td><td class="py-2">${ticket.petugas_done ? ticket.petugas_done.name : 'N/A'}</td></tr>
                                        <tr><td class="font-semibold py-2">Waktu Selesai</td><td class="py-2">${ticket.tgl_done || 'N/A'}</td></tr>
                                        <tr><td class="font-semibold py-2">Subjek Tiket</td><td class="py-2">${ticket.subjek_tiket}</td></tr>
                                        <tr><td class="font-semibold py-2">Deskripsi Tiket</td><td class="py-2">${ticket.desc_tiket}</td></tr>
                                        <tr><td class="font-semibold py-2">Gambar Masalah</td><td class="py-2">${imageLink}</td></tr>
                                        <tr><td class="font-semibold py-2">Deskripsi Selesai</td><td class="py-2">${ticket.desc_done || 'N/A'}</td></tr>
                                        <tr>
                                            <td class="font-semibold py-2">Action</td>
                                            <td class="py-2">
                                                <button type="button" onclick="openTicketDetailsModal(${ticket.id})" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', ticketCardHtml);
                    });
                })
                .catch(error => {
                    console.error('Error loading done tickets:', error);
                    if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    container.innerHTML = '<div class="text-center text-red-500 py-8">Gagal memuat tiket selesai. Silakan coba lagi.</div>';
                });
        }

        function openTicketDetailsModal(ticketId) {
            const modal = document.getElementById('ticketDetailsModal');
            const modalTitle = document.getElementById('ticketDetailsModalTitle');
            const loading = document.getElementById('ticketDetailsModalLoading');
            const content = document.getElementById('ticketDetailsModalContent');

            // Reset konten
            content.innerHTML = '';
            content.classList.add('hidden');
            loading.classList.remove('hidden');
            modalTitle.textContent = 'Detail Tiket';

            openModal('ticketDetailsModal');


                const url =`{{ route('tiket.details', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', ticketId)
                fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    loading.classList.add('hidden');
                    content.classList.remove('hidden');

                    modalTitle.textContent = `Detail Tiket #${data.no_tiket}`;

                    let detailRowsHtml = '';
                    if (data.details && data.details.length > 0) {
                        data.details.forEach((detail, index) => {
                            detailRowsHtml += `
                                <tr>
                                    <td class="font-semibold py-2 pl-4">Hardware ${index + 1}</td>
                                    <td class="py-2">${detail.aset.nama_aset || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-2 pl-4">Masalah ${index + 1}</td>
                                    <td class="py-2">${detail.masalah || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-2 pl-4">Penyelesaian ${index + 1}</td>
                                    <td class="py-2">${detail.penanganan || '-'}</td>
                                </tr>
                            `;
                        });
                    } else {
                        detailRowsHtml = `<tr><td colspan="2" class="py-2 text-gray-500 text-center">Tidak ada detail perbaikan.</td></tr>`;
                    }

                    let imagesHtml = '';
                    if (data.detailsfoto && data.detailsfoto.length > 0) {
                        data.detailsfoto.forEach(img => {
                            // As per instruction, 'img.gambar' only contains the filename,
                            // and the images are stored in 'images/tiket/' within the public directory.
                            const imageUrl = `{{ asset('images/tiket/') }}/${img.gambar}`;
                            imagesHtml += `
                                <div class="border rounded-md overflow-hidden">
                                    <img src="${imageUrl}" alt="Repair Image" class="w-full h-auto object-cover cursor-pointer" onclick="openImageInNewTab('${imageUrl}')">
                                </div>
                            `;
                        });
                    } else {
                        imagesHtml = '<p class="text-center text-gray-500">Tidak ada foto perbaikan.</p>';
                    }

                    content.innerHTML = `
                        <h4 class="text-md font-semibold text-gray-800 mb-2">Detail Perbaikan</h4>
                        <table class="w-full text-sm border-collapse mb-4">
                            ${detailRowsHtml}
                        </table>

                        <h4 class="text-md font-semibold text-gray-800 mb-2">Foto Perbaikan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            ${imagesHtml}
                        </div>
                        <div class="flex justify-end">
                            <button type="button" onclick="closeModal('ticketDetailsModal')" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md text-sm">
                                Tutup
                            </button>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error loading ticket details:', error);
                    loading.classList.add('hidden');
                    content.classList.remove('hidden');
                    content.innerHTML = '<div class="text-center text-red-500 py-8">Gagal memuat detail tiket. Silakan coba lagi.</div>';
                });
        }


        function openImageInNewTab(imageUrl) {
            window.open(imageUrl, '_blank');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // If the done tab is the active one on load, or if it's meant to be loaded immediately
            if (!document.getElementById('content-done').classList.contains('hidden')) {
                loadDoneTickets();
            }
        });
    </script>

    <script>
        // Function to mark a ticket as 'on_process'
        function processTicket(ticketId) {
            if (!confirm('Apakah Anda yakin ingin menandai tiket ini sebagai sedang diproses?')) return;

            fetch(`{{ route('tiket.pending', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', ticketId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({}) // No specific data needed for processing, just the ID
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    loadPendingTickets(); // Refresh pending tickets
                    if (typeof loadProcessTickets === 'function') loadProcessTickets(); // Optionally refresh process tickets
                } else {
                    alert('Gagal menandai tiket sebagai sedang diproses: ' + (data.message || ''));
                }
            })
            .catch(error => {
                console.error('Error processing ticket:', error);
                alert('Terjadi kesalahan saat menandai tiket sebagai sedang diproses.');
            });
        }

        // Function to load tickets with 'pending' status
        function loadPendingTickets() {
            const container = document.getElementById('pendingTicketsContainer');
            const loadingIndicator = document.getElementById('loadingPendingTickets');
            if (!container) return;

            if (loadingIndicator) loadingIndicator.classList.remove('hidden');
            container.innerHTML = ''; // Clear previous tickets

            fetch('{{ route("tiket.pending.data.all") }}') // Assuming this route exists and returns pending tickets
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(tickets => {
                    if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    if (tickets.length === 0) {
                        container.innerHTML = '<div class="text-center text-gray-500 py-8">Tidak ada tiket pending.</div>';
                        return;
                    }

                    tickets.forEach(ticket => {
                        const ticketCategoryText = ticket.kategori_tiket == 1 ? 'SIMRS' : (ticket.kategori_tiket == 2 ? 'PSRS' : 'Kategori Tidak Dikenal');
                        const imageUrl = ticket.gambar ? `{{ asset('images/tiket/') }}/${ticket.gambar}` : '#';
                        const imageLink = ticket.gambar ? `<a href="${imageUrl}" target="_blank" class="text-blue-500 hover:underline">Lihat Gambar</a>` : 'Tidak ada gambar';

                        const ticketCardHtml = `
                            <div class="w-full bg-white shadow-md rounded-lg border">
                                <input type="checkbox" id="accordion-ticket-pending-${ticket.id}" class="hidden peer" />
                                <label for="accordion-ticket-pending-${ticket.id}" class="flex items-center justify-between p-4 bg-yellow-100 hover:bg-yellow-200 rounded-t-lg cursor-pointer">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-yellow-500 p-2 rounded-md">
                                            <img src="{{url('images/iconpack/ticketing/jde.svg')}}" class="w-6 h-6" alt="icon" />
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">${ticketCategoryText} - ${ticket.subjek_tiket}</p>
                                            <p class="text-gray-600 text-xs">Ticket #${ticket.no_tiket} - ${ticket.pembuat_tiket.name}</p>
                                        </div>
                                    </div>
                                    <i class="fas fa-caret-right transform transition-transform duration-300 peer-checked:rotate-90"></i>
                                </label>
                                <div class="accordion_content hidden peer-checked:block border-t p-4">
                                    <table class="w-full text-sm border-collapse">
                                        <tr><td class="font-semibold w-1/3 py-2">Ticket Number</td><td class="py-2">${ticket.no_tiket}</td></tr>
                                        <tr><td class="font-semibold py-2">Name</td><td class="py-2">${ticket.pembuat_tiket.name}</td></tr>
                                        <tr><td class="font-semibold py-2">Department</td><td class="py-2">${ticket.departemen.nama_unit}</td></tr>
                                        <tr><td class="font-semibold py-2">Ruangan</td><td class="py-2">${ticket.ruangans?.nama_ruangan || '-'}</td></tr>
                                        <tr><td class="font-semibold py-2">Create Date</td><td class="py-2">${ticket.tgl_pembuatan || 'N/A'}</td></tr>
                                        <tr><td class="font-semibold py-2">Di-pending Oleh</td><td class="py-2">${ticket.petugas_pending.name || 'N/A'}</td></tr>
                                        <tr><td class="font-semibold py-2">Waktu Di-pending</td><td class="py-2">${ticket.tgl_pending || 'N/A'}</td></tr>
                                        <tr><td class="font-semibold py-2">Subjek Tiket</td><td class="py-2">${ticket.subjek_tiket}</td></tr>
                                        <tr><td class="font-semibold py-2">Deskripsi Tiket</td><td class="py-2">${ticket.desc_tiket}</td></tr>
                                        <tr><td class="font-semibold py-2">Problem Image</td><td class="py-2">${imageLink}</td></tr>
                                        <tr><td class="font-semibold py-2">Deskripsi Pending</td><td class="py-2">${ticket.desc_pending || 'N/A'}</td></tr>
                                        <tr>
                                            <td class="font-semibold py-2">Action</td>
                                            <td class="py-2 flex flex-wrap gap-2">
                                                <button type="button" onclick="prepareAndOpenDoneModal(${ticket.id}, '${ticket.no_tiket}', ${ticket.departemen.id_unit}, '${ticket.departemen.nama_unit}')" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-md text-sm">
                                                    Done
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', ticketCardHtml);
                    });
                })
                .catch(error => {
                    console.error('Error loading pending tickets:', error);
                    if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    container.innerHTML = '<div class="text-center text-red-500 py-8">Gagal memuat tiket pending. Silakan coba lagi.</div>';
                });
        }

        // Initial load when the tab content is rendered (if it's not hidden initially)
        // Or, this function should be called when the 'Pending' tab is activated.
        document.addEventListener('DOMContentLoaded', function() {
            // Check if the pending tab is the active one on load, or if it's meant to be loaded immediately
            // In a real tab system, this would be triggered by the tab click.
            if (!document.getElementById('content-pending').classList.contains('hidden')) {
                loadPendingTickets();
            }
        });

    </script>

    <script>
        // Global counter for unique IDs for solution images
        let solutionImageCounter = 1; // Start from 1 because the first one is already in HTML

        // Helper function to create a new solution image row element by cloning
        function createSolutionImageRowElement() {
            const $originalRow = $('#solutionImageRowsContainer .solution-image-row').first();
            const $newRow = $originalRow.clone(true); // Clone with event handlers

            solutionImageCounter++; // Increment for the new row

            const newIdPrefix = `solutionImage_${solutionImageCounter}`;
            const newPreviewContainerId = `solutionImagePreviewContainer_${solutionImageCounter}`;
            const newPreviewId = `solutionImagePreview_${solutionImageCounter}`;
            const newRemoveBtnId = `removeSolutionImageBtn_${solutionImageCounter}`;

            // Update IDs and attributes for the cloned elements
            $newRow.find('input[type="file"]').attr({
                id: newIdPrefix,
                onchange: `previewSolutionImage(event, '${newPreviewId}', '${newRemoveBtnId}', '${newPreviewContainerId}')`
            }).val(''); // Clear the file input value

            $newRow.find('label[for^="solutionImage_"]').attr('for', newIdPrefix);

            $newRow.find('div[id^="solutionImagePreviewContainer_"]').attr('id', newPreviewContainerId).addClass('hidden');
            $newRow.find('img[id^="solutionImagePreview_"]').attr('id', newPreviewId).attr('src', '#'); // Clear image source
            $newRow.find('button[id^="removeSolutionImageBtn_"]').attr({
                id: newRemoveBtnId,
                onclick: `removeSolutionImage('${newIdPrefix}', '${newPreviewId}', '${newRemoveBtnId}', '${newPreviewContainerId}')`
            }).addClass('hidden');

            return $newRow;
        }

        // Helper function to update remove image row buttons visibility
        function updateRemoveSolutionImageRowButtonsVisibility() {
            const rowCount = $('#solutionImageRowsContainer .solution-image-row').length;
            $('#solutionImageRowsContainer .remove-solution-image-row-btn').each(function() {
                if (rowCount > 1) {
                    $(this).removeClass('hidden');
                } else {
                    $(this).addClass('hidden');
                }
            });
        }

        // Helper function to preview an image
        function previewSolutionImage(event, imagePreviewId, removeBtnId, imagePreviewContainerId) {
            const imageInput = event.target;
            const imagePreview = document.getElementById(imagePreviewId);
            const imagePreviewContainer = document.getElementById(imagePreviewContainerId);
            const removeImageBtn = document.getElementById(removeBtnId);

            if (imageInput.files && imageInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.classList.remove('hidden');
                    removeImageBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(imageInput.files[0]);
            } else {
                // If no file selected, clear preview
                removeSolutionImage(imageInput.id, imagePreviewId, removeBtnId, imagePreviewContainerId);
            }
        }

        // Helper function to remove an image
        function removeSolutionImage(imageInputId, imagePreviewId, removeBtnId, imagePreviewContainerId) {
            const imageInput = document.getElementById(imageInputId);
            const imagePreview = document.getElementById(imagePreviewId);
            const imagePreviewContainer = document.getElementById(imagePreviewContainerId);
            const removeImageBtn = document.getElementById(removeBtnId);

            if (imageInput) imageInput.value = ''; // Clear the file input
            if (imagePreview) imagePreview.src = '#'; // Clear the image source
            if (imagePreviewContainer) imagePreviewContainer.classList.add('hidden');
            if (removeImageBtn) removeImageBtn.classList.add('hidden');
        }

        // Function to reset all solution image rows in the modal
        function resetSolutionImageRows() {
            const $container = $('#solutionImageRowsContainer');
            // Remove all rows except the first one
            $container.find('.solution-image-row:not(:first)').remove();

            // Reset the first row
            removeSolutionImage('solutionImage_1', 'solutionImagePreview_1', 'removeSolutionImageBtn_1', 'solutionImagePreviewContainer_1');

            solutionImageCounter = 1; // Reset counter to reflect only the first row
            updateRemoveSolutionImageRowButtonsVisibility();
        }

        // Helper function to update remove detail row buttons visibility
        function updateRemoveDetailRowButtonsVisibility() {
            const rowCount = $('#detailRowsContainer .detail-row').length;
            $('#detailRowsContainer .remove-row-btn').each(function() {
                if (rowCount > 1) {
                    $(this).removeClass('hidden');
                } else {
                    $(this).addClass('hidden');
                }
            });
        }

        // Function to reset all detail rows in the modal
        function resetDetailRows() {
            const $container = $('#detailRowsContainer');
            // Remove all rows except the first one
            $container.find('.detail-row:not(:first)').remove();

            // Reset the first row
            const $firstRow = $container.find('.detail-row').first();
            $firstRow.find('.asset-select').val('').trigger('change'); // Clear Select2 and trigger change
            $firstRow.find('input[name="masalah[]"]').val('');
            $firstRow.find('input[name="penanganan[]"]').val('');

            // Re-initialize Select2 for the first row's asset select
            if (typeof initSelect2ForElement === 'function') {
                initSelect2ForElement($firstRow.find('.asset-select'), "Pilih Aset", [], 'id_aset', 'nama_aset');
            } else {
                console.warn("initSelect2ForElement function is not defined. Select2 might not be re-initialized.");
            }

            updateRemoveDetailRowButtonsVisibility(); // Update button visibility
        }


        $(document).ready(function() {
            // Initial visibility check for remove image row buttons
            updateRemoveSolutionImageRowButtonsVisibility();

            // Add Solution Image Row functionality
            $(document).on('click', '#addSolutionImageBtn', function() {
                const container = $('#solutionImageRowsContainer');
                const newRowElement = createSolutionImageRowElement();
                container.append(newRowElement);
                updateRemoveSolutionImageRowButtonsVisibility();
            });

            // Remove Solution Image Row functionality (using event delegation)
            $('#solutionImageRowsContainer').on('click', '.remove-solution-image-row-btn', function() {
                const rowCount = $('#solutionImageRowsContainer .solution-image-row').length;
                if (rowCount > 1) { // Only remove if there's more than one row
                    $(this).closest('.solution-image-row').remove();
                }
                updateRemoveSolutionImageRowButtonsVisibility();
            });

            // Store a reference to the original closeModal function if it exists
            const originalCloseModal = window.closeModal;

            // Override the global closeModal function to include reset logic for markAsDoneModal
            window.closeModal = function(modalId) {
                // Call the original closeModal function first to hide the modal
                if (typeof originalCloseModal === 'function') {
                    originalCloseModal(modalId);
                } else {
                    // Fallback if originalCloseModal was not defined globally before this script
                    const modalElement = document.getElementById(modalId);
                    if (modalElement) {
                        modalElement.classList.add('hidden');
                    }
                }

                // Now, perform specific resets if it's the 'markAsDoneModal'
                if (modalId === 'markAsDoneModal') {
                    resetSolutionImageRows();
                    resetDetailRows(); // Also reset detail rows
                    // Re-initialize Select2 for unit and ruangan dropdowns
                    const $markAsDoneModal = $('#markAsDoneModal');
                    if (typeof initSelect2ForElement === 'function') {
                        initSelect2ForElement($markAsDoneModal.find('.unit-select'), "Pilih Unit", [], 'id', 'name');
                        initSelect2ForElement($markAsDoneModal.find('.ruangan'), "Pilih Ruangan", [], 'id_ruangan', 'nama_ruangan');
                    } else {
                        console.warn("initSelect2ForElement function is not defined. Select2 might not be re-initialized.");
                    }
                }
            };
        });
    </script>

    <script>
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
          // Tambah Aset
          $('#btnTambahAset').click(function(){
            $('#formAset')[0].reset();
            $('#id_aset').val('');
            $('#modalAsetTitle').text('Tambah Aset');
            $('#id_ruangan').val(null).trigger('change'); // Reset Select2
            openModal('modalAset');
        });

        // Helper function to hide a modal
        function hideModal(modalId) {
            $('#' + modalId).addClass('hidden');
        }
    </script>