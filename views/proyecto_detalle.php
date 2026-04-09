<?php 
$base_asset_path = '../';
include '../config/db.php';
include '../models/proyectos.php'; 

// Prevenir errores si $clientes no está definido
if(!isset($clientes)) $clientes = [];

$slug = $_GET['slug'] ?? '';
$proyectoActual = null;

// Encontrar el proyecto por ID/Slug
foreach ($proyectos as $p) {
    if ($p['id'] === $slug) {
        $proyectoActual = $p;
        break;
    }
}

if (!$proyectoActual) {
    header('Location: portafolio.php');
    exit;
}

$colorBrand = $proyectoActual['color'] === 'lima' ? 'brand-lime' : 'brand-cyan';
$textColorBrand = $proyectoActual['color'] === 'lima' ? 'text-brand-lime' : 'text-brand-cyan';
$bgBrand = $proyectoActual['color'] === 'lima' ? 'bg-brand-lime' : 'bg-brand-cyan';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($proyectoActual['nombre']); ?> - Code Digital</title>
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
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Script de inicialización de tema (Previene parpadeo) -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        /* Estilos Galería Estilo Prototipo */
        .gallery-swiper {
            border-radius: 1.5rem;
            overflow: hidden !important;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        }
        .swiper-slide {
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        .swiper-slide-active {
            opacity: 1 !important;
        }
        
        /* Paginación integrada en la imagen */
        .swiper-pagination-bullets.swiper-pagination-horizontal {
            bottom: 24px !important;
            z-index: 20;
        }
        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.3) !important;
            opacity: 1;
            width: 8px;
            height: 8px;
            transition: all 0.3s ease;
        }
        .swiper-pagination-bullet-active {
            background: #00E5FF !important;
            width: 24px;
            border-radius: 4px;
        }

        /* Botones laterales (Opcionales, sutiles) */
        .swiper-button-next, .swiper-button-prev {
            color: white !important;
            transform: scale(0.6);
            opacity: 0;
            transition: all 0.3s ease;
        }
        .group:hover .swiper-button-next, .group:hover .swiper-button-prev {
            opacity: 0.5;
        }
    </style>
</head>
<body class="font-sans min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300 selection:bg-brand-lime/30 dark:selection:bg-brand-cyan/30 selection:text-gray-900 dark:selection:text-white">

    <!-- NAVBAR (CONTENIDO CENTRADO, FONDO FULL WIDTH) -->
    <nav class="absolute top-0 left-0 right-0 z-50 w-full bg-white/70 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100/50 dark:border-gray-800/80 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6 py-5 lg:px-12 flex items-center justify-between w-full">
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
                <a href="portafolio.php" class="hover:text-brand-lime dark:hover:text-brand-lime transition-colors">Portafolio</a>
                <a href="../index.php#clientes" class="hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">Clientes</a>
                <a href="../index.php#contacto" class="hover:text-brand-lime dark:hover:text-brand-lime transition-colors">Contacto</a>
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
        </div>
    </nav>

    <main>
        <!-- HERO SECTION INMERSIVO (Imagen de Fondo) -->
        <section class="relative min-h-[60vh] pt-24 flex items-center justify-start overflow-hidden bg-gray-900 border-b border-gray-800 transition-colors duration-300">
            <!-- Capa de Imagen de Fondo -->
            <div class="absolute inset-0 z-0">
                <img src="../<?php echo $proyectoActual['imagen_url']; ?>" alt="" class="w-full h-full object-cover opacity-60">
                <!-- Overlay de Gradiente para legibilidad -->
                <div class="absolute inset-0 bg-gradient-to-tr from-gray-900 via-gray-900/40 to-transparent transition-colors duration-300"></div>
                <!-- Destellos ambientales sutiles -->
                <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-brand-cyan/20 rounded-full blur-[120px] pointer-events-none animate-pulse"></div>
            </div>

            <!-- Contenido del Hero -->
            <div class="max-w-7xl px-6 lg:px-12 relative z-10 text-left space-y-6">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-xl shadow-xl mb-2">
                    <i data-lucide="<?php echo $proyectoActual['icono_estado']; ?>" class="w-4 h-4 text-brand-cyan"></i>
                    <span class="text-white font-bold text-xs uppercase tracking-widest"><?php echo $proyectoActual['subtexto_estado']; ?></span>
                </div>
                
                <div class="space-y-4">
                    <h1 class="text-5xl lg:text-8xl font-black leading-[1] tracking-tighter text-white drop-shadow-2xl">
                        <?php echo htmlspecialchars($proyectoActual['nombre']); ?>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-300 max-w-3xl font-medium leading-relaxed">
                        <?php echo htmlspecialchars($proyectoActual['tagline']); ?>
                    </p>
                </div>

                <div class="flex flex-wrap justify-start gap-3 pt-4">
                    <?php foreach ($proyectoActual['tecnologias'] as $tech): ?>
                        <span class="px-6 py-2.5 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl text-xs font-black uppercase tracking-widest text-brand-cyan shadow-lg">
                             <?php echo htmlspecialchars($tech); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- NARRATIVE & METRICS SECTION -->
        <section class="py-24 bg-white dark:bg-gray-900 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                    
                    <!-- COLUMNA IZQUIERDA: NARRATIVA (8 COLUMNAS) -->
                    <div class="lg:col-span-8 space-y-24">
                        
                        <!-- El Desafío -->
                        <div class="space-y-6">
                            <div class="inline-flex items-center gap-2 bg-red-500/10 border border-red-500/20 px-4 py-2 rounded-xl text-red-500 font-bold text-[10px] uppercase tracking-wider">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> Identificador del desafío
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-lg md:text-xl leading-relaxed font-medium">
                                <?php 
                                if (!empty($proyectoActual['problema'])) {
                                    echo nl2br(htmlspecialchars($proyectoActual['problema']));
                                } else {
                                    echo "El cliente enfrentaba desafíos operativos que limitaban su capacidad de escalar, dependiendo en gran medida de procesos manuales que generaban cuellos de botella.";
                                }
                                ?>
                            </p>
                        </div>

                        <!-- La Solución -->
                        <div class="space-y-8">
                            <div class="inline-flex items-center gap-2 bg-brand-lime/10 border border-brand-lime/20 px-4 py-2 rounded-xl text-brand-lime font-bold text-[10px] uppercase tracking-wider">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Ingeniería que resuelve
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-lg md:text-xl leading-relaxed font-medium">
                                 <?php echo nl2br(htmlspecialchars($proyectoActual['descripcion'])); ?>
                            </p>
                            <?php if (!empty($proyectoActual['funcionalidades'])): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
                                <?php 
                                $funcs = explode("\n", $proyectoActual['funcionalidades']);
                                foreach($funcs as $func): 
                                    $fn = trim($func);
                                    if(empty($fn)) continue;
                                ?>
                                <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/40 rounded-2xl border border-gray-100 dark:border-gray-700/50 transition-all hover:border-brand-lime/30">
                                    <div class="w-8 h-8 bg-brand-lime/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="check" class="w-4 h-4 text-brand-lime"></i>
                                    </div>
                                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300 leading-tight"><?php echo htmlspecialchars($fn); ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA: MÉTRICAS (4 COLUMNAS) - STICKY -->
                    <div class="lg:col-span-4 lg:sticky lg:top-32 space-y-6">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-8 h-1 bg-brand-cyan rounded-full"></div>
                            <h3 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500 text-center">Métricas de impacto</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <?php foreach ($proyectoActual['estadisticas'] as $stat): ?>
                                <?php if(!empty($stat['valor'])): ?>
                                <div class="bg-[#f8fafc] dark:bg-gray-800/60 backdrop-blur-sm rounded-3xl p-8 border border-gray-100 dark:border-gray-700/50 group transition-all duration-300 hover:shadow-xl hover:shadow-brand-cyan/5 hover:-translate-y-1">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="w-10 h-10 bg-brand-cyan/10 rounded-xl flex items-center justify-center text-brand-cyan group-hover:bg-brand-cyan group-hover:text-gray-900 transition-colors">
                                            <i data-lucide="trending-up" class="w-5 h-5"></i>
                                        </div>
                                        <span class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">KPI</span>
                                    </div>
                                    <h3 class="text-3xl font-black text-[#111827] dark:text-white mb-1 tracking-tighter"><?php echo htmlspecialchars($stat['valor']); ?></h3>
                                    <p class="text-gray-500 dark:text-gray-400 font-bold text-[10px] uppercase tracking-[0.1em]"><?php echo htmlspecialchars($stat['etiqueta']); ?></p>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- GALLERY SECTION (ESTILO PROTOTIPO SOLICITADO) -->
        <?php if (!empty($proyectoActual['galeria'])): ?>
        <section class="py-24 bg-white dark:bg-gray-900 border-y border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 mb-12">
                <div class="flex items-center gap-4">
                    <div class="w-1.5 h-10 bg-brand-cyan rounded-full"></div>
                    <h2 class="text-3xl md:text-4xl font-bold text-[#111827] dark:text-white">Galería de Imágenes</h2>
                </div>
            </div>
            <div class="max-w-5xl mx-auto px-6 relative group">
                <!-- Swiper -->
                <div class="swiper gallery-swiper shadow-2xl rounded-3xl border border-gray-100 dark:border-gray-800">
                    <div class="swiper-wrapper">
                        <?php 
                        $totalImagenes = count($proyectoActual['galeria']);
                        foreach($proyectoActual['galeria'] as $index => $imgUrl): 
                        ?>
                            <div class="swiper-slide bg-gray-900 cursor-pointer" onclick="openLightbox(<?php echo $index; ?>)">
                                <img src="../<?php echo $imgUrl; ?>" class="w-full h-auto object-contain max-h-[70vh] mx-auto" alt="Captura del sistema">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Pagination (Dots flotantes) -->
                    <div class="swiper-pagination"></div>
                    <!-- Navigation (Sutiles) -->
                    <div class="swiper-button-next hidden md:flex"></div>
                    <div class="swiper-button-prev hidden md:flex"></div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- CONTACT SECTION (CLON DE INDEX) -->
        <section id="contacto" class="py-24 bg-white dark:bg-gray-900 transition-colors duration-300 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
                <div class="bg-[#f8fafc]/80 dark:bg-gray-800/60 backdrop-blur-sm rounded-[2.5rem] p-6 md:p-12 lg:p-16 border border-gray-100 dark:border-gray-700/50 shadow-sm transition-colors duration-300 text-center">
                    <h2 class="text-3xl lg:text-5xl font-bold text-[#111827] dark:text-white mb-6">¿Quieres resultados similares?</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
                        Cuéntanos sobre tu idea o los retos de tu empresa. Nuestro equipo de expertos está listo para construir tu próximo caso de éxito.
                    </p>
                    <a href="../index.php#contacto" class="inline-flex items-center justify-center px-8 py-4 rounded-xl font-bold transition-all duration-200 bg-brand-cyan text-gray-900 hover:bg-brand-lime shadow-xl shadow-brand-cyan/20">
                        <i data-lucide="mail" class="w-5 h-5 mr-2"></i> Iniciar mi Proyecto
                    </a>
                </div>
            </div>
        </section>
    </main>
    
    <!-- FOOTER (IDÉNTICO A INDEX.PHP) -->
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

    <!-- LIGHTBOX / VISUALIZADOR INMERSIVO (NUEVA ESTRUCTURA CON NAVEGACIÓN) -->
    <div id="lightbox" onclick="if(event.target === this) closeLightbox()" class="fixed inset-0 z-[200] bg-black/95 backdrop-blur-xl hidden flex-col items-center justify-center p-4 md:p-10 opacity-0 transition-all duration-300 pointer-events-none cursor-pointer">
        <!-- Close Button -->
        <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white/50 hover:text-white transition-all hover:scale-110 z-[220] focus:outline-none bg-black/20 p-2 rounded-full border border-white/10">
            <i data-lucide="x" class="w-8 h-8 md:w-10 h-10"></i>
        </button>
        
        <div class="relative max-w-6xl w-full h-full flex items-center justify-center pointer-events-none">
            <!-- Project Badge (Top Left Inside) -->
            <div class="absolute top-4 left-4 md:top-8 md:left-8 z-[210] pointer-events-auto">
                <div class="bg-[#4F6BB0] px-3 py-1.5 md:px-5 md:py-2.5 rounded-xl shadow-2xl border border-white/20">
                    <span class="text-white text-[10px] md:text-sm font-black whitespace-nowrap uppercase tracking-widest">
                        <?php echo htmlspecialchars($proyectoActual['nombre']); ?>
                    </span>
                </div>
            </div>

            <!-- THE IMAGE -->
            <img id="lightbox-img" src="" alt="" class="max-h-[85vh] w-auto rounded-2xl shadow-2xl border border-white/10 object-contain transition-all duration-300 scale-95 pointer-events-auto">
            
            <!-- Image Counter (Bottom Right Inside) -->
            <div id="lightbox-counter" class="absolute bottom-4 right-4 md:bottom-8 md:right-8 z-[210] text-white/50 text-[10px] md:text-xs font-medium bg-black/40 px-4 py-2 rounded-full backdrop-blur-md border border-white/5 pointer-events-auto">
                Imagen 0 de 0
            </div>

            <!-- Navigation Buttons -->
            <button onclick="changeLightboxImg(-1)" class="absolute left-0 md:-left-20 p-4 text-white/40 hover:text-white transition-all hover:scale-110 pointer-events-auto group focus:outline-none">
                <i data-lucide="chevron-left" class="w-12 h-12 md:w-16 h-16 transform group-active:-translate-x-1 transition-transform"></i>
            </button>
            <button onclick="changeLightboxImg(1)" class="absolute right-0 md:-right-20 p-4 text-white/40 hover:text-white transition-all hover:scale-110 pointer-events-auto group focus:outline-none">
                <i data-lucide="chevron-right" class="w-12 h-12 md:w-16 h-16 transform group-active:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </div>

    <!-- FLOATING CHAT (IDÉNTICO A INDEX.PHP) -->
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

    <!-- MOBILE MENU OVERLAY (IDÉNTICO A INDEX.PHP) -->
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
                <a href="portafolio.php" class="mobile-nav-link block text-2xl font-bold text-gray-900 dark:text-white hover:text-brand-lime dark:hover:text-brand-lime transition-colors">Portafolio</a>
                <a href="../index.php#clientes" class="mobile-nav-link block text-2xl font-bold text-gray-900 dark:text-white hover:text-brand-cyan dark:hover:text-brand-cyan transition-colors">Clientes</a>
                <a href="../index.php#contacto" class="mobile-nav-link block text-2xl font-bold text-gray-900 dark:text-white hover:text-brand-lime dark:hover:text-brand-lime transition-colors">Contacto</a>
                
                <div class="pt-10 border-t border-gray-50 dark:border-gray-800">
                    <a href="https://wa.me/526672644610" target="_blank" class="w-full inline-flex items-center justify-center px-6 py-4 rounded-xl font-bold transition-all duration-200 text-sm border bg-brand-cyan text-gray-900 border-brand-cyan hover:bg-brand-lime hover:border-brand-lime">
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
        lucide.createIcons();
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fix for Relative API paths in main.js
            window.apiHandlerPath = '../api/contact_handler.php';

            var swiper = new Swiper(".gallery-swiper", {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                speed: 600,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });

            // LÓGICA DEL LIGHTBOX MEJORADA (CON NAVEGACIÓN)
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxCounter = document.getElementById('lightbox-counter');
            
            // Datos de la galería cargados desde PHP
            const galleryImages = <?php echo json_encode(array_map(function($url) { return '../' . $url; }, $proyectoActual['galeria'])); ?>;
            let currentImgIndex = 0;

            window.openLightbox = function(index) {
                currentImgIndex = index;
                updateLightboxContent();
                
                lightbox.classList.remove('hidden');
                // Forzar reflow para animación
                void lightbox.offsetWidth;
                lightbox.classList.add('flex', 'opacity-100', 'pointer-events-auto');
                lightboxImg.classList.add('scale-100');
                document.body.style.overflow = 'hidden';
            }

            window.updateLightboxContent = function() {
                const url = galleryImages[currentImgIndex];
                // Efecto de transición suave al cambiar imagen
                lightboxImg.style.opacity = '0';
                lightboxImg.style.transform = 'scale(0.95)';
                
                setTimeout(() => {
                    lightboxImg.src = url;
                    lightboxCounter.textContent = `Imagen ${currentImgIndex + 1} de ${galleryImages.length}`;
                    lightboxImg.style.opacity = '1';
                    lightboxImg.style.transform = 'scale(1)';
                }, 150);
            }

            window.changeLightboxImg = function(delta) {
                currentImgIndex += delta;
                if (currentImgIndex >= galleryImages.length) currentImgIndex = 0;
                if (currentImgIndex < 0) currentImgIndex = galleryImages.length - 1;
                updateLightboxContent();
            }

            window.closeLightbox = function() {
                lightbox.classList.remove('opacity-100', 'pointer-events-auto');
                lightboxImg.classList.remove('scale-100');
                setTimeout(() => {
                    lightbox.classList.add('hidden');
                    lightbox.classList.remove('flex');
                    document.body.style.overflow = '';
                    lightboxImg.src = '';
                }, 300);
            }

            // Atajos de teclado
            document.addEventListener('keydown', (e) => {
                if (lightbox.classList.contains('hidden')) return;
                
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowRight') changeLightboxImg(1);
                if (e.key === 'ArrowLeft') changeLightboxImg(-1);
            });
        });
    </script>
</body>
</html>
