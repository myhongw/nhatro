<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Pro</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">

        <div class="p-6 text-2xl font-bold border-b border-gray-700">
            ⚙️ Admin
        </div>

        <nav class="flex-1 p-4 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 p-3 rounded 
               {{ request()->is('admin') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                <i data-lucide="layout-dashboard"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-2 p-3 rounded 
               {{ request()->is('admin/users') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                <i data-lucide="users"></i>
                Users
            </a>

            <a href="{{ route('admin.rooms.index') }}"
               class="flex items-center gap-2 p-3 rounded 
               {{ request()->is('admin/rooms') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                <i data-lucide="home"></i>
                Rooms
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left flex items-center gap-2 hover:text-red-400">
                    <i data-lucide="log-out"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">

            <!-- SEARCH -->
            <input type="text" placeholder="🔍 Tìm kiếm..."
                class="border rounded px-4 py-2 w-1/3">

            <!-- USER -->
            <div class="relative">

                <button onclick="toggleDropdown()" 
                        class="flex items-center gap-2 font-semibold">
                    👤 {{ auth()->user()->name }}
                </button>

                <!-- DROPDOWN -->
                <div id="dropdown"
                     class="hidden absolute right-0 mt-2 w-40 bg-white shadow rounded">

                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-500">
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>

</div>

<script>
    lucide.createIcons();

    function toggleDropdown() {
        document.getElementById('dropdown').classList.toggle('hidden');
    }
</script>

</body>
</html>