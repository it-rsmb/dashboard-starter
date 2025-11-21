
<!-- <body class="bg-gray-100 min-h-screen p-6"> -->




<body class="bg-gray-100 min-h-screen p-5">
   

 


    <div class="col-span-12 bg-white rounded-xl shadow-md p-5">

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('tiket.suport') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md flex items-center space-x-2">
                <i class="fas fa-list"></i>
                <span>Lihat Semua Tiket</span>
            </a>
            <div class="flex space-x-2">
                <button type="button" onclick="openModal('createTicketModal'); document.getElementById('ticketCategory').value = '1'; document.getElementById('ticketCategory').style.pointerEvents = 'none'; document.getElementById('ticketCategory').style.backgroundColor = '#e9ecef'; document.getElementById('ticketCategory').tabIndex = -1;" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>+ Tiket SIMRS</span>
                </button>
                <button type="button" onclick="openModal('createTicketModal'); document.getElementById('ticketCategory').value = '2'; document.getElementById('ticketCategory').style.pointerEvents = 'none'; document.getElementById('ticketCategory').style.backgroundColor = '#e9ecef'; document.getElementById('ticketCategory').tabIndex = -1;" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>+ Tiket PSRS</span>
                </button>
            </div>
        </div>
        <!-- Header -->
        <h1 class="text-2xl font-bold text-gray-800 mb-5">Tiket</h1>

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

    <div id="content-pending" class="tab-content space-y-4 hidden">
        <div class="text-center text-gray-500 py-8" id="loadingPendingTickets">
            <i class="fas fa-spinner fa-spin mr-2"></i> Memuat tiket pending...
        </div>
        <div id="pendingTicketsContainer" class="space-y-4">
            <!-- Pending tickets will be loaded here via AJAX -->
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


    <!-- Create Ticket Modal -->
    <div id="createTicketModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <!-- Modal Content -->
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Tambah tiket</h3>
                <button onclick="closeModal('createTicketModal')" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <form id="createTicketForm">
                @csrf
                <div class="mt-4">
                
                    <div class="mb-4">
                        <label for="ticketSubject" class="block text-sm font-medium text-gray-700">Subjek Tiket</label>
                        <input type="text" id="ticketSubject" name="subjek_tiket" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Cth: Printer tidak berfungsi" required>
                    </div>
                    <div class="mb-4">
                        <label for="ticketDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea id="ticketDescription" name="desc_tiket" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Jelaskan masalah secara detail" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                        <select id="unit" name="departemen" style="width: 100%; height: 38px; border: 1px solid #ced4da; border-radius: 4px;" class="unit-select mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            <option value="">Pilih Unit</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="id_ruangan" class="block text-sm font-medium text-gray-700">Ruangan</label>
                        <select name="ruangan" id="id_ruangan" style="width: 100%; height: 38px; border: 1px solid #ced4da; border-radius: 4px;"  class="ruangan-select mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            <option value="">Pilih Ruangan</option>
                        </select>
                    </div>
                    <div class="mb-4 flex space-x-4">
                        <div class="flex items-center w-1/2">
                            <label for="ticketCategory" class="text-sm font-medium text-gray-700 mr-2 whitespace-nowrap">Kategori</label>
                            <select id="ticketCategory" name="kategori_tiket" class="flex-grow px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="1" selected>SIMRS</option>
                                <option value="2">PSRS</option>
                            </select>
                        </div>   
                        <div class="flex items-center w-1/2">
                            <label for="ticketPriority" class="text-sm font-medium text-gray-700 mr-2 whitespace-nowrap">Prioritas</label>
                            <select id="ticketPriority" name="prioritas_tiket" class="flex-grow px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="1">Rendah</option>
                                <option value="2" selected>Sedang</option>
                                <option value="3">Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <!-- Lampiran Foto (Upload/Camera) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran Foto</label>
                        <input type="file" id="ticketImage" name="gambar" accept="image/*" class="hidden" onchange="previewImage(event)">
                        
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="document.getElementById('ticketImage').click()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg border border-gray-300 flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                <i class="fas fa-camera"></i>
                                <span>Ambil/Pilih Foto</span>
                            </button>
                            <button type="button" id="removeImageBtn" onclick="removeImage()" class="bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-2 px-4 rounded-lg border border-red-300 flex items-center space-x-2 hidden focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                <i class="fas fa-trash"></i>
                                <span>Hapus Foto</span>
                            </button>
                        </div>
                        
                        <div id="imagePreviewContainer" class="mt-3 hidden">
                            <img id="imagePreview" src="#" alt="Image Preview" class="max-w-full h-auto rounded-md border border-gray-300 shadow-sm">
                        </div>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="flex justify-end items-center pt-4 border-t">
                    <button type="button" onclick="closeModal('createTicketModal')" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg mr-2 focus:outline-none">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none">Simpan Tiket</button>
                </div>
            </form>
        </div>
    </div>

</body>

    
    
    <script>
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scrolling on body when modal is open
            }
        // untuk tab
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

                // document.addEventListener('DOMContentLoaded', loadPendingTickets);

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
        // ini untuk image 
            function openImageModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scrolling on body when modal is open
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling on body
                // Reset form and image preview when closing modal
                document.querySelector('#createTicketModal form').reset();
                removeImage();
            }

            // Close modal when clicking outside of the modal content
            window.onclick = function(event) {
                const modal = document.getElementById('createTicketModal');
                if (event.target == modal) {
                    closeModal('createTicketModal');
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
        // ini untuk create ticket
            $(document).ready(function () {
                $("#createTicketForm").on("submit", function (e) {
                    e.preventDefault(); // cegah reload halaman

                    let form = $(this)[0];
                    let formData = new FormData(form); // bisa handle file upload juga

                    $.ajax({
                        url: '{{ route("tickets.store") }}', // route Laravel
                        type: "POST",
                        data: formData,
                        processData: false, // biar FormData gak diubah ke string
                        contentType: false,
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}" // CSRF Laravel
                        },
                        beforeSend: function () {
                            // bisa tambahin loading state
                            console.log("Mengirim data...");
                        },
                        success: function (response) {
                            console.log("Sukses:", response);

                            // Swal.fire({
                            //     icon: 'success',
                            //     title: 'Tiket berhasil dibuat!',
                            //     showConfirmButton: false,
                            //     timer: 2000
                            // });

                            // reset form
                            $("#createTicketForm")[0].reset();
                            $("#imagePreviewContainer").addClass("hidden");
                            $("#removeImageBtn").addClass("hidden");

                            // Muat ulang daftar tiket
                            loadWaitingTickets(); // Assuming this function reloads the ticket list for the active tab

                            // Sembunyikan modal
                            closeModal('createTicketModal');
                        },
                        error: function (xhr) {
                            console.error("Error:", xhr.responseText);

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menyimpan tiket.'
                            });
                        }
                    });
                });
            });
        // ini untuk load waiting tickets
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

            // fetch('/api/tickets/waiting') // Assuming this endpoint exists and returns JSON
                fetch("{{ route('tiket.waiting.data') }}")
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
                                                <td class="font-semibold w-1/3 py-2">Ticket Number</td>
                                                <td class="py-2">${ticket.no_tiket}</td>
                                            </tr>
                                        
                                            <tr>
                                                <td class="font-semibold py-2">Department</td>
                                                <td class="py-2">${ticket.departemen.nama_unit}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Ruangan</td>
                                                <td class="py-2">${ticket.ruangans?.nama_ruangan || '-'}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Create Date</td>
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
                                                <td class="font-semibold py-2">Problem Image</td>
                                                <td class="py-2">${imageLink}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Action</td>
                                                <td class="py-2">
                                                    <button 
                                                        type="button" 
                                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md btn-close" 
                                                        data-id="${ticket.id}"
                                                        data-url="{{ route('tiket.close', ':id') }}">
                                                        Close Ticket
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
                // Delegasi klik tombol close
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('btn-close')) {
                        const id = e.target.dataset.id;
                        let url = e.target.dataset.url.replace(':id', id);
                        closeTicket(url);
                    }
                });

                function closeTicket(url) {
                    if (!confirm('Apakah Anda yakin ingin menutup tiket ini?')) return;

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ status: 'closed' })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            // refresh daftar tiket, misal fungsi loadWaitingTickets()
                            if (typeof loadWaitingTickets === 'function') loadWaitingTickets();
                        } else {
                            alert('Gagal menutup tiket.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menutup tiket.');
                    });
                }
            });

        // Function to load tickets with 'process' status
            function loadProcessTickets() {
                const container = document.getElementById('processTicketsContainer');
                const loadingIndicator = document.getElementById('loadingProcessTickets');
                if (loadingIndicator) loadingIndicator.classList.remove('hidden');
                container.innerHTML = ''; // Clear previous tickets

                fetch('{{ route("tiket.process.data") }}') // Assuming this route exists and returns process tickets
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

                            const ticketCardHtml = `
                                <div class="w-full bg-white shadow-md rounded-lg border">
                                    <input type="checkbox" id="accordion-ticket-process-${ticket.id}" class="hidden peer" />
                                    <label for="accordion-ticket-process-${ticket.id}" class="flex items-center justify-between p-4 bg-blue-100 hover:bg-blue-200 rounded-t-lg cursor-pointer">
                                        <div class="flex items-center space-x-3">
                                            <div class="bg-blue-500 p-2 rounded-md">
                                                <img src="{{url('images/iconpack/ticketing/jde.svg')}}" class="w-6 h-6" alt="icon" />
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">${ticketCategoryText}</p>
                                                <p class="text-gray-600 text-xs">Sedang Proses</p>
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
                                                <td class="font-semibold py-2">Departemen</td>
                                                <td class="py-2">${ticket.departemen.nama_unit}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Ruangan</td>
                                                <td class="py-2">${ticket.ruangans?.nama_ruangan || '-'}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Tanggal Dibuat</td>
                                                <td class="py-2">${ticket.tgl_pembuatan}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Diambil Oleh</td>
                                                <td class="py-2">${ticket.petugas_proses.name || '-'}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Waktu Diambil</td>
                                                <td class="py-2">${ticket.tgl_proses || '-'}</td>
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

        // Function to load tickets with 'pending' status
            function loadPendingTickets() {
                const container = document.getElementById('pendingTicketsContainer');
                const loadingIndicator = document.getElementById('loadingPendingTickets');
                if (loadingIndicator) loadingIndicator.classList.remove('hidden');
                container.innerHTML = ''; // Clear previous tickets

                fetch('{{ route("tiket.pending.data") }}') // Assuming this route exists and returns pending tickets
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
                                    <label for="accordion-ticket-pending-${ticket.id}" class="flex items-center justify-between p-4 bg-blue-100 hover:bg-blue-200 rounded-t-lg cursor-pointer">
                                        <div class="flex items-center space-x-3">
                                            <div class="bg-blue-500 p-2 rounded-md">
                                                <img src="{{url('images/iconpack/ticketing/jde.svg')}}" class="w-6 h-6" alt="icon" />
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">${ticketCategoryText}</p>
                                                <p class="text-gray-600 text-xs">Pending</p>
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
                                                <td class="font-semibold py-2">Departemen</td>
                                                <td class="py-2">${ticket.departemen.nama_unit}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Ruangan</td>
                                                <td class="py-2">${ticket.ruangans?.nama_ruangan || '-'}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Tanggal Dibuat</td>
                                                <td class="py-2">${ticket.tgl_pembuatan}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Dipending Oleh</td>
                                                <td class="py-2">${ticket.petugas_pending.name || '-'}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2">Waktu Dipending</td>
                                                <td class="py-2">${ticket.tgl_pending || '-'}</td>
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
                                                <td class="font-semibold py-2">Deskripsi Pending</td>
                                                <td class="py-2">${ticket.desc_pending || '-'}</td>
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
                        container.innerHTML = '<div class="text-center text-red-500 py-8">Gagal memuat tiket. Silakan coba lagi.</div>';
                    });
            }
        // Function to load tickets with 'done' status
            function loadDoneTickets() {
                const container = document.getElementById('doneTicketsContainer');
                const loadingIndicator = document.getElementById('loadingDoneTickets');
                if (!container) return;

                if (loadingIndicator) loadingIndicator.classList.remove('hidden');
                container.innerHTML = ''; // Clear previous tickets

                // Assuming 'tiket.done.data.all' route is modified to NOT eager load 'details' and 'detailsfoto'
                fetch('{{ route("tiket.done.data") }}')
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

</body>
