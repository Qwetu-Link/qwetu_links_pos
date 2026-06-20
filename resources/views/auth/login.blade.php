@extends('layouts.auth.login')

{{-- @section('title', $seo['title']) --}}

{{-- @section('meta')
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    <meta property="og:title" content="{{ $seo['og_title'] }}">
    <meta property="og:description" content="{{ $seo['og_description'] }}">
@endsection --}}

@section('content')
    <div class="split-layout">
        <!-- Left Side: Logo Image (Qwetu Link POS) -->
        <div class="left-side">
            <div class="logo-container">
                <!-- SVG Logo as requested: Qwetu Link POS -->
                <img src="{{ asset('image/qwetu_link_pos.png') }}" alt="Qwetu Link POS" />
            </div>
        </div>

        <!-- Right Side: Form Card (overlaps logo) -->
        <div class="right-side">
            <div class="form-card p-8 fade-in">
                <div class="text-center mb-6">
                    <div class="img-container1 inline-flex items-center justify-center w-16 h-16  mb-4">
                        <img src="{{ asset('image/qwetu_link_pos.png') }}" alt="Qwetu Link POS" />
                    </div>
                    <h2 class="text-2xl font-bold text-white">Welcome Back</h2>
                    <p class="text-gray-300 text-sm mt-1">
                        Sign in to access your dashboard
                    </p>
                </div>

                <form id="loginForm" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">
                            <i class="fas fa-envelope mr-2 text-emerald-400"></i>Email
                            Address
                        </label>
                        <input type="email" id="email" required placeholder="admin@lipamdogo.com"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500 input-focus transition-all" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-200 mb-2">
                            <i class="fas fa-lock mr-2 text-emerald-400"></i>Password
                        </label>
                        <div class="relative">
                            <input type="password" id="password" required placeholder="••••••••"
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500 input-focus transition-all pr-12" />
                            <button type="button" id="togglePassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-400 transition">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" id="rememberMe"
                                class="w-4 h-4 rounded border-white/20 bg-white/10 text-emerald-500 focus:ring-emerald-500" />
                            <span class="ml-2 text-sm text-gray-300">Remember me</span>
                        </label>
                        <!-- <a
                    href="#"
                    id="forgotPassword"
                    class="text-sm text-emerald-400 hover:text-emerald-300 transition"
                    >Forgot password?</a
                  > -->
                    </div>

                    <button type="submit" id="loginBtn"
                        class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold py-3 rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        Sign In
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-white/10 text-center">
                    <p class="text-xs text-gray-400 mb-2">Demo Credentials</p>
                    <div class="flex flex-col gap-1 text-xs text-gray-300 bg-white/5 rounded-lg p-3">
                        <p>
                            <span class="text-emerald-400">Email:</span> admin@lipamdogo.com
                        </p>
                        <p><span class="text-emerald-400">Password:</span> admin123</p>
                    </div>
                </div>

                <div id="errorMessage" class="mt-4 hidden">
                    <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-3 text-center">
                        <p class="text-red-300 text-sm">
                            <i class="fas fa-exclamation-triangle mr-2"></i><span id="errorText">Invalid
                                credentials</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
