<?php
if (isset($_POST['logout'])) {
    // Call your logout function here
    session_encode();
    // Redirect to the login page or another page after logout
    header("Location: login.php");
    exit();
}
?>





<!-- Mobile Menu Button -->
<div class="md:hidden fixed top-4 right-4 z-50">
    <button @click="open = !open" class="p-2 bg-gray-800 text-white rounded focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>

<!-- Sidebar -->
<aside :class="{'translate-x-0': open, '-translate-x-full': !open}" class="w-64 bg-gray-800 text-gray-100 flex flex-col fixed h-full z-40 transform md:translate-x-0 transition-transform duration-200 ease-in-out md:relative">
    <div class="p-4 text-xl font-bold border-b border-gray-700">
        Dashboard
    </div>
    <nav class="flex-1 px-2 py-4 space-y-1">
        <div x-data="{ dropdownOpen: false }">
            <button @click="dropdownOpen = !dropdownOpen" class="w-full flex items-center justify-between px-2 py-2 text-left text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                Menu/NavBar
                <svg :class="{ 'transform rotate-180': dropdownOpen }" class="w-5 h-5 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="dropdownOpen" class="space-y-1 pl-4 mt-1">
                <a href="blogName.php" class="block px-2 py-2 text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-700 rounded-md">
                    Blog-Name
                </a>
                <a href="menuBar.php" class="block px-2 py-2 text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-700 rounded-md">
                    MenuBar
                </a>
            </div>
            <a href="post.php" class="w-full flex items-center justify-between px-2 py-2 text-left text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                Post
            </a>
        </div>
    </nav>
    <form action="logout.php" method="POST"">
        <button type="submit" name="logout" class="bg-red-500 hover:bg-red-600 text-white font-bold rounded m-5 py-3 px-20">
            Logout
        </button>
    </form>

</aside>