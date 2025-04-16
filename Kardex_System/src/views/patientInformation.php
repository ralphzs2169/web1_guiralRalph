<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient Detail View</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    spacing: {
                        'sidebar': '250px'
                    },
                    zIndex: {
                        'overlay': '40'
                    }
                }
            }
        }
    </script>
</head>

<body class="h-screen overflow-hidden">
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-overlay" onclick="closeSidebar()"></div>
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-sky-700 text-white w-sidebar p-4 space-y-4 hidden md:block fixed md:static z-50 h-full md:h-auto transition-transform transform md:translate-x-0 -translate-x-full">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold">Colongan,<br>Joshua</h2>
                <button class="md:hidden text-white text-2xl font-bold" onclick="closeSidebar()">&times;</button>
            </div>
            <div class="mt-4">
                <p><strong>BED #:</strong></p>
                <p><strong>Gender:</strong></p>
                <p><strong>Age:</strong></p>
                <p><strong>Diagnosis:</strong></p>
            </div>
            <button class="mt-8 bg-white text-sky-700 font-bold px-4 py-2 rounded-md">Back</button>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">
            <!-- Top Bar -->
            <header class="bg-sky-500 text-white p-4 flex justify-between items-center shadow-md z-10">
                <div class="flex items-center">
                    <button class="md:hidden text-white mr-4" onclick="toggleSidebar()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <span class="font-bold text-lg">🔔 A note has been assigned to you</span>
                </div>
                <button class="bg-white text-sky-500 px-4 py-1 rounded-md font-bold">Logout</button>
            </header>

            <!-- Scrollable Main Content -->
            <main class="flex-1 overflow-auto p-4 bg-gray-50 relative">
                <div class="max-w-5xl mx-auto">
                    <div class="border border-blue-400 p-4 bg-white shadow rounded-md overflow-auto">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="border p-2">
                                <div class="flex justify-between items-center border-b pb-1 font-bold">
                                    <span>TREATMENTS</span><span>✎</span>
                                </div>
                                <div class="h-40"></div>
                                <div class="border-t pt-1 mt-2 font-bold flex justify-between items-center">
                                    <span>REFERRALS</span><span>✎</span>
                                </div>
                                <p class="mt-1 text-xs">DEPT.</p>
                                <p class="text-xs">RE:</p>
                            </div>
                            <div class="border p-2">
                                <div class="border-b pb-1 font-bold">ATTACHMENTS</div>
                                <div class="h-full"></div>
                            </div>
                            <div class="border p-2">
                                <div class="flex justify-between items-center border-b pb-1 font-bold">
                                    <span>IVF/INFUSIONS</span><span>✎</span>
                                </div>
                                <div class="text-xs mt-2">
                                    <div class="grid grid-cols-4 font-bold border-b">
                                        <div class="p-1">DATE</div>
                                        <div class="p-1">BOTTLE NO.</div>
                                        <div class="p-1">IVF</div>
                                        <div class="p-1">RATE</div>
                                    </div>
                                    <div class="grid grid-cols-4 text-center">
                                        <div class="p-1">+</div>
                                        <div class="p-1"></div>
                                        <div class="p-1"></div>
                                        <div class="p-1"></div>
                                    </div>
                                    <div class="grid grid-cols-4 font-bold border-t border-b mt-2">
                                        <div class="p-1">DATE</div>
                                        <div class="p-1">BOTTLE NO.</div>
                                        <div class="p-1">IVF</div>
                                        <div class="p-1">RATE</div>
                                    </div>
                                    <div class="grid grid-cols-4 text-center">
                                        <div class="p-1">+</div>
                                        <div class="p-1"></div>
                                        <div class="p-1"></div>
                                        <div class="p-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-300 p-4 flex justify-between items-center shadow-inner">
                <button class="bg-gray-200 text-black px-4 py-2 rounded-md">Notes</button>
                <button class="bg-sky-500 text-white font-bold px-6 py-2 rounded-md hover:bg-sky-600 transition">Save</button>
            </footer>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.remove('hidden');
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0');
            overlay.classList.toggle('hidden');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
        }
    </script>
</body>

</html>