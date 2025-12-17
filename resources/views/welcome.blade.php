<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Restaurant API</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                red: '#722022',
                                black: '#1B1B1E',
                                gray: '#BEBABF',
                                white: '#FBFFFE',
                                green: '#8A9556',
                                beige: '#EAECDB',
                            }
                        },
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
        <style>
            .glass {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
        </style>
    </head>
    <body class="bg-brand-white text-brand-black antialiased font-sans">
        <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-green/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-brand-red/10 rounded-full blur-3xl"></div>

            <!-- Content -->
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="text-center mb-16">
                    <h1 class="text-5xl md:text-7xl font-bold text-brand-red mb-4 tracking-tight">
                        Sushi Experience
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Backend Service & API
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Reservation Card -->
                    <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 border border-brand-red/10 group cursor-default">
                        <div class="h-12 w-12 bg-brand-red/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-brand-red group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-brand-black mb-2">{{ config('app_texts.ui.welcome.reservation_card_title') }}</h2>
                        <p class="text-gray-500 mb-6">{{ config('app_texts.ui.welcome.reservation_card_description') }}</p>
                        <div class="bg-gray-50 rounded-xl p-4 font-mono text-sm text-gray-600 border border-gray-100">
                            <span class="text-brand-red font-bold">POST</span> /api/reservations
                        </div>
                    </div>

                    <!-- Delivery Card -->
                    <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 border border-brand-red/10 group cursor-default">
                        <div class="h-12 w-12 bg-brand-green/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-brand-green group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-brand-black mb-2">{{ config('app_texts.ui.welcome.delivery_card_title') }}</h2>
                        <p class="text-gray-500 mb-6">{{ config('app_texts.ui.welcome.delivery_card_description') }}</p>
                        <div class="bg-gray-50 rounded-xl p-4 font-mono text-sm text-gray-600 border border-gray-100">
                            <span class="text-brand-red font-bold">POST</span> /api/delivery-orders
                        </div>
                    </div>
                </div>

                <div class="mt-16 text-center">
                <div class="mt-16 text-center">
                    <div id="status-badge" class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 text-gray-500 font-medium text-sm transition-colors duration-500">
                        <span id="status-dot" class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                        <span id="status-text">{{ config('app_texts.ui.welcome.status_checking') }}</span>
                    </div>
                    <p class="mt-4 text-gray-400 text-sm">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </p>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const badge = document.getElementById('status-badge');
                const dot = document.getElementById('status-dot');
                const text = document.getElementById('status-text');

                fetch('/api/health')
                    .then(response => {
                        if (response.ok) {
                            badge.classList.remove('bg-gray-100', 'text-gray-500');
                            badge.classList.add('bg-green-100', 'text-brand-green');
                            
                            dot.classList.remove('bg-gray-400');
                            dot.classList.add('bg-brand-green', 'animate-pulse');
                            
                            text.textContent = '{{ config('app_texts.ui.welcome.status_operational') }}';
                        } else {
                            throw new Error('{{ config('app_texts.ui.welcome.status_api_error') }}');
                        }
                    })
                    .catch(error => {
                        badge.classList.remove('bg-gray-100', 'text-gray-500');
                        badge.classList.add('bg-red-100', 'text-brand-red');
                        
                        dot.classList.remove('bg-gray-400');
                        dot.classList.add('bg-brand-red');
                        
                        text.textContent = '{{ config('app_texts.ui.welcome.status_unavailable') }}';
                        console.error('Health check failed:', error);
                    });
            });
        </script>
    </body>
</html>
