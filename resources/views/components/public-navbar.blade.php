<header class="sticky top-0 z-100 border-b-3 border-neutral-950 bg-[#fffdf7]/95 backdrop-blur">
    <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
        <a href="{{ route('home') }}" class="group flex items-center gap-3">
            <span class="grid size-10 place-items-center border-3 border-neutral-950 bg-white font-black shadow-[4px_4px_0_#141414] transition-transform group-hover:-translate-y-0.5">S</span>
            <span>
                <span class="block text-lg font-black leading-none tracking-tight">SIROMA</span>
                <span class="hidden text-xs font-bold uppercase tracking-[0.18em] text-neutral-600 sm:block">Recruitment System</span>
            </span>
        </a>

        <div class="hidden items-center gap-6 text-sm font-black md:flex">
            <a href="{{ route('recruitments.index') }}" class="hover:underline hover:decoration-3 hover:underline-offset-4">Rekrutmen</a>
            @auth
                <a href="{{ route('profile.show') }}" class="max-w-44 truncate text-neutral-700 hover:underline hover:decoration-3 hover:underline-offset-4">{{ auth()->user()->full_name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="ink-button ink-button-secondary px-4 py-2 text-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:underline hover:decoration-3 hover:underline-offset-4">Login</a>
                <a href="{{ route('register') }}" class="ink-button ink-button-primary px-4 py-2 text-sm">Register</a>
            @endauth
            @auth
                @if(auth()->user()->hasAnyRole(['super_admin', 'reviewer']))
                    <a href="{{ url('/admin') }}" class="ink-button ink-button-secondary px-4 py-2 text-sm">Panel Admin</a>
                @endif
            @endauth
        </div>

        <div class="flex items-center gap-2 md:hidden">
            @auth
                @if(auth()->user()->hasAnyRole(['super_admin', 'reviewer']))
                    <a href="{{ url('/admin') }}" class="ink-button ink-button-secondary px-3 py-2 text-xs">Admin</a>
                @endif
                <a href="{{ route('profile.show') }}" class="ink-button ink-button-primary px-3 py-2 text-xs">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="ink-button ink-button-secondary px-3 py-2 text-xs">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="ink-button ink-button-secondary px-3 py-2 text-xs">Login</a>
            @endauth
        </div>
    </nav>
</header>
