<nav class="sticky top-0 z-50 backdrop-blur bg-white/80 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex items-center justify-between h-16">

            <!-- LOGO -->
            <a href="/" class="flex items-center gap-2 text-xl font-bold text-gray-800 hover:text-blue-600 transition">
                <span class="text-2xl">🏠</span>
                <span>NhaTro</span>
            </a>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">

                @auth

                    <!-- ADMIN BUTTON -->
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin"
                           class="px-4 py-2 rounded-full bg-gradient-to-r from-gray-800 to-black text-white text-sm hover:scale-105 transition shadow">
                            ⚙️ Admin
                        </a>
                    @endif

                    <!-- USER DROPDOWN -->
                    <div class="relative group">

                        <button class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-full transition shadow-sm">
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <span class="text-xs">▼</span>
                        </button>

                        <!-- DROPDOWN -->
                        <div class="absolute right-0 mt-3 w-48 bg-white border border-gray-200 shadow-xl rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">

                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-2 text-sm hover:bg-gray-100 rounded-t-xl">
                                👤 Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 text-sm hover:bg-red-50 text-red-500 rounded-b-xl">
                                    🚪 Logout
                                </button>
                            </form>

                        </div>

                    </div>

                @endauth

                @guest

                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm border border-gray-300 rounded-full hover:bg-gray-100 transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-blue-500 text-white rounded-full text-sm hover:bg-blue-600 transition shadow">
                        Register
                    </a>

                @endguest

            </div>

        </div>

    </div>
</nav>