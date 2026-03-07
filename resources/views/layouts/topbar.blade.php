<header class="flex items-center justify-between h-16 px-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <!-- Sidebar Toggle (Mobile) -->
    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <!-- Search / Page Title (Optional) -->
    <div class="flex items-center">
        <!-- You can add a search bar or breadcrumbs here -->
    </div>

    <!-- Right Side Actions -->
    <div class="flex items-center space-x-4">
        <!-- Dark Mode Toggle -->
        <button @click="darkMode = !darkMode" class="p-2 text-gray-500 transition-colors duration-200 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
            <!-- Sun Icon -->
            <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <!-- Moon Icon -->
            <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>

        <!-- User Dropdown -->
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                <div class="w-full h-full bg-indigo-500 flex items-center justify-center text-white font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </button>

            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

            <div x-show="dropdownOpen" class="absolute right-0 z-20 w-48 mt-2 overflow-hidden bg-white dark:bg-gray-800 rounded-md shadow-xl border border-gray-100 dark:border-gray-700" style="display: none;">
                <div class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200 border-b border-gray-100 dark:border-gray-700">
                    <div class="font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                </div>
                
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-600 hover:text-white">Profile</a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-600 hover:text-white">Logout</a>
                </form>
            </div>
        </div>
    </div>
</header>