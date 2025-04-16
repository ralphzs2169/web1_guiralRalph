<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative h-screen bg-cover bg-center" style="background-image: url('../public/images/bg3.png');">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-white bg-opacity-80 z-0"></div>

    <!-- Main Content -->
    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 text-center">

        <!-- Profile Card Container -->
        <div class="flex flex-col sm:flex-row items-center bg-white bg-opacity-90 p-8 sm:p-12 rounded-xl shadow-2xl max-w-5xl w-full space-y-6 sm:space-y-0 sm:space-x-12">

            <!-- Profile Section (left side) -->
            <div class="relative flex flex-col items-center">
                <!-- Nurse Hat Icon -->
                <img src="../public/images/new-nurse-icon.png" alt="Nurse Hat" class="absolute -top-10 w-20 h-20" />

                <!-- Profile Image -->
                <img src="profile.png" alt="Profile" class="mt-12 w-36 h-36 object-cover rounded-md border-4 border-white shadow-lg" />
            </div>

            <!-- Text & Buttons (right side) -->
            <div class="text-center sm:text-left">
                <h1 class="text-3xl sm:text-4xl font-extrabold">Balbuena, Mark Paul</h1>
                <p class="text-xl font-semibold text-gray-700 mt-2">Medical Ward Extension</p>

                <div class="mt-8 flex flex-col space-y-4 sm:items-start items-center">
                    <button class="bg-sky-500 text-white font-semibold px-6 py-3 text-lg rounded-md hover:bg-sky-600 transition w-60">Change Task Passcode</button>
                    <button class="bg-sky-500 text-white font-semibold px-8 py-3 text-lg rounded-md hover:bg-sky-600 transition w-60">Endorsement</button>
                </div>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="absolute bottom-6 sm:bottom-8 right-6 sm:right-10 sm:left-auto left-1/2 sm:translate-x-0 -translate-x-1/2">
            <button class="bg-sky-500 text-white font-semibold px-8 py-3 text-lg rounded-md hover:bg-sky-600 transition">
                Logout
            </button>
        </div>
    </div>
</body>

</html>