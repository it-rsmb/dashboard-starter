<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Dashboard</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Filter button -->
                <x-dropdown-filter align="right" />

                <!-- Datepicker built with flatpickr -->
                <x-datepicker />

                <!-- Add view button -->
                <button class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                    <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                  </svg>
                  <span class="max-xs:sr-only">Add View</span>
                </button>
                
            </div>

        </div>
        
        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">


            <!-- Bar chart (Direct vs Indirect) -->
            <x-tiket.tiket_user-card />


        </div>

    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Helper function to initialize/re-initialize Select2
    function initSelect2ForElement(element, placeholder, data = [], idKey = 'id', textKey = 'text') {
        element.empty(); // Clear existing options
        element.append('<option value="">' + placeholder + '</option>'); // Add default option

        $.each(data, function(index, item) {
            element.append('<option value="' + item[idKey] + '">' + item[textKey] + '</option>');
        });

        // Destroy existing Select2 instance if it exists before re-initializing
        if (element.data('select2')) {
            element.select2('destroy');
        }

        // Initialize Select2
        element.select2({
            placeholder: placeholder,
            allowClear: true
        });
    }

    // Function to load units
    function loadUnits() {
        $.ajax({
            url: '{{ route("tiket.units") }}', // Use Laravel's route helper
            method: 'GET',
            success: function(data) {
                var unitSelect = $('.unit-select');
                initSelect2ForElement(unitSelect, "Pilih Unit", data, 'id_unit', 'nama_unit');
            },
            error: function(xhr, status, error) {
                console.error("Error loading units: " + error);
                initSelect2ForElement($('.unit-select'), "Pilih Unit", []); // Clear on error
            }
        });
    }

    $(document).ready(function() {
        // Load units on page load
        loadUnits();

        // Initialize ruangan select (empty initially)
        initSelect2ForElement($('.ruangan-select'), "Pilih Ruangan");

        // Handle change event for unit selection
        $('.unit-select').on('change', function() {
            let unitId = $(this).val();
            let $ruanganSelect = $('.ruangan-select'); // Target the ruangan select on this page

            if (unitId) {
                let url = '{{ route("tiket.units.ruangans", ":id_unit") }}';
                url = url.replace(':id_unit', unitId);

                $.ajax({
                    url: url,
                    type: "get",
                    dataType: "json",
                    success: function(data) {
                        initSelect2ForElement($ruanganSelect, "Pilih Ruangan", data, 'id_ruangan', 'nama_ruangan');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading ruangans: " + error);
                        initSelect2ForElement($ruanganSelect, "Pilih Ruangan", []); // Clear on error
                    }
                });
            } else {
                // If unit is cleared, clear ruangan select
                initSelect2ForElement($ruanganSelect, "Pilih Ruangan", []);
            }
        });
    });
</script>
