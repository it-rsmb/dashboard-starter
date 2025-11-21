<div class="col-span-12 bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-gray-200 dark:border-gray-700 p-6">
    <h2 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold mb-4">Master Unit & Ruangan</h2>

    <button class="btn bg-indigo-500 text-white hover:bg-indigo-600 dark:bg-indigo-600 dark:hover:bg-indigo-700 mb-4" id="btnTambahUnit">
        <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
        </svg>
        <span class="max-xs:sr-only ml-2">Tambah Unit</span>
    </button>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Unit</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ruangan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($units as $unit)
                    <tr data-id="{{ $unit->id_unit }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 nama_unit">{{ $unit->nama_unit }}</td>
                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-500 dark:text-gray-400 keterangan">{{ $unit->keterangan }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                            <ul class="list-none p-0 m-0 space-y-2">
                                @foreach($unit->ruangans as $ruangan)
                                    <li class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-2 rounded-md">
                                        <span class="text-gray-700 dark:text-gray-300">{{ $ruangan->nama_ruangan }} ({{ $ruangan->lokasi }})</span>
                                        <button class="inline-flex items-center px-2 py-1 border border-transparent rounded-md font-medium text-xs text-white bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 ml-2 btnHapusRuangan"
                                            data-id-unit="{{ $unit->id_unit }}"
                                            data-id-ruangan="{{ $ruangan->id_ruangan }}">
                                            Hapus
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <button class="inline-flex items-center px-2 py-1 border border-transparent rounded-md font-medium text-xs text-white bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mt-3 btnTambahRuangan" data-id="{{ $unit->id_unit }}">
                                <svg class="fill-current shrink-0" width="12" height="12" viewBox="0 0 16 16">
                                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                </svg>
                                <span class="ml-1">Tambah Ruangan</span>
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="inline-flex items-center px-2 py-1 border border-transparent rounded-md font-medium text-xs text-white bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mr-2 btnEditUnit" data-id="{{ $unit->id_unit }}">Edit</button>
                            <button class="inline-flex items-center px-2 py-1 border border-transparent rounded-md font-medium text-xs text-white bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 btnHapusUnit" data-id="{{ $unit->id_unit }}">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah/Edit Unit -->
<div id="modalUnit" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center hidden" role="dialog" aria-modal="true" aria-labelledby="modalUnitTitle">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg mx-auto">
        <form id="formUnit">
            @csrf
            <input type="hidden" name="id_unit" id="id_unit">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="modalUnitTitle">Form Unit</h5>
                <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" data-modal-hide="modalUnit">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="py-4">
                <div class="mb-4">
                    <label for="nama_unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Unit</label>
                    <input type="text" name="nama_unit" id="nama_unit" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm"></textarea>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Ruangan -->
<div id="modalRuangan" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center hidden" role="dialog" aria-modal="true" aria-labelledby="modalRuanganTitle">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg mx-auto">
        <form id="formRuangan">
            @csrf
            <input type="hidden" name="id_unit" id="ruangan_id_unit">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="modalRuanganTitle">Tambah Ruangan</h5>
                <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" data-modal-hide="modalRuangan">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="py-4">
                <div class="mb-4">
                    <label for="nama_ruangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Ruangan</label>
                    <input type="text" name="nama_ruangan" id="nama_ruangan" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="lokasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Tambah</button>
            </div>
        </form>
    </div>
</div>


<script>
$(document).ready(function(){
    // Helper function to show a modal
    function showModal(modalId) {
        $('#' + modalId).removeClass('hidden');
    }

    // Helper function to hide a modal
    function hideModal(modalId) {
        $('#' + modalId).addClass('hidden');
    }

    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Tambah Unit
    $('#btnTambahUnit').click(function(){
        $('#formUnit')[0].reset();
        $('#id_unit').val('');
        $('#modalUnitTitle').text('Tambah Unit'); // Update modal title
        showModal('modalUnit');
    });

    // Edit Unit
    $('.btnEditUnit').click(function(){
        let tr = $(this).closest('tr');
        $('#id_unit').val(tr.data('id'));
        $('#nama_unit').val(tr.find('.nama_unit').text());
        $('#keterangan').val(tr.find('.keterangan').text());
        $('#modalUnitTitle').text('Edit Unit'); // Update modal title
        showModal('modalUnit');
    });

    // Simpan Unit (Tambah/Update)
    $('#formUnit').submit(function(e){
        e.preventDefault();
        let id = $('#id_unit').val();
        let url = id ? `{{ route('tiket.units.update', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id) : `{{ route("tiket.units.store") }}`;
        let type = id ? "PUT" : "POST";

        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res){
                if (res.success) {
                    hideModal('modalUnit'); // Hide modal on success
                    location.reload(); // Reload page to reflect changes
                } else {
                    alert('Gagal menyimpan unit.'); // Basic error feedback
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseText); // More detailed error feedback
            }
        });
    });

    // Hapus Unit
    $('.btnHapusUnit').click(function(){
        if(!confirm("Yakin hapus unit ini?")) return;
        let id = $(this).data('id');
        $.ajax({
            url: `{{ route('units.destroy', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id),
            type: "DELETE",
            success: function(res){
                if (res.success) {
                    location.reload(); // Reload page to reflect changes
                } else {
                    alert('Gagal menghapus unit.');
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseText);
            }
        });
    });

    // Tambah Ruangan
    $('.btnTambahRuangan').click(function(){
        $('#formRuangan')[0].reset();
        $('#ruangan_id_unit').val($(this).data('id'));
        $('#modalRuanganTitle').text('Tambah Ruangan'); // Update modal title
        showModal('modalRuangan');
    });

    // Simpan Ruangan
    $('#formRuangan').submit(function(e){
        e.preventDefault();
        let id_unit = $('#ruangan_id_unit').val();
        $.ajax({
            url: `{{ route('tiket.ruangans.store', ['id_unit' => 'ID_UNIT_PLACEHOLDER']) }}`.replace('ID_UNIT_PLACEHOLDER', id_unit),
            type: "POST",
            data: $(this).serialize(),
            success: function(res){
                if (res.success) {
                    hideModal('modalRuangan'); // Hide modal on success
                    location.reload(); // Reload page to reflect changes
                } else {
                    alert('Gagal menyimpan ruangan.');
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseText);
            }
        });
    });

    // Hapus Ruangan
    $('.btnHapusRuangan').click(function(){
        if(!confirm("Yakin hapus ruangan ini?")) return;
        let id_unit = $(this).data('id-unit');
        let id_ruangan = $(this).data('id-ruangan');
        $.ajax({
            url: `{{ route('tiket.ruangans.destroy', ['id_unit' => 'ID_UNIT_PLACEHOLDER', 'id_ruangan' => 'ID_RUANGAN_PLACEHOLDER']) }}`.replace('ID_UNIT_PLACEHOLDER', id_unit).replace('ID_RUANGAN_PLACEHOLDER', id_ruangan),
            type: "DELETE",
            success: function(res){
                if (res.success) {
                    location.reload(); // Reload page to reflect changes
                } else {
                    alert('Gagal menghapus ruangan.');
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseText);
            }
        });
    });

    // Handle modal close buttons (elements with data-modal-hide attribute)
    $('[data-modal-hide]').click(function() {
        const modalId = $(this).data('modal-hide');
        hideModal(modalId);
    });

    // Optional: Close modal when clicking on the backdrop
    $('.fixed.inset-0.z-50.overflow-auto.bg-gray-900.bg-opacity-50').click(function(e) {
        // Check if the click target is the modal backdrop itself, not content inside the modal
        if ($(e.target).is(this)) {
            $(this).addClass('hidden');
        }
    });
});
</script>