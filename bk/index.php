<?php 
session_start();
if (!$_SESSION['isAdmin']) {
    header("Location: login.php");
}
// session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Sidebar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div x-data="{ open: false }" class="flex h-screen">
        <?php include('sidebar.php') ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:ml-[100%-256px]">
            <div class="w-full h-full flex items-center justify-center">
                <h2 class="text-5xl">
                Wellcome <?php echo $_SESSION['name']; ?> !
                </h2>
            </div>
        </main>
    </div>

    <!-- AlpineJS (for dropdown functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.2.3/dist/cdn.min.js" defer></script>
</body>
</html>
