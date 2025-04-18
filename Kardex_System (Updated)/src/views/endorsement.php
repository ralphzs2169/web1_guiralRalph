<?php
require_once __DIR__ . '/../../config/session.php';

if (!isset($_SESSION['user_id'])) {
    // Not logged in — redirect to login page or deny access
    header("Location: /kardex_system/src/views/login.html");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Medical Extension Ward</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="../public/js/newPatientHandler.js" defer></script>
</head>

<body class="h-screen flex flex-col">

    <!-- 🔵 Fixed Top Bar -->
    <header class="bg-[#5EACDE] text-white text-3xl font-bold py-4 text-center shadow-md z-10">
        Medical Extension Ward
    </header>

    <!-- 🔲 Scrollable Content Area -->
    <main class="flex-1 overflow-y-auto bg-white px-6 py-4">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 justify-items-center">
            <!-- 📁 Example Folder -->
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 1 - COLONGAN</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 2 - CORTES</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 1 - COLONGAN</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 2 - CORTES</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 1 - COLONGAN</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 2 - CORTES</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 1 - COLONGAN</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 2 - CORTES</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 1 - COLONGAN</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 2 - CORTES</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 1 - COLONGAN</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 2 - CORTES</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 1 - COLONGAN</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 2 - CORTES</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 1 - COLONGAN</p>
            </div>
            <div class="flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer">
                <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
                <p class="font-bold mt-2 text-center">BED 2 - CORTES</p>
            </div>
        </div>
    </main>

    <!-- ⚪ Fixed Bottom Bar -->
    <footer class="bg-white border-t border-gray-300 py-4 px-6 flex justify-between items-center shadow-inner z-10">
        <button id="new-patient" class="flex items-center text-black font-semibold">
            <div class="w-8 h-8 bg-sky-500 rounded-full flex items-center justify-center mr-2 text-white text-xl">+</div>
            New Patient
        </button>
        <button class="bg-sky-500 text-white font-bold px-6 py-2 rounded-md hover:bg-sky-600 transition">Logout</button>
    </footer>

    <!-- New Patient Popup -->
    <div id="newPatientPopup" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden ">
        <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl relative">

            <!-- Close Button -->
            <button id="close-patientForm" class="absolute top-3 right-3 text-xl font-bold text-gray-600 hover:text-gray-800">×</button>

            <h2 class="text-center text-sky-600 font-semibold text-sm mb-4">NEW PATIENT</h2>

            <form id="patientForm" class="space-y-3" novalidate>
                <div>
                    <label class="block text-xs font-bold text-black mb-1">PERSONAL INFORMATION:</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <input type="text" id="first-name" name="firstName" placeholder="First Name" required
                                class="w-full border px-2 py-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <input type="text" id="middle-initial" name="middleInitial" placeholder="M.I." maxlength="1"
                                class="w-full border px-2 py-1 rounded uppercase focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <input type="text" id="last-name" name="lastName" placeholder="Last Name" required
                                class="w-full border px-2 py-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="bed" class="block text-xs font-bold text-black">BED #:</label>
                    <input id="bed" type="text" class="w-full border px-2 py-1 rounded" required />
                </div>
                <div>
                    <label for="dob" class="block text-xs font-bold text-black">DATE OF BIRTH:</label>
                    <input id="dob" type="date" class="w-full border px-2 py-1 rounded" required />
                </div>
                <div>
                    <label for="gender" class="block text-xs font-bold text-black">GENDER:</label>
                    <select id="gender" class="w-full border px-2 py-1 rounded" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Non-binary">Non-binary</option>
                        <option value="Prefer not to say">Prefer not to say</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-xs font-bold text-black">STATUS:</label>
                    <input id="status" type="text" class="w-full border px-2 py-1 rounded" placeholder="e.g. Single, Married" />
                </div>
                <div>
                    <label for="nationality" class="block text-xs font-bold text-black">NATIONALITY:</label>
                    <input id="nationality" type="text" class="w-full border px-2 py-1 rounded" placeholder="e.g. Filipino, American" />
                </div>
                <div>
                    <label for="religion" class="block text-xs font-bold text-black">RELIGION:</label>
                    <input id="religion" type="text" class="w-full border px-2 py-1 rounded" placeholder="e.g. Catholic, Islam" />
                </div>
                <div>
                    <label for="physician" class="block text-xs font-bold text-black">PHYSICIAN:</label>
                    <input id="physician" type="text" class="w-full border px-2 py-1 rounded" />
                </div>
                <div>
                    <label for="diagnosis" class="block text-xs font-bold text-black">DIAGNOSIS:</label>
                    <input id="diagnosis" type="text" class="w-full border px-2 py-1 rounded" required />
                </div>

                <button type="submit" class="mt-3 w-full bg-sky-500 text-white py-2 rounded hover:bg-sky-600 transition">
                    Save
                </button>
            </form>


        </div>
    </div>

</body>

</html>