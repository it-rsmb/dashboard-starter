@vite(['resources/js/settings/roles/index.js'])
<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Title -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                Roles Management
            </h1>
            <button id="btnAddRole" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                + Add Role
            </button>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table id="rolesTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Guard</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modalAddRole"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md">
            <!-- Header -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Add Role</h2>
                <button id="btnCloseModal"
                    class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">&times;</button>
            </div>

            <!-- Body -->
            <div class="p-6">
                <form id="formAddRole">
                    @csrf
                    <!-- Input Role Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name</label>
                        <input type="text" name="name"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2
                               bg-white dark:bg-gray-700
                               text-gray-900 dark:text-gray-100
                               placeholder-gray-400 dark:placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter role name">
                    </div>

                    <!-- Input Guard -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Guard</label>
                        <input type="text" name="guard_name" value="web"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2
                               bg-white dark:bg-gray-700
                               text-gray-900 dark:text-gray-100
                               placeholder-gray-400 dark:placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <button type="button" id="btnCancel"
                            class="mr-2 px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
