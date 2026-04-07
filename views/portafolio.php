<?php 
$base_asset_path = '../';
include '../models/proyectos.php'; 
include '../models/clientes.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio - Code Digital</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Configuración y lógica principal -->
    <script src="../assets/js/main.js?v=<?php echo filemtime('../assets/js/main.js'); ?>"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo filemtime('../assets/css/style.css'); ?>">
</head>
<body class="font-sans min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300 selection:bg-brand-lime/30 dark:selection:bg-brand-cyan/30 selection:text-gray-900 dark:selection:text-white">

    <!-- NAVBAR -->
    <nav class="absolute top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-5 lg:px-12 max-w-screen-2xl mx-auto w-full bg-white/70 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100/50 dark:border-gray-800/80 transition-colors duration-300">
        
        <!-- LOGO CODE DIGITAL -->
        <a href="../index.php" class="flex items-center gap-1 group cursor-pointer">
            <svg width="28" height="28" viewBox="0 0 100 100" class="mr-1 transform group-hover:scale-105 transition-transform">
                <path d="M 35 25 L 15 50 L 35 75" fill="none" stroke="currentColor" class="text-gray-900 dark:text-white" stroke-width="12" stroke-linecap="square" stroke-linejoin="miter"/>
                <path d="M 58 15 L 42 85" fill="none" stroke="#00E5FF" stroke-width="12" stroke-linecap="square" />
                <path d="M 65 25 L 85 50 L 65 75" fill="none" stroke="#B2FF05" stroke-width="12" stroke-linecap="square" stroke-linejoin="miter" />
            </svg>
            <span class="text-xl font-bold tracking-tighter text-gray-900 dark:text-white flex items-center">
                <span class="font-medium mr-0.5">Code</span><span class="text-brand-lime">Digital</span>
            </span>
        </a>
        
        <div class="hidden lg:flex items-center gap-8 text-sm font-semibold text-gray-500 dark:text-gray-400">
            <a href="../index.php#especialidades" class="hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">Servicios</a>
            <a href="#" class="text-brand-lime">Portafolio</a>
            <a href="../index.php#clientes" class="hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">Clientes</a>
            <a href="#contacto" class="hover:text-brand-lime dark:hover:text-brand-lime transition-colors">Contacto</a>
        </div>

        <div class="flex items-center gap-4">
            <!-- Botón Dark Mode -->
            <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-brand-cyan dark:hover:text-brand-cyan focus:outline-none rounded-lg text-sm p-2 transition-colors duration-300">
                <i id="theme-toggle-dark-icon" data-lucide="moon" class="hidden w-5 h-5"></i>
                <i id="theme-toggle-light-icon" data-lucide="sun" class="hidden w-5 h-5"></i>
            </button>

            <a href="https://wa.me/526672644610?text=Hola,%20me%20gustaria%20agendar%20una%20llamada" target="_blank" class="hidden md:inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-bold transition-all duration-200 text-sm border bg-brand-cyan text-gray-900 border-brand-cyan hover:bg-brand-lime hover:border-brand-lime shadow-lg shadow-brand-cyan/20">
                <i data-lucide="phone" class="w-4 h-4 mr-2"></i> Agendar Llamada
            </a>
            <button id="mobile-menu-btn" type="button" class="lg:hidden text-gray-900 dark:text-white transition-colors duration-300 p-2 focus:outline-none">
                <i data-lucide="menu" class="w-6 h-6 pointer-events-none"></i>
            </button>
        </div>
    </nav>

    <main class="pt-32 pb-24">
        
        <!-- HEADER PORTAFOLIO -->
        <section class="max-w-screen-2xl mx-auto px-6 lg:px-12 mb-20 text-center">
            <div class="inline-flex items-center gap-2 bg-brand-cyan/10 border border-brand-cyan/20 px-4 py-2 rounded-xl shadow-sm mb-6">
                <i data-lucide="layout" class="w-4 h-4 text-brand-cyan"></i>
                <span class="text-brand-cyan font-bold text-xs uppercase tracking-widest">Casos de Éxito</span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white mb-6 tracking-tight leading-none">
                Nuestro <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-cyan to-brand-lime">Portafolio</span> Completo
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-lg md:text-xl font-medium max-w-2xl mx-auto">
                Explora las soluciones disruptivas que hemos construido para líderes en diversas industrias.
            </p>
        </section>

        <!-- GRID DE PROYECTOS (3 COLUMNAS) -->
        <section class="max-w-screen-2xl mx-auto px-6 lg:px-12 mb-32">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                <?php foreach ($proyectos as $proyecto): ?>
                    <?php include '../components/project-card.php'; ?>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- CONTACT SECTION (REUSED FROM INDEX) -->
        <section id="contacto" class="py-24 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 transition-colors duration-300 relative overflow-hidden">
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
                                    <span id="btn-text-contact">Enviar mensaje</span> 
                                    <span id="btn-icon-container" class="ml-2 flex items-center justify-center">
                                        <i data-lucide="send" class="w-4 h-4"></i>
                                    </span>
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

    <!-- MODAL SOLICITAR DEMO (COPIED FROM INDEX) -->
    <div id="demo-modal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-500">
        <div id="modal-backdrop" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
        <div class="relative bg-white dark:bg-gray-800 w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden transform scale-95 transition-all duration-500">
            <div class="p-8 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
                <div>
                    <h3 class="text-2xl font-bold text-[#111827] dark:text-white tracking-tight">Solicitar Demo</h3>
                    <p id="modal-project-name" class="text-brand-cyan font-semibold text-sm mt-1 uppercase tracking-wider">Nombre del Proyecto</p>
                </div>
                <button id="close-modal" class="p-2 text-gray-400 hover:text-brand-cyan hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <div class="p-8">
                <form id="demo-form" class="space-y-5">
                    <div>
                        <label for="demo-nombre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nombre completo</label>
                        <input type="text" id="demo-nombre" name="nombre" required placeholder="Ej. Juan Pérez" class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors" />
                    </div>
                    <div>
                        <label for="demo-telefono" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Teléfono de contacto</label>
                        <input type="tel" id="demo-telefono" name="celular" maxlength="20" minlength="10" pattern="[0-9]{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" inputmode="numeric" required placeholder="Ej. 6672644610" class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors" />
                    </div>
                    <div>
                        <label for="demo-email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Correo electrónico</label>
                        <input type="email" id="demo-email" name="email" required placeholder="tu@empresa.com" class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors" />
                    </div>
                    <div>
                        <label for="demo-motivo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">¿Por qué deseas acceso?</label>
                        <textarea id="demo-motivo" name="descripcion" rows="3" required placeholder="Cuéntanos brevemente tus necesidades..." class="w-full bg-[#f8fafc] dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition-colors resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full py-4 bg-brand-cyan text-gray-900 font-bold rounded-xl text-md transition-all hover:bg-brand-lime hover:shadow-[0_0_20px_rgba(178,255,5,0.4)] mt-2 flex items-center justify-center gap-2">
                        Enviar Solicitud <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </form>
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
                <a href="../index.php#especialidades" class="mobile-nav-link block text-2xl font-bold text-gray-900 dark:text-white hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">Servicios</a>
                <a href="../index.php#portafolio" class="mobile-nav-link block text-2xl font-bold text-gray-900 dark:text-white hover:text-brand-lime dark:hover:text-brand-lime transition-colors">Portafolio</a>
                <a href="../index.php#clientes" class="mobile-nav-link block text-2xl font-bold text-gray-900 dark:text-white hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">Clientes</a>
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

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Fix for Relative API paths in views/ for main.js and local scripts
        window.apiHandlerPath = '../api/contact_handler.php';
    });
    </script>
</body>
</body>
</html>
