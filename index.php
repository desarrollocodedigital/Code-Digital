<?php 
include 'models/proyectos.php'; 
include 'models/clientes.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Digital - Plataformas de Software e IA</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Configuración y lógica principal -->
    <script src="assets/js/main.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="font-sans min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300 selection:bg-brand-lime/30 dark:selection:bg-brand-cyan/30 selection:text-gray-900 dark:selection:text-white">

    <!-- NAVBAR -->
    <nav class="absolute top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-5 lg:px-12 max-w-7xl mx-auto w-full bg-white/70 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100/50 dark:border-gray-800/80 transition-colors duration-300">
        
        <!-- LOGO CODE DIGITAL -->
        <div class="flex items-center gap-1 group cursor-pointer">
            <svg width="28" height="28" viewBox="0 0 100 100" class="mr-1 transform group-hover:scale-105 transition-transform">
                <!-- Bracket Izquierdo Blanco/Oscuro -->
                <path d="M 35 25 L 15 50 L 35 75" fill="none" stroke="currentColor" class="text-gray-900 dark:text-white" stroke-width="12" stroke-linecap="square" stroke-linejoin="miter"/>
                <!-- Slash Cian -->
                <path d="M 58 15 L 42 85" fill="none" stroke="#00E5FF" stroke-width="12" stroke-linecap="square" />
                <!-- Bracket Derecho Lima -->
                <path d="M 65 25 L 85 50 L 65 75" fill="none" stroke="#B2FF05" stroke-width="12" stroke-linecap="square" stroke-linejoin="miter" />
            </svg>
            <span class="text-xl font-bold tracking-tighter text-gray-900 dark:text-white flex items-center">
                <span class="font-medium mr-0.5">Code</span><span class="text-brand-lime">Digital</span>
            </span>
        </div>
        
        <div class="hidden lg:flex items-center gap-8 text-sm font-semibold text-gray-500 dark:text-gray-400">
            <a href="#especialidades" class="hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">Servicios</a>
            <a href="#portafolio" class="hover:text-brand-lime dark:hover:text-brand-lime transition-colors">Portafolio</a>
            <a href="#clientes" class="hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">Clientes</a>
            <a href="#contacto" class="hover:text-brand-lime dark:hover:text-brand-lime transition-colors">Contacto</a>
        </div>

        <div class="flex items-center gap-4">
            <!-- Botón Dark Mode -->
            <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-brand-cyan dark:hover:text-brand-cyan focus:outline-none rounded-lg text-sm p-2 transition-colors duration-300">
                <i id="theme-toggle-dark-icon" data-lucide="moon" class="hidden w-5 h-5"></i>
                <i id="theme-toggle-light-icon" data-lucide="sun" class="hidden w-5 h-5"></i>
            </button>

            <a href="https://wa.me/526672644610?text=Hola,%20me%20gustaria%20agendar%20una%20llamada,%20espero%20tu%20respuesta." target="_blank" class="hidden md:inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-bold transition-all duration-200 text-sm border bg-brand-cyan text-gray-900 border-brand-cyan hover:bg-brand-lime hover:border-brand-lime shadow-lg shadow-brand-cyan/20">
                <i data-lucide="phone" class="w-4 h-4 mr-2"></i> Agendar Llamada
            </a>
            <button id="mobile-menu-btn" type="button" class="lg:hidden text-gray-900 dark:text-white transition-colors duration-300 p-2 focus:outline-none">
                <i data-lucide="menu" class="w-6 h-6 pointer-events-none"></i>
            </button>
        </div>
    </nav>

    <main>
        <!-- HERO SECTION -->
        <section class="relative pt-36 pb-20 lg:pt-48 lg:pb-32 bg-[#f8fafc] dark:bg-gray-900 overflow-hidden text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-800 transition-colors duration-300">
            <!-- Destellos adaptados a Code Digital -->
            <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-brand-cyan/10 dark:bg-brand-cyan/20 rounded-full blur-[100px] pointer-events-none opacity-60"></div>
            <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-brand-lime/10 dark:bg-brand-lime/20 rounded-full blur-[100px] pointer-events-none opacity-60"></div>

            <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                
                <div class="lg:col-span-7 space-y-8">
                    <h1 class="text-4xl lg:text-6xl font-bold leading-[1.1] tracking-tight text-[#111827] dark:text-white transition-colors duration-300">
                        Código que inspira.<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-cyan to-brand-lime drop-shadow-sm">Resultados que impactan.</span>
                    </h1>
                    <p class="text-lg text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed font-medium transition-colors duration-300">
                        Somos un estudio de desarrollo de software que convierte ideas complejas en soluciones digitales elegantes y de alto rendimiento.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 pt-2">
                        <a href="https://wa.me/526672644610?text=Hola,%20me%20gustaria%20agendar%20una%20llamada,%20espero%20tu%20respuesta." target="_blank" class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-bold transition-all duration-200 text-sm border bg-brand-cyan text-gray-900 border-brand-cyan hover:bg-brand-lime hover:border-brand-lime shadow-lg shadow-brand-cyan/20">
                            <i data-lucide="phone" class="w-4 h-4 mr-2"></i> Agendar Llamada
                        </a>
                        <a href="#contacto" class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-semibold transition-all duration-200 text-sm border bg-white dark:bg-gray-800 text-gray-900 dark:text-white border-gray-200 dark:border-gray-700 hover:border-brand-cyan dark:hover:border-brand-cyan hover:text-brand-cyan dark:hover:text-brand-cyan hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm">
                            <i data-lucide="message-square" class="w-4 h-4 mr-2"></i> Hablar con un Experto
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5 flex flex-col gap-4 relative">
                    <!-- Rating Card 1 -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-none p-6 rounded-2xl flex items-center justify-between transform transition-all duration-300 hover:-translate-y-1 cursor-default ml-0 group">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 mb-1 uppercase tracking-wider group-hover:text-brand-cyan transition-colors">Calificado en Clutch</div>
                            <div class="flex gap-1">
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-[#111827] dark:text-white">4.9</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">150+ Reseñas</div>
                        </div>
                    </div>
                    <!-- Rating Card 2 -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-none p-6 rounded-2xl flex items-center justify-between transform transition-all duration-300 hover:-translate-y-1 cursor-default ml-6 group">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 mb-1 uppercase tracking-wider group-hover:text-brand-lime transition-colors">Calificado en Google</div>
                            <div class="flex gap-1">
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-[#111827] dark:text-white">4.8</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">120+ Reseñas</div>
                        </div>
                    </div>
                    <!-- Rating Card 3 -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-none p-6 rounded-2xl flex items-center justify-between transform transition-all duration-300 hover:-translate-y-1 cursor-default ml-12 group">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 mb-1 uppercase tracking-wider group-hover:text-brand-cyan transition-colors">Calificado en Upwork</div>
                            <div class="flex gap-1">
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-[#111827] dark:text-white">5.0</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">200+ Reseñas</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- INNOVATION SECTION -->
        <section class="py-24 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 overflow-hidden transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    
                    <div class="relative aspect-square max-w-[280px] sm:max-w-md mx-auto w-full flex items-center justify-center group">
                        <div class="absolute inset-0 border-[1.5px] border-dashed border-gray-200 dark:border-gray-700 rounded-full animate-[spin_40s_linear_infinite]"></div>
                        <div class="absolute inset-4 border-[1px] border-brand-cyan/30 dark:border-brand-cyan/20 rounded-full opacity-40"></div>
                        <div class="absolute inset-8 border-[1px] border-brand-cyan/10 dark:border-gray-800 rounded-full bg-[#f8fafc] dark:bg-gray-800/50 transition-all duration-700 group-hover:scale-105"></div>
                        
                        <svg class="absolute inset-12 w-[calc(100%-6rem)] h-[calc(100%-6rem)] animate-[spin_25s_linear_infinite]" style="animation-direction: reverse;" viewBox="0 0 100 100">
                            <!-- Aro Gris -->
                            <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" class="text-gray-100 dark:text-gray-800" stroke-width="8" />
                            <!-- Aro Cian -->
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#00E5FF" stroke-width="8" stroke-dasharray="60 300" stroke-linecap="round" />
                            <!-- Aro Lima -->
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#B2FF05" stroke-width="8" stroke-dasharray="60 300" stroke-linecap="round" transform="rotate(120 50 50)" />
                            <!-- Aro Oscuro/Blanco -->
                            <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" class="text-[#111827] dark:text-gray-300" stroke-width="8" stroke-dasharray="60 300" stroke-linecap="round" transform="rotate(240 50 50)" />
                        </svg>

                        <div class="relative z-10 w-32 h-32 sm:w-48 sm:h-48 bg-white dark:bg-gray-800 rounded-full shadow-[0_8px_30px_rgb(0,229,255,0.1)] dark:shadow-none flex items-center justify-center text-center p-4 sm:p-6 border-4 border-[#f8fafc] dark:border-gray-700">
                            <div>
                                <div class="text-transparent bg-clip-text bg-gradient-to-r from-brand-cyan to-brand-lime font-black text-2xl sm:text-3xl mb-1">IA</div>
                                <p class="text-[9px] sm:text-[11px] text-gray-500 dark:text-gray-400 font-medium leading-tight">Motor cognitivo en tiempo real</p>
                            </div>
                        </div>
                        
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-[#111827] dark:bg-gray-100 text-white dark:text-gray-900 px-3 sm:px-4 py-1 sm:py-1.5 rounded-xl text-[10px] sm:text-xs font-bold shadow-md border border-gray-800 dark:border-white animate-bounce">Automatización</div>
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 bg-brand-cyan text-gray-900 px-3 sm:px-4 py-1 sm:py-1.5 rounded-xl text-[10px] sm:text-xs font-bold shadow-md border border-brand-cyan transform hover:scale-110 transition-transform cursor-default">Machine Learning</div>
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/2 bg-brand-lime text-gray-900 px-3 sm:px-4 py-1 sm:py-1.5 rounded-xl text-[10px] sm:text-xs font-bold shadow-md border border-brand-lime">Análisis Predictivo</div>
                    </div>

                    <div class="space-y-10">
                        <div>
                            <h2 class="text-3xl font-bold text-[#111827] dark:text-white mb-4 transition-colors duration-300">Impulsamos tu negocio con Inteligencia Artificial</h2>
                            <h3 class="text-lg font-semibold text-brand-cyan dark:text-brand-cyan mb-3 transition-colors duration-300">Automatización y análisis predictivo en tiempo real</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed transition-colors duration-300">
                                Integramos soluciones de IA generativa y analítica avanzada para optimizar tus procesos, reducir costos operativos y predecir tendencias del mercado con precisión milimétrica. Deja que los datos trabajen por ti.
                            </p>
                        </div>

                        <div class="space-y-6">
                            <div class="group cursor-pointer bg-[#f8fafc] dark:bg-gray-800/50 p-5 rounded-2xl border border-transparent hover:border-gray-200 dark:hover:border-gray-700 transition-colors duration-300 hover:shadow-sm">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-[#111827] dark:text-white flex items-center gap-2 group-hover:text-brand-cyan dark:group-hover:text-brand-cyan transition-colors">
                                        Automatización de Procesos (RPA & IA) <i data-lucide="chevron-right" class="w-4 h-4 opacity-0 -ml-2 group-hover:opacity-100 group-hover:ml-0 transition-all text-brand-cyan dark:text-brand-cyan"></i>
                                    </h4>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Eliminamos tareas manuales repetitivas mediante agentes inteligentes, permitiendo a tu equipo enfocarse en el trabajo estratégico y creativo.</p>
                            </div>
                            
                            <div class="group cursor-pointer bg-[#f8fafc] dark:bg-gray-800/50 p-5 rounded-2xl border border-transparent hover:border-gray-200 dark:hover:border-gray-700 transition-colors duration-300 hover:shadow-sm">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-[#111827] dark:text-white flex items-center gap-2 group-hover:text-brand-lime dark:group-hover:text-brand-lime transition-colors">
                                        Análisis Predictivo de Datos <i data-lucide="chevron-right" class="w-4 h-4 opacity-0 -ml-2 group-hover:opacity-100 group-hover:ml-0 transition-all text-brand-lime dark:text-brand-lime"></i>
                                    </h4>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Nuestros algoritmos procesan grandes volúmenes de información para identificar patrones ocultos y anticipar el comportamiento de tus clientes.</p>
                            </div>

                            <div class="group cursor-pointer bg-[#f8fafc] dark:bg-gray-800/50 p-5 rounded-2xl border border-transparent hover:border-gray-200 dark:hover:border-gray-700 transition-colors duration-300 hover:shadow-sm">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-[#111827] dark:text-white flex items-center gap-2 group-hover:text-brand-cyan dark:group-hover:text-brand-cyan transition-colors">
                                        Asistentes Virtuales Cognitivos <i data-lucide="chevron-right" class="w-4 h-4 opacity-0 -ml-2 group-hover:opacity-100 group-hover:ml-0 transition-all text-brand-cyan dark:text-brand-cyan"></i>
                                    </h4>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Implementamos chatbots con procesamiento de lenguaje natural (NLP) que mejoran la atención al cliente operando 24/7 con respuestas precisas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SPECIALTIES SECTION -->
        <section id="especialidades" class="py-24 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#111827] dark:text-white mb-4 transition-colors duration-300">Nuestras especialidades</h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium max-w-2xl mx-auto transition-colors duration-300">Creamos soluciones a medida para cada etapa de tu crecimiento digital.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Specialty 1 -->
                    <div class="bg-[#f8fafc] dark:bg-gray-800/50 rounded-[2.5rem] p-8 lg:p-10 border border-gray-100 dark:border-gray-700 hover:shadow-[0_8px_30px_rgb(0,229,255,0.06)] dark:hover:shadow-[0_8px_30px_rgb(0,229,255,0.15)] transition-all duration-300 hover:-translate-y-1 group">
                        <div class="w-14 h-14 bg-brand-cyan/20 dark:bg-brand-cyan/20 rounded-2xl flex items-center justify-center text-brand-cyan dark:text-brand-cyan mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="smartphone" class="w-7 h-7"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#111827] dark:text-white mb-3 leading-tight group-hover:text-brand-cyan transition-colors">Desarrollo Web y Apps</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Plataformas web y aplicaciones móviles que ofrecen experiencias de usuario memorables y un rendimiento excepcional.</p>
                    </div>

                    <!-- Specialty 2 -->
                    <div class="bg-[#f8fafc] dark:bg-gray-800/50 rounded-[2.5rem] p-8 lg:p-10 border border-gray-100 dark:border-gray-700 hover:shadow-[0_8px_30px_rgb(178,255,5,0.06)] dark:hover:shadow-[0_8px_30px_rgb(178,255,5,0.15)] transition-all duration-300 hover:-translate-y-1 group">
                        <div class="w-14 h-14 bg-brand-lime/20 dark:bg-brand-lime/20 rounded-2xl flex items-center justify-center text-brand-lime dark:text-brand-lime mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="bot" class="w-7 h-7"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#111827] dark:text-white mb-3 leading-tight group-hover:text-brand-lime transition-colors">Automatización (RPA)</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Optimizamos tus flujos de trabajo, eliminamos tareas repetitivas y liberamos el potencial de tu equipo.</p>
                    </div>

                    <!-- Specialty 3 -->
                    <div class="bg-[#f8fafc] dark:bg-gray-800/50 rounded-[2.5rem] p-8 lg:p-10 border border-gray-100 dark:border-gray-700 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:hover:shadow-[0_8px_30px_rgb(255,255,255,0.05)] transition-all duration-300 hover:-translate-y-1 group">
                        <div class="w-14 h-14 bg-gray-200 dark:bg-gray-700 rounded-2xl flex items-center justify-center text-gray-700 dark:text-gray-300 mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="code" class="w-7 h-7"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#111827] dark:text-white mb-3 leading-tight">Software a Medida</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Sistemas y herramientas internas diseñadas específicamente para resolver los desafíos únicos de tu negocio.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CASE STUDIES SECTION -->
        <section id="portafolio" class="py-24 bg-[#f4f7fb] dark:bg-gray-900/50 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-bold text-[#111827] dark:text-white mb-2 transition-colors duration-300">Casos de Éxito Destacados</h2>
                        <p class="text-gray-500 dark:text-gray-400 font-medium transition-colors duration-300">Transformando ideas en soluciones digitales líderes en el mercado.</p>
                    </div>
                    <button class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-semibold transition-all duration-200 text-sm border bg-white dark:bg-gray-800 text-gray-900 dark:text-white border-gray-200 dark:border-gray-700 hover:border-brand-cyan dark:hover:border-brand-cyan hover:text-brand-cyan dark:hover:text-brand-cyan hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm">
                        Ver todo el portafolio
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <?php foreach ($proyectos as $proyecto): ?>
                        <?php include 'components/project-card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- CLIENTS SECTION -->
        <section id="clientes" class="py-24 bg-white dark:bg-gray-900 relative overflow-hidden border-y border-gray-100 dark:border-gray-800 transition-colors duration-300">

            <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#111827] dark:text-white mb-4 transition-colors duration-300">Empresas líderes confían en nosotros</h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Desde startups disruptivas hasta corporativos líderes en todo el país.</p>
                </div>
                
                <div class="relative flex overflow-x-hidden mask-fade mb-20 group">
                    <div class="py-4 animate-marquee whitespace-nowrap flex items-center gap-16 md:gap-24 pr-16 md:pr-24 opacity-40 dark:opacity-50 grayscale group-hover:grayscale-0 transition-all duration-500">
                        <?php foreach ($clientes as $cliente): ?>
                            <span class="text-2xl md:text-3xl font-black text-[#111827] dark:text-white tracking-tighter flex items-center gap-2 hover:text-<?php echo $cliente['color']; ?> transition-colors">
                                <i data-lucide="<?php echo $cliente['icono']; ?>" class="w-8 h-8 text-<?php echo $cliente['color']; ?>"></i> 
                                <?php echo $cliente['nombre']; ?>
                            </span>
                        <?php endforeach; ?>
                        <!-- Duplicar para el loop infinito -->
                        <?php foreach ($clientes as $cliente): ?>
                            <span class="text-2xl md:text-3xl font-black text-[#111827] dark:text-white tracking-tighter flex items-center gap-2">
                                <i data-lucide="<?php echo $cliente['icono']; ?>" class="w-8 h-8 opacity-50"></i> 
                                <?php echo $cliente['nombre']; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <div class="absolute top-0 py-4 animate-marquee2 whitespace-nowrap flex items-center gap-16 md:gap-24 pr-16 md:pr-24 opacity-40 dark:opacity-50 grayscale group-hover:grayscale-0 transition-all duration-500">
                        <?php foreach ($clientes as $cliente): ?>
                            <span class="text-2xl md:text-3xl font-black text-[#111827] dark:text-white tracking-tighter flex items-center gap-2">
                                <i data-lucide="<?php echo $cliente['icono']; ?>" class="w-8 h-8"></i> 
                                <?php echo $cliente['nombre']; ?>
                            </span>
                        <?php endforeach; ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <span class="text-2xl md:text-3xl font-black text-[#111827] dark:text-white tracking-tighter flex items-center gap-2">
                                <i data-lucide="<?php echo $cliente['icono']; ?>" class="w-8 h-8"></i> 
                                <?php echo $cliente['nombre']; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Bento Box Stats & Map -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
                    
                    <!-- Tarjeta Mapa (Ocupa 2 columnas) -->
                    <div class="lg:col-span-2 bg-[#f8fafc] dark:bg-gray-800/50 rounded-[2.5rem] p-8 md:p-10 border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden group transition-colors duration-300">
                        <div class="relative z-10 text-center md:text-left">
                            <div class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-4 py-2 rounded-xl shadow-sm mb-6">
                                <i data-lucide="map-pin" class="w-4 h-4 text-brand-cyan"></i>
                                <span class="text-gray-700 dark:text-gray-300 font-semibold text-xs uppercase tracking-wider">Sede Central</span>
                            </div>
                            <h3 class="text-2xl font-bold text-[#111827] dark:text-white mb-3 leading-tight">Desarrollo de alto nivel</h3>
                            <p class="text-gray-500 dark:text-gray-400 font-medium max-w-xs">Orgullosamente impulsando tecnología e innovación desde <span class="font-bold text-[#111827] dark:text-white">Sinaloa 🍅</span> para cada rincón de la república.</p>
                        </div>
                        
                        <!-- Contenedor del Mapa (Google Maps Embed) -->
                        <div class="w-full md:w-80 h-52 md:h-64 rounded-[2rem] overflow-hidden border-4 border-white dark:border-gray-800 shadow-xl relative group-hover:scale-[1.02] transition-transform duration-500">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15050.472782766838!2d-99.1738734!3d19.4326077!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1ff35f5bd1563%3A0x6c99f9c2512760!2sCiudad%20de%20M%C3%A9xico!5e0!3m2!1ses-419!2smx!4v1712415000000!5m2!1ses-419!2smx" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                class="dark:invert-[0.9] dark:hue-rotate-180 opacity-90 dark:opacity-80"
                            ></iframe>
                            <!-- Overlay sutil para mejorar integración -->
                            <div class="absolute inset-0 pointer-events-none border border-black/5 dark:border-white/10 rounded-[2rem]"></div>
                        </div>
                    </div>

                    <!-- Tarjetas de Métricas -->
                    <div class="flex flex-col gap-6">
                        <!-- Stat 1 -->
                        <div class="bg-[#f8fafc] dark:bg-gray-800/50 rounded-[2.5rem] p-8 border border-gray-100 dark:border-gray-700 flex flex-col justify-center items-center text-center flex-1 transition-colors duration-300 group hover:border-brand-cyan/50">
                            <div class="text-4xl font-black text-[#111827] dark:text-white mb-2 group-hover:text-brand-cyan transition-colors">98%</div>
                            <div class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Retención de Clientes</div>
                        </div>
                        <!-- Stat 2 -->
                        <div class="bg-[#f8fafc] dark:bg-gray-800/50 rounded-[2.5rem] p-8 border border-gray-100 dark:border-gray-700 flex flex-col justify-center items-center text-center flex-1 transition-colors duration-300 group hover:border-brand-lime/50">
                            <div class="text-4xl font-black text-[#111827] dark:text-white mb-2 group-hover:text-brand-lime transition-colors">3</div>
                            <div class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Estados Atendidos</div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>

        <!-- AWARDS SECTION -->
        <section class="py-24 bg-[#f8fafc] dark:bg-gray-900/50 transition-colors duration-300">
            <div class="max-w-6xl mx-auto px-6 lg:px-12">
                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] overflow-hidden transition-colors duration-300">
                    <div class="p-10 lg:p-16 flex flex-col lg:flex-row gap-12 items-center">
                        <div class="lg:w-1/2 space-y-6">
                            <h2 class="text-2xl font-bold text-[#111827] dark:text-white">Premios y Reconocimientos</h2>
                            <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm font-medium">Constantemente reconocidos por plataformas de la industria por la excelencia en ingeniería, entrega liderada por la innovación y la satisfacción del cliente a largo plazo.</p>
                            <button class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-semibold transition-all duration-200 text-sm border bg-brand-cyan/20 dark:bg-brand-cyan/10 text-brand-cyan dark:text-brand-cyan border-transparent hover:bg-brand-cyan/30 dark:hover:bg-brand-cyan/20">Ver Galería de Premios</button>
                        </div>

                        <div class="lg:w-1/4 flex justify-center">
                            <div class="bg-[#f8fafc] dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm text-center relative w-48 transition-colors duration-300 hover:border-brand-lime/50">
                                <div class="text-[10px] text-gray-400 uppercase tracking-widest mb-3 font-semibold">Reseñas en Clutch</div>
                                <div class="flex items-center justify-center gap-2 mb-3 text-4xl font-black text-[#111827] dark:text-white">
                                    <span class="text-brand-lime text-3xl">C</span>4.8
                                </div>
                                <div class="flex gap-1 justify-center">
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-1/4 grid grid-cols-3 gap-3">
                            <div class="aspect-square flex flex-col items-center justify-center text-center p-2 rounded-xl bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 shadow-sm hover:border-brand-cyan hover:bg-brand-cyan/10 dark:hover:bg-brand-cyan/10 transition-colors duration-300 group">
                                <i data-lucide="award" class="w-5 h-5 text-[#111827] dark:text-white mb-1.5 group-hover:text-brand-cyan" stroke-width="1.5"></i><span class="text-[8px] font-bold text-gray-500 dark:text-gray-300 uppercase leading-tight">CMMI</span>
                            </div>
                            <div class="aspect-square flex flex-col items-center justify-center text-center p-2 rounded-xl bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 shadow-sm hover:border-brand-cyan hover:bg-brand-cyan/10 dark:hover:bg-brand-cyan/10 transition-colors duration-300 group">
                                <i data-lucide="shield" class="w-5 h-5 text-[#111827] dark:text-white mb-1.5 group-hover:text-brand-cyan" stroke-width="1.5"></i><span class="text-[8px] font-bold text-gray-500 dark:text-gray-300 uppercase leading-tight">SOC 2</span>
                            </div>
                            <div class="aspect-square flex flex-col items-center justify-center text-center p-2 rounded-xl bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 shadow-sm hover:border-brand-cyan hover:bg-brand-cyan/10 dark:hover:bg-brand-cyan/10 transition-colors duration-300 group">
                                <i data-lucide="award" class="w-5 h-5 text-[#111827] dark:text-white mb-1.5 group-hover:text-brand-cyan" stroke-width="1.5"></i><span class="text-[8px] font-bold text-gray-500 dark:text-gray-300 uppercase leading-tight">ISO 9001</span>
                            </div>
                            <div class="aspect-square flex flex-col items-center justify-center text-center p-2 rounded-xl bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 shadow-sm hover:border-brand-cyan hover:bg-brand-cyan/10 dark:hover:bg-brand-cyan/10 transition-colors duration-300 group">
                                <i data-lucide="shield" class="w-5 h-5 text-[#111827] dark:text-white mb-1.5 group-hover:text-brand-cyan" stroke-width="1.5"></i><span class="text-[8px] font-bold text-gray-500 dark:text-gray-300 uppercase leading-tight">ISO 27001</span>
                            </div>
                            <div class="aspect-square flex flex-col items-center justify-center text-center p-2 rounded-xl bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 shadow-sm hover:border-brand-cyan hover:bg-brand-cyan/10 dark:hover:bg-brand-cyan/10 transition-colors duration-300 group">
                                <i data-lucide="award" class="w-5 h-5 text-[#111827] dark:text-white mb-1.5 group-hover:text-brand-cyan" stroke-width="1.5"></i><span class="text-[8px] font-bold text-gray-500 dark:text-gray-300 uppercase leading-tight">G.P.T.W</span>
                            </div>
                            <div class="aspect-square flex flex-col items-center justify-center text-center p-2 rounded-xl bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 shadow-sm hover:border-brand-cyan hover:bg-brand-cyan/10 dark:hover:bg-brand-cyan/10 transition-colors duration-300 group">
                                <i data-lucide="globe" class="w-5 h-5 text-[#111827] dark:text-white mb-1.5 group-hover:text-brand-cyan" stroke-width="1.5"></i><span class="text-[8px] font-bold text-gray-500 dark:text-gray-300 uppercase leading-tight">Global</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTACT SECTION -->
        <section id="contacto" class="py-24 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 transition-colors duration-300 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
                <div class="bg-[#f8fafc]/80 dark:bg-gray-800/60 backdrop-blur-sm rounded-[2.5rem] p-6 md:p-12 lg:p-16 border border-gray-100 dark:border-gray-700/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] transition-colors duration-300">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-24 items-center">
                        
                        <!-- Columna Izquierda: Información -->
                        <div>
                            <div class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-4 py-2 rounded-xl shadow-sm mb-6">
                                <i data-lucide="mail" class="w-4 h-4 text-brand-cyan"></i>
                                <span class="text-gray-700 dark:text-gray-300 font-semibold text-xs uppercase tracking-wider">Contáctanos</span>
                            </div>
                            <h2 class="text-3xl lg:text-4xl font-bold text-[#111827] dark:text-white mb-6 leading-tight transition-colors duration-300">
                                ¿Tienes un proyecto en mente? Hablemos.
                            </h2>
                            <p class="text-gray-500 dark:text-gray-400 text-base leading-relaxed mb-10 transition-colors duration-300">
                                Cuéntanos sobre tu idea, tus retos o las metas de tu empresa. Nuestro equipo de expertos revisará los detalles y nos pondremos en contacto contigo para explorar cómo podemos ayudarte.
                            </p>
                            
                            <!-- Canales de contacto directo -->
                            <div class="space-y-5">
                                <div class="flex items-center gap-4 text-[#111827] dark:text-gray-300">
                                    <div class="w-12 h-12 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center flex-shrink-0 shadow-sm transition-colors duration-300">
                                        <i data-lucide="phone-call" class="w-5 h-5 text-brand-cyan"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider">Llámanos</div>
                                        <div class="font-bold mt-0.5">667 264 4610</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 text-[#111827] dark:text-gray-300">
                                    <div class="w-12 h-12 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center flex-shrink-0 shadow-sm transition-colors duration-300">
                                        <i data-lucide="mail-open" class="w-5 h-5 text-brand-lime"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider">Escríbenos</div>
                                        <div class="font-bold mt-0.5">gerardogq01@gmail.com</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha: Formulario de Contacto -->
                        <div class="bg-white dark:bg-gray-800 p-6 md:p-10 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-lg shadow-gray-200/20 dark:shadow-none transition-colors duration-300">
                            <form id="contact-form" class="space-y-5">
                                <div>
                                    <label for="nombre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nombre completo</label>
                                    <input type="text" id="nombre" name="nombre" placeholder="Ej. Juan Pérez" class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors placeholder-gray-400 dark:placeholder-gray-500" required />
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="celular" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Celular</label>
                                        <input type="tel" id="celular" name="celular" maxlength="10" minlength="10" pattern="[0-9]{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric" placeholder="Ej. 6672644610" class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors placeholder-gray-400 dark:placeholder-gray-500" required />
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email profesional</label>
                                        <input type="email" id="email" name="email" placeholder="juan@empresa.com" class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors placeholder-gray-400 dark:placeholder-gray-500" required />
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Descripción del proyecto</label>
                                    <textarea id="descripcion" name="descripcion" rows="4" placeholder="Cuéntanos brevemente sobre los objetivos, alcance o desafíos de tu proyecto..." class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors resize-none placeholder-gray-400 dark:placeholder-gray-500" required></textarea>
                                </div>
                                
                                <button type="submit" id="btn-submit-contact" class="w-full inline-flex items-center justify-center px-6 py-4 rounded-xl font-bold transition-all duration-200 text-sm border bg-brand-cyan text-gray-900 border-brand-cyan hover:bg-brand-lime hover:border-brand-lime hover:shadow-[0_0_15px_rgba(178,255,5,0.4)] mt-2">
                                    <span id="btn-text-contact">Enviar mensaje</span> <i id="btn-icon-contact" data-lucide="send" class="w-4 h-4 ml-2"></i>
                                </button>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400 py-12 text-sm text-center border-t border-gray-200 dark:border-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-4 flex justify-center items-center gap-2">
                <svg width="24" height="24" viewBox="0 0 100 100" class="mr-0.5">
                    <path d="M 35 25 L 15 50 L 35 75" fill="none" stroke="currentColor" class="text-gray-900 dark:text-white" stroke-width="12" stroke-linecap="square" stroke-linejoin="miter"/>
                    <path d="M 58 15 L 42 85" fill="none" stroke="#00E5FF" stroke-width="12" stroke-linecap="square" />
                    <path d="M 65 25 L 85 50 L 65 75" fill="none" stroke="#B2FF05" stroke-width="12" stroke-linecap="square" stroke-linejoin="miter" />
                </svg>
                <span class="text-xl font-bold text-gray-900 dark:text-white tracking-tighter transition-colors duration-300 flex items-center">
                    <span class="font-medium mr-0.5">Code</span><span class="text-brand-lime">Digital</span>
                </span>
            </div>
            <p class="font-medium">© <span id="year"></span> Code Digital. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- FLOATING CHAT -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end pointer-events-none">
        <!-- Ventana de Chat (Oculta por defecto) -->
        <div id="chat-window" class="hidden opacity-0 translate-y-4 scale-95 invisible pointer-events-none bg-white dark:bg-gray-800 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.12)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.5)] border border-gray-100 dark:border-gray-700 w-80 mb-4 overflow-hidden transform origin-bottom-right transition-all duration-500 ease-out pointer-events-auto">
            <div class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 p-4 flex justify-between items-center transition-colors duration-300">
                <div class="font-semibold flex items-center gap-2 text-[#111827] dark:text-white text-sm">
                    <div class="w-2 h-2 bg-brand-lime rounded-full shadow-[0_0_5px_#B2FF05]"></div>
                    Soporte en línea
                </div>
                <button id="chat-close-btn" class="text-gray-400 hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="p-6 bg-[#f8fafc] dark:bg-gray-900/80 h-48 flex items-start gap-3 transition-colors duration-300">
                <div class="w-8 h-8 bg-brand-cyan text-gray-900 rounded-full flex items-center justify-center flex-shrink-0 mt-1 transition-colors duration-300">
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-600 dark:text-gray-300 border border-gray-100 dark:border-gray-700 leading-relaxed transition-colors duration-300">
                    ¡Hola! 👋 <br/><br/> ¿En qué puedo ayudarte hoy?
                </div>
            </div>
            
            <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 flex gap-2 transition-colors duration-300">
                <input id="chat-input" type="text" placeholder="Escribe tu mensaje..." class="flex-1 bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2 text-sm font-medium focus:outline-none focus:border-brand-cyan focus:bg-white dark:focus:bg-gray-700 transition-colors text-gray-900 dark:text-white" />
                <button id="chat-send-btn" class="bg-brand-cyan text-gray-900 p-2.5 rounded-xl hover:bg-brand-lime hover:shadow-[0_0_10px_rgba(178,255,5,0.4)] transition-colors shadow-sm">
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        
        <!-- Botón Flotante -->
        <button id="chat-toggle-btn" class="bg-brand-cyan hover:bg-brand-lime text-gray-900 rounded-2xl p-4 shadow-lg shadow-brand-cyan/20 transition-all duration-300 hover:scale-105 flex items-center justify-center pointer-events-auto">
            <i id="icon-message" data-lucide="message-square" class="w-6 h-6 block"></i>
            <i id="icon-close" data-lucide="x" class="w-6 h-6 hidden"></i>
        </button>
    </div>

    <!-- MODAL SOLICITAR DEMO -->
    <div id="demo-modal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-500">
        <!-- Backdrop -->
        <div id="modal-backdrop" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
        
        <!-- Modal Card -->
        <div class="relative bg-white dark:bg-gray-800 w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden transform scale-95 transition-all duration-500">
            <!-- Modal Header -->
            <div class="p-8 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                <div>
                    <h3 class="text-2xl font-bold text-[#111827] dark:text-white tracking-tight">Solicitar Demo</h3>
                    <p id="modal-project-name" class="text-brand-cyan font-semibold text-sm mt-1 uppercase tracking-wider">Nombre del Proyecto</p>
                </div>
                <button id="close-modal" class="p-2 text-gray-400 hover:text-brand-cyan hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-8">
                <form id="demo-form" class="space-y-5">
                    <div>
                        <label for="demo-telefono" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Teléfono de contacto</label>
                        <input type="tel" id="demo-telefono" name="demo-telefono" maxlength="10" minlength="10" pattern="[0-9]{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric" required placeholder="Ej. 6672644610" class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors" />
                    </div>
                    
                    <div>
                        <label for="demo-email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Correo electrónico</label>
                        <input type="email" id="demo-email" required placeholder="tu@empresa.com" class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors" />
                    </div>
                    
                    <div>
                        <label for="demo-motivo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">¿Por qué deseas acceso?</label>
                        <textarea id="demo-motivo" rows="3" required placeholder="Cuéntanos brevemente tus necesidades..." class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors resize-none"></textarea>
                    </div>
                    
                    <button type="submit" class="w-full py-4 bg-brand-cyan text-gray-900 font-bold rounded-xl text-md transition-all hover:bg-brand-lime hover:shadow-[0_0_20px_rgba(178,255,5,0.4)] mt-2 flex items-center justify-center gap-2">
                        Enviar Solicitud <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </form>
                
                <!-- Success Message (Hidden) -->
                <div id="demo-success" class="hidden text-center py-8">
                    <div class="w-16 h-16 bg-brand-lime/20 text-brand-lime rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="check-circle" class="w-8 h-8"></i>
                    </div>
                    <h4 class="text-xl font-bold text-[#111827] dark:text-white mb-2">¡Solicitud Enviada!</h4>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Nos pondremos en contacto contigo a la brevedad para agendar tu demo personalizada.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU OVERLAY -->
    <div id="mobile-menu" class="hidden fixed inset-0 z-[100] invisible pointer-events-none overflow-hidden transition-all duration-300">
        <!-- Backdrop -->
        <div id="mobile-menu-backdrop" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-500"></div>
        
        <!-- Menu Content -->
        <div id="mobile-menu-content" class="absolute top-0 right-0 bottom-0 w-4/5 max-w-sm bg-white dark:bg-gray-900 shadow-2xl translate-x-full transition-transform duration-500 ease-out border-l border-gray-100 dark:border-gray-800 flex flex-col">
            <div class="flex items-center justify-between p-6 border-b border-gray-50 dark:border-gray-800/50">
                <div class="flex items-center gap-1">
                    <span class="text-xl font-bold tracking-tighter text-gray-900 dark:text-white flex items-center">
                        <span class="font-medium mr-0.5">Code</span><span class="text-brand-lime">Digital</span>
                    </span>
                </div>
                <button id="mobile-menu-close" class="p-2 text-gray-500 dark:text-gray-400 hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors focus:outline-none">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <nav class="flex-1 px-6 py-10 space-y-8 overflow-y-auto">
                <a href="#especialidades" class="mobile-nav-link block text-2xl font-bold text-gray-900 dark:text-white hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">Servicios</a>
                <a href="#portafolio" class="mobile-nav-link block text-2xl font-bold text-gray-900 dark:text-white hover:text-brand-lime dark:hover:text-brand-lime transition-colors">Portafolio</a>
                <a href="#clientes" class="mobile-nav-link block text-2xl font-bold text-gray-900 dark:text-white hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">Clientes</a>
                <a href="#contacto" class="mobile-nav-link block text-2xl font-bold text-gray-900 dark:text-white hover:text-brand-lime dark:hover:text-brand-lime transition-colors">Contacto</a>
                
                <div class="pt-10 border-t border-gray-50 dark:border-gray-800">
                    <a href="https://wa.me/526672644610?text=Hola,%20me%20gustaria%20agendar%20una%20llamada" target="_blank" class="w-full inline-flex items-center justify-center px-6 py-4 rounded-xl font-bold transition-all duration-200 text-sm border bg-brand-cyan text-gray-900 border-brand-cyan hover:bg-brand-lime hover:border-brand-lime">
                        <i data-lucide="phone" class="w-4 h-4 mr-2"></i> Agendar Llamada
                    </a>
                </div>
            </nav>
            
            <div class="p-6 text-center text-xs text-gray-400 dark:text-gray-500">
                &copy; <span id="year-mobile"></span> Code Digital. Sinaloa 🍅
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const contactForm = document.getElementById('contact-form');
        const btnSubmit = document.getElementById('btn-submit-contact');
        const btnText = document.getElementById('btn-text-contact');
        const btnIcon = document.getElementById('btn-icon-contact');

        if(contactForm) {
            contactForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                // UI State: Loading
                const originalText = btnText.innerText;
                const originalIcon = btnIcon.dataset.lucide;
                
                btnText.innerText = 'Enviando...';
                btnIcon.setAttribute('data-lucide', 'loader-2');
                btnIcon.classList.add('animate-spin');
                if (typeof lucide !== 'undefined') lucide.createIcons();
                btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
                btnSubmit.disabled = true;

                const formData = new FormData(contactForm);

                try {
                    const response = await fetch('api/contact_handler.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();

                    if (result.success) {
                        // Success State
                        btnText.innerText = '¡Enviado!';
                        btnIcon.setAttribute('data-lucide', 'check-circle');
                        btnIcon.classList.remove('animate-spin');
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                        btnSubmit.classList.replace('bg-brand-cyan', 'bg-brand-lime');
                        contactForm.reset();
                        
                        setTimeout(() => {
                            btnText.innerText = originalText;
                            btnIcon.setAttribute('data-lucide', originalIcon);
                            btnSubmit.classList.replace('bg-brand-lime', 'bg-brand-cyan');
                            if (typeof lucide !== 'undefined') lucide.createIcons();
                            btnSubmit.classList.remove('opacity-75', 'cursor-not-allowed');
                            btnSubmit.disabled = false;
                        }, 5000);
                    } else {
                        alert('Error: ' + result.message);
                        btnSubmit.disabled = false;
                        btnText.innerText = originalText;
                        btnIcon.setAttribute('data-lucide', originalIcon);
                        btnIcon.classList.remove('animate-spin');
                    }
                } catch (error) {
                    alert('Hubo un error de red al intentar conectar. Intente nuevamente.');
                    btnSubmit.disabled = false;
                    btnText.innerText = originalText;
                    btnIcon.setAttribute('data-lucide', originalIcon);
                    btnIcon.classList.remove('animate-spin');
                }
            });
        }
    });
    </script>
</body>
</html>