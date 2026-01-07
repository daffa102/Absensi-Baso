<div class="w-full max-w-md relative z-10">
    <!-- Logo & Header -->
    <div class="text-center mb-10">
        <a href="https://www.idn.id/" class="inline-flex items-center gap-2 mb-6 group">
            <div
                class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg group-hover:scale-110 transition-transform">
                L</div>
            <span class="text-2xl font-black tracking-tight text-slate-900">Logo</span>
        </a>
        <h1 class="text-3xl font-black text-slate-900">Selamat Datang</h1>
        <p class="text-slate-500 mt-2 font-medium">Masuk ke akun sekolah Anda</p>
    </div>

    <!-- Login Card -->
    <div class="glass-card p-8 md:p-10 rounded-[2.5rem] shadow-2xl shadow-blue-200/50">
        <!-- Error Message -->
        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl animate-shake">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->has('login'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl animate-shake">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-red-800">{{ $errors->first('login') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form wire:submit.prevent="login" class="space-y-6">

            <div class="space-y-2">
                <label for="email" class="text-sm font-bold text-slate-700 ml-1">Email</label>
                <div class="relative">
                    <input type="text" id="email" wire:model="email" placeholder="contoh@sekolah.id"
                        class="w-full px-5 py-4 bg-white border @error('email') border-red-500 @else border-slate-200 @enderror rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-300 font-medium">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs font-semibold ml-1 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-center ml-1">
                    <label for="password" class="text-sm font-bold text-slate-700">Kata Sandi</label>
                </div>
                <div class="relative">
                    <input type="password" id="password" wire:model="password" placeholder="••••••••"
                        class="w-full px-5 py-4 bg-white border @error('password') border-red-500 @else border-slate-200 @enderror rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-300 font-medium">
                </div>
                @error('password')
                    <p class="text-red-500 text-xs font-semibold ml-1 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-black text-lg shadow-xl shadow-blue-500/20 hover:shadow-blue-500/40 hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove>Masuk Sekarang</span>
                <span wire:loading class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memproses...
                </span>
            </button>
        </form>
    </div>
</div>
