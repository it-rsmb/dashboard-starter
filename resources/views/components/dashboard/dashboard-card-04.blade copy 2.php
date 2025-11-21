
<body class="bg-gray-100 min-h-screen p-5">
    <div class="col-span-12 bg-white rounded-xl shadow-md p-5">
        <!-- Header -->
        <h1 class="text-2xl font-bold text-gray-800 mb-5">IT Support Task</h1>

        <!-- Tabs -->
        <div class="flex space-x-5 border-b border-gray-200">
            <a href="#" class="relative text-yellow-500 font-semibold pb-3 border-b-2 border-yellow-500">Waiting
                <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">5</span>
            </a>
            <a href="#" class="relative text-gray-500 hover:text-gray-700 font-semibold pb-3">On Process
                <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">2</span>
            </a>
            <a href="#" class="relative text-gray-500 hover:text-gray-700 font-semibold pb-3">Pending
                <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">3</span>
            </a>
        </div>

        <!-- Ticket Detail -->
        <div class="mt-5 border rounded-lg shadow-sm">

        

            <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg border">

                <!-- Checkbox untuk kontrol accordion -->
                <input type="checkbox" id="accordion-hardware" class="hidden peer" />

                <!-- Header Accordion -->
                <label for="accordion-hardware" class="flex items-center justify-between p-4 bg-blue-100 hover:bg-blue-200 rounded-t-lg cursor-pointer">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-500 p-2 rounded-md">
                            <img src="{{url('images/iconpack/ticketing/jde.svg')}}" class="w-6 h-6" alt="icon" />
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Hardware</p>
                            <p class="text-gray-600 text-xs">Menunggu Tiket</p>
                        </div>
                    </div>
                    <i class="fas fa-caret-right transform transition-transform duration-300 peer-checked:rotate-90"></i>
                </label>

                <!-- Konten Accordion -->
                <div class="accordion_content hidden peer-checked:block border-t p-4">
                    <table class="w-full text-sm border-collapse">
                        <tr>
                            <td class="font-semibold w-1/3 py-2">Ticket Number</td>
                            <td class="py-2">111</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-2">NIK</td>
                            <td class="py-2">1</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-2">Name</td>
                            <td class="py-2">Nama</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-2">Department</td>
                            <td class="py-2">debug_backtrace</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-2">IP Address</td>
                            <td class="py-2">ip <a href="#" class="text-blue-500 underline">Detail</a></td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-2">Ext</td>
                            <td class="py-2">extends</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-2">Create Date</td>
                            <td class="py-2">-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-2">Status</td>
                            <td class="py-2">-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-2">Problem Image</td>
                            <td class="py-2">Image not available</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-2">Action</td>
                            <td class="py-2">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                                        Close Ticket
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>




        </div>
        
    </div>
</body>

