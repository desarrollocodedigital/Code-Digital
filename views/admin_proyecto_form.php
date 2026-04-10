<?php require_once '../includes/auth_guard.php'; ?>
<?php
/**
 * Página de Formulario: Proyectos
 */
require_once __DIR__ . '/../config/db.php';

$id = $_GET['id'] ?? null;
$proyecto = null;

if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM proyectos WHERE id = ?");
        $stmt->execute([$id]);
        $proyecto = $stmt->fetch();
        if ($proyecto) {
            $stmtGal = $pdo->prepare("SELECT id, imagen_url FROM proyecto_imagenes WHERE proyecto_id = ? ORDER BY orden ASC");
            $stmtGal->execute([$id]);
            $proyecto['galeria'] = $stmtGal->fetchAll();
        }
    } catch (PDOException $e) {
        $error = "Error al cargar el proyecto: " . $e->getMessage();
    }
}

$title = ($proyecto ? "Editar" : "Nuevo") . " Proyecto";
$page_title = $title;
$current_tab = 'proyectos';

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
?>

<div class="p-6 lg:p-10 space-y-8 animate-fade-in max-w-[1400px] mx-auto">
    <div class="flex items-center gap-4 mb-2">
        <a href="admin.php?tab=proyectos" class="p-2.5 bg-white dark:bg-gray-900 text-gray-500 hover:text-brand-cyan rounded-xl border border-gray-100 dark:border-gray-800 transition-all shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white"><?php echo $title; ?> <span class="text-brand-cyan">.</span></h2>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
        <!-- Columna Formulario -->
        <div class="xl:col-span-2 space-y-8">
            <?php if (isset($error)): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-2xl flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <span class="font-medium"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden">
                <form id="project-form" class="p-8 lg:p-12 space-y-8" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $proyecto['id'] ?? ''; ?>">
            <input type="hidden" name="action" value="save_project">
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($proyecto['imagen_url'] ?? ''); ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="type" class="w-3.5 h-3.5"></i> Nombre del Proyecto
                    </label>
                    <input type="text" name="nombre" value="<?php echo htmlspecialchars($proyecto['nombre'] ?? ''); ?>" placeholder="Ej. Neura Link" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" required />
                </div>
                <div class="space-y-3">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="link" class="w-3.5 h-3.5"></i> Slug / ID URL
                    </label>
                    <input type="text" name="slug" value="<?php echo htmlspecialchars($proyecto['slug'] ?? ''); ?>" placeholder="ej: neura-link" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" />
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="info" class="w-3.5 h-3.5"></i> Tagline Corto
                </label>
                <input type="text" name="tagline" value="<?php echo htmlspecialchars($proyecto['tagline'] ?? ''); ?>" placeholder="Innovación en cada byte" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" />
            </div>

            <div class="space-y-3">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="align-left" class="w-3.5 h-3.5"></i> Descripción Detallada
                </label>
                <textarea name="descripcion" rows="4" placeholder="Describe los objetivos y alcances del proyecto..." class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all resize-none font-medium text-gray-900 dark:text-white"><?php echo htmlspecialchars($proyecto['descripcion'] ?? ''); ?></textarea>
            </div>

            <!-- Detalles del Caso de Estudio -->
            <div class="p-8 bg-gray-50 dark:bg-gray-800/50 rounded-[2rem] space-y-8 border border-gray-100 dark:border-gray-800">
                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2 border-l-4 border-brand-lime pl-4">Detalles del Caso de Estudio</h4>
                <div class="space-y-3">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i> El Problema
                    </label>
                    <textarea name="problema" rows="4" placeholder="¿Cuál era el desafío inicial del cliente?" class="w-full bg-white dark:bg-gray-900 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all resize-none font-medium text-gray-900 dark:text-white"><?php echo htmlspecialchars($proyecto['problema'] ?? ''); ?></textarea>
                </div>
                <div class="space-y-3">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center justify-between gap-2">
                        <span class="flex items-center gap-2"><i data-lucide="grid" class="w-3.5 h-3.5"></i> Funcionalidades Principales</span>
                        <span class="text-[10px] text-brand-cyan lowercase font-medium px-2 py-0.5 bg-brand-cyan/10 rounded-full">Separar con saltos de línea (Enter)</span>
                    </label>
                    <textarea name="funcionalidades" rows="4" placeholder="Ej:&#10;Módulo de inventarios&#10;Panel de analítica&#10;Integración con API" class="w-full bg-white dark:bg-gray-900 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all resize-none font-medium text-gray-900 dark:text-white"><?php echo htmlspecialchars($proyecto['funcionalidades'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="image" class="w-3.5 h-3.5"></i> Inicial Logo
                    </label>
                    <input type="text" name="inicial_logo" value="<?php echo htmlspecialchars($proyecto['inicial_logo'] ?? ''); ?>" placeholder="C" maxlength="1" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white text-center text-xl font-black uppercase" />
                </div>
                <div class="space-y-3">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="palette" class="w-3.5 h-3.5"></i> Color de Identidad
                    </label>
                    <select name="color" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all appearance-none font-medium text-gray-900 dark:text-white">
                        <option value="cian" <?php echo ($proyecto['color'] ?? '') === 'cian' ? 'selected' : ''; ?>>Cian Electrónico</option>
                        <option value="lima" <?php echo ($proyecto['color'] ?? '') === 'lima' ? 'selected' : ''; ?>>Lima Destello</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-3">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center justify-between gap-2">
                        <span class="flex items-center gap-2"><i data-lucide="layout" class="w-3.5 h-3.5"></i> Icono de Estado</span>
                    </label>
                    <input type="text" name="icono_estado" value="<?php echo htmlspecialchars($proyecto['icono_estado'] ?? ''); ?>" placeholder="check-circle" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" />
                    <a href="https://lucide.dev/icons/" target="_blank" class="text-[10px] text-brand-cyan hover:underline flex items-center gap-1 font-medium mt-2">
                        <i data-lucide="external-link" class="w-3 h-3"></i> Explorar catálogo de iconos en Lucide
                    </a>
                </div>
                <div class="space-y-3">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="activity" class="text-yellow-500 w-3.5 h-3.5"></i> Texto de Estado
                    </label>
                    <input type="text" name="texto_estado" value="<?php echo htmlspecialchars($proyecto['texto_estado'] ?? 'En Curso'); ?>" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" />
                </div>
                <div class="space-y-3">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="box" class="w-3.5 h-3.5"></i> Categoría
                    </label>
                    <input type="text" name="subtexto_estado" value="<?php echo htmlspecialchars($proyecto['subtexto_estado'] ?? 'Software'); ?>" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" />
                </div>
            </div>

            <div class="space-y-4">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="image-plus" class="w-3.5 h-3.5"></i> Imagen de Portada (.png, .jpg, .jpeg)
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-gray-50 dark:bg-gray-800/50 p-6 rounded-3xl border border-gray-100 dark:border-gray-800">
                    <div class="space-y-4">
                        <input type="file" id="image-upload" name="imagen_archivo" accept=".png,.jpg,.jpeg" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-brand-cyan file:text-gray-900 hover:file:bg-brand-cyan/80 transition-all cursor-pointer" />
                        <p class="text-[10px] text-gray-500 font-medium">Recomendado: 1200x800px. Máximo 2MB.</p>
                    </div>
                    <div class="relative group aspect-video rounded-2xl overflow-hidden bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-inner flex items-center justify-center">
                        <img id="image-preview" src="<?php echo !empty($proyecto['imagen_url']) ? '../' . $proyecto['imagen_url'] : 'https://placehold.co/600x400/00E5FF/1e1e2e?text=Vista+Previa'; ?>" class="w-full h-full object-cover <?php echo empty($proyecto['imagen_url']) ? 'opacity-20' : ''; ?>" alt="Vista Previa" />
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-[10px] font-black text-white uppercase tracking-widest">Previsualización en Vivo</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Galería -->
            <div class="p-8 bg-gray-50 dark:bg-gray-800/50 rounded-[2rem] space-y-8 border border-gray-100 dark:border-gray-800">
                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2 border-l-4 border-brand-cyan pl-4">Galería de Imágenes</h4>
                
                <div class="space-y-4">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="images" class="w-3.5 h-3.5"></i> Añadir Nuevas Imágenes
                    </label>
                    <input type="file" name="galeria_archivos[]" accept=".png,.jpg,.jpeg" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-brand-cyan file:text-gray-900 hover:file:bg-brand-cyan/80 transition-all cursor-pointer bg-white dark:bg-gray-900 rounded-2xl p-2" />
                    <p class="text-[10px] text-gray-500 font-medium">Recomendado: 1200x800px. Puedes seleccionar varios archivos a la vez.</p>
                </div>

                <?php if (!empty($proyecto['galeria'])): ?>
                <div id="gallery-section" class="space-y-4">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2 block bg-white dark:bg-gray-900 p-3 rounded-xl border border-gray-100 dark:border-gray-800">
                        <i data-lucide="info" class="w-3.5 h-3.5 text-brand-cyan"></i> Haz clic en la papelera para eliminar imágenes de forma inmediata:
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <?php foreach($proyecto['galeria'] as $img): ?>
                            <div class="gallery-item relative group aspect-video rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm transition-all duration-300">
                                <img src="../<?php echo $img['imagen_url']; ?>" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-red-500/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="button" onclick="deleteGalleryImg(<?php echo $img['id']; ?>, this.closest('.gallery-item'))" class="text-white transform hover:scale-125 transition-transform duration-300" title="Eliminar imagen">
                                        <i data-lucide="trash-2" class="w-8 h-8"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="p-8 bg-gray-50 dark:bg-gray-800/50 rounded-[2rem] space-y-8 border border-gray-100 dark:border-gray-800">
                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2 border-l-4 border-brand-lime pl-4">Metodología y Métricas</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Métrica 1 Valor</label>
                            <input type="text" name="stat1_valor" value="<?php echo htmlspecialchars($proyecto['stat1_valor'] ?? ''); ?>" placeholder="98%" class="w-full bg-white dark:bg-gray-900 border border-transparent focus:border-brand-cyan rounded-xl px-5 py-3 outline-none transition-all" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Métrica 1 Etiqueta</label>
                            <input type="text" name="stat1_etiqueta" value="<?php echo htmlspecialchars($proyecto['stat1_etiqueta'] ?? ''); ?>" placeholder="Uptime Mensual" class="w-full bg-white dark:bg-gray-900 border border-transparent focus:border-brand-cyan rounded-xl px-5 py-3 outline-none transition-all" />
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Métrica 2 Valor</label>
                            <input type="text" name="stat2_valor" value="<?php echo htmlspecialchars($proyecto['stat2_valor'] ?? ''); ?>" placeholder="2.4s" class="w-full bg-white dark:bg-gray-900 border border-transparent focus:border-brand-cyan rounded-xl px-5 py-3 outline-none transition-all" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Métrica 2 Etiqueta</label>
                            <input type="text" name="stat2_etiqueta" value="<?php echo htmlspecialchars($proyecto['stat2_etiqueta'] ?? ''); ?>" placeholder="Carga LCP" class="w-full bg-white dark:bg-gray-900 border border-transparent focus:border-brand-cyan rounded-xl px-5 py-3 outline-none transition-all" />
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Métrica 3 Valor</label>
                            <input type="text" name="stat3_valor" value="<?php echo htmlspecialchars($proyecto['stat3_valor'] ?? ''); ?>" placeholder="10k+" class="w-full bg-white dark:bg-gray-900 border border-transparent focus:border-brand-cyan rounded-xl px-5 py-3 outline-none transition-all" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Métrica 3 Etiqueta</label>
                            <input type="text" name="stat3_etiqueta" value="<?php echo htmlspecialchars($proyecto['stat3_etiqueta'] ?? ''); ?>" placeholder="Usuarios" class="w-full bg-white dark:bg-gray-900 border border-transparent focus:border-brand-cyan rounded-xl px-5 py-3 outline-none transition-all" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="cpu" class="text-brand-lime w-3.5 h-3.5"></i> Tecnologías (Separadas por comas)
                </label>
                <input type="text" name="tecnologias" value="<?php echo htmlspecialchars($proyecto['tecnologias'] ?? ''); ?>" placeholder="PHP, MySQL, Tailwind, AI, Python" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" />
            </div>

                <div class="flex items-center justify-end gap-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                    <a href="admin.php?tab=proyectos" class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">Cancelar y Volver</a>
                    <button type="submit" class="bg-brand-cyan text-gray-900 px-10 py-5 rounded-[2rem] font-bold shadow-xl shadow-brand-cyan/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-3">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        Confirmar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Columna Previsualización -->
    <div class="hidden xl:block">
        <div class="sticky top-28 space-y-6">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2 h-2 rounded-full bg-brand-cyan animate-pulse"></span>
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Live Feed Preview</h3>
            </div>
            
            <!-- Real Card Clone (Identical to project-card.php) -->
            <div id="live-card" class="bg-white dark:bg-gray-800 rounded-[2.5rem] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-gray-100 dark:border-gray-700 flex flex-col group transition-all duration-500 min-h-[600px]">
                <!-- Miniatura e Indicador de Estado -->
                <div class="relative h-64 overflow-hidden bg-gray-50 dark:bg-gray-700">
                    <img id="live-card-img" src="<?php echo !empty($proyecto['imagen_url']) ? '../' . $proyecto['imagen_url'] : ''; ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 mix-blend-multiply opacity-90 dark:opacity-75" />
                    
                    <!-- Badge Flotante (Permanente en Preview para visibilidad) -->
                    <div class="absolute bottom-6 left-6 right-6 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md p-4 rounded-2xl shadow-xl z-20 border border-white dark:border-gray-700">
                        <div class="flex items-center gap-4">
                            <div id="live-card-badge-icon-bg" class="w-10 h-10 bg-brand-cyan/20 dark:bg-brand-cyan/20 rounded-full flex items-center justify-center text-brand-cyan dark:text-brand-cyan">
                                <i id="live-card-status-icon" data-lucide="<?php echo $proyecto['icono_estado'] ?? 'zap'; ?>" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div id="live-card-status-text" class="font-bold text-[#111827] dark:text-white text-sm"><?php echo $proyecto['texto_estado'] ?? 'Live'; ?></div>
                                <div id="live-card-status-subtext" class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5"><?php echo $proyecto['subtexto_estado'] ?? 'Software'; ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido Detallado -->
                <div class="p-8 flex flex-col flex-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div id="live-card-logo-bg" class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center text-gray-500 font-bold text-xl border border-gray-200 dark:border-gray-600 transition-colors">
                            <span id="live-card-logo"><?php echo $proyecto['inicial_logo'] ?? 'C'; ?></span>
                        </div>
                        <span id="live-card-name-title" class="font-bold text-xl text-[#111827] dark:text-white tracking-tight transition-colors">
                            <?php echo $proyecto['nombre'] ?? 'Nombre del Proyecto'; ?>
                        </span>
                    </div>

                    <h3 id="live-card-tagline" class="text-xl lg:text-2xl font-bold text-[#111827] dark:text-white mb-3 leading-tight transition-colors">
                        <?php echo $proyecto['tagline'] ?? 'Eslogan de innovación avanzada'; ?>
                    </h3>
                    
                    <p id="live-card-desc" class="text-gray-500 dark:text-gray-400 text-sm mb-8 leading-relaxed line-clamp-2">
                        <?php echo $proyecto['descripcion'] ?? 'Descripción corta para la tarjeta del portafolio del sitio web principal.'; ?>
                    </p>

                    <!-- Grid de Estadísticas -->
                    <div class="grid grid-cols-3 gap-4 mb-8 bg-[#f8fafc] dark:bg-gray-900/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="text-center">
                            <div id="live-card-stat1-val" class="text-lg font-bold text-[#111827] dark:text-white"><?php echo $proyecto['stat1_valor'] ?? '--'; ?></div>
                            <div id="live-card-stat1-lab" class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 font-semibold uppercase tracking-wider"><?php echo $proyecto['stat1_etiqueta'] ?? 'Stat 1'; ?></div>
                        </div>
                        <div class="text-center border-l border-gray-100 dark:border-gray-800">
                            <div id="live-card-stat2-val" class="text-lg font-bold text-[#111827] dark:text-white"><?php echo $proyecto['stat2_valor'] ?? '--'; ?></div>
                            <div id="live-card-stat2-lab" class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 font-semibold uppercase tracking-wider"><?php echo $proyecto['stat2_etiqueta'] ?? 'Stat 2'; ?></div>
                        </div>
                        <div class="text-center border-l border-gray-100 dark:border-gray-800">
                            <div id="live-card-stat3-val" class="text-lg font-bold text-[#111827] dark:text-white"><?php echo $proyecto['stat3_valor'] ?? '--'; ?></div>
                            <div id="live-card-stat3-lab" class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 font-semibold uppercase tracking-wider"><?php echo $proyecto['stat3_etiqueta'] ?? 'Stat 3'; ?></div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <div id="live-card-techs" class="flex flex-wrap gap-2 mb-6 text-gray-400 italic text-[10px]">
                            Configura las tecnologías para ver el preview...
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div id="live-card-btn" class="px-6 py-3 bg-brand-cyan text-gray-900 font-bold rounded-xl text-sm transition-all shadow-lg shadow-brand-cyan/20">Solicitar Demo</div>
                            <div class="text-[#111827] dark:text-white font-semibold text-sm flex items-center gap-2">Ver Caso <i data-lucide="arrow-right" class="w-4 h-4"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-brand-cyan/5 rounded-3xl border border-brand-cyan/10">
                <p class="text-[10px] font-bold text-brand-cyan uppercase tracking-widest leading-relaxed">
                    Esta es una representación exacta de cómo se verá tu proyecto en la página de inicio. Realiza cambios en el formulario y observa los resultados.
                </p>
            </div>
        </div>
    </div>
</div>

</div> <!-- Close content-container from sidebar -->
</main>
</div> <!-- Close flex from sidebar -->

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navProyectos = document.getElementById('nav-proyectos');
        if (navProyectos) {
            navProyectos.classList.add('bg-brand-cyan/10', 'text-brand-cyan', 'border-brand-cyan/20');
            navProyectos.classList.remove('text-gray-500', 'dark:text-gray-400');
        }
        // LIVE PREVIEW LOGIC
        const liveCard = {
            nameTitle: document.getElementById('live-card-name-title'),
            tagline: document.getElementById('live-card-tagline'),
            description: document.getElementById('live-card-desc'),
            logo: document.getElementById('live-card-logo'),
            logoBg: document.getElementById('live-card-logo-bg'),
            statusText: document.getElementById('live-card-status-text'),
            statusSubtext: document.getElementById('live-card-status-subtext'),
            statusIcon: document.getElementById('live-card-status-icon'),
            badgeIconBg: document.getElementById('live-card-badge-icon-bg'),
            img: document.getElementById('live-card-img'),
            btn: document.getElementById('live-card-btn'),
            stats: {
                v1: document.getElementById('live-card-stat1-val'), l1: document.getElementById('live-card-stat1-lab'),
                v2: document.getElementById('live-card-stat2-val'), l2: document.getElementById('live-card-stat2-lab'),
                v3: document.getElementById('live-card-stat3-val'), l3: document.getElementById('live-card-stat3-lab')
            },
            techs: document.getElementById('live-card-techs'),
            container: document.getElementById('live-card')
        };

        const updateLivePreview = () => {
            const formData = new FormData(pForm);
            const color = formData.get('color');
            const colorClass = color === 'lima' ? 'brand-lime' : 'brand-cyan';
            const rgbShadow = color === 'lima' ? '178,255,5' : '0,229,255';

            liveCard.nameTitle.textContent = formData.get('nombre') || 'Nombre del Proyecto';
            liveCard.tagline.textContent = formData.get('tagline') || 'Eslogan de innovación...';
            liveCard.description.textContent = formData.get('descripcion') || 'Descripción corta para el sitio...';
            liveCard.logo.textContent = formData.get('inicial_logo') || 'C';
            liveCard.statusText.textContent = formData.get('texto_estado') || 'Live';
            liveCard.statusSubtext.textContent = formData.get('subtexto_estado') || 'Software';
            
            // Stats
            liveCard.stats.v1.textContent = formData.get('stat1_valor') || '--';
            liveCard.stats.l1.textContent = formData.get('stat1_etiqueta') || 'Stat 1';
            liveCard.stats.v2.textContent = formData.get('stat2_valor') || '--';
            liveCard.stats.l2.textContent = formData.get('stat2_etiqueta') || 'Stat 2';
            liveCard.stats.v3.textContent = formData.get('stat3_valor') || '--';
            liveCard.stats.l3.textContent = formData.get('stat3_etiqueta') || 'Stat 3';
            
            // Techs
            const techs = formData.get('tecnologias').split(',').map(t => t.trim()).filter(t => t !== '');
            if (techs.length > 0) {
                liveCard.techs.innerHTML = techs.map(t => `<span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[9px] font-bold uppercase rounded border border-gray-200 dark:border-gray-600 transition-colors">${t}</span>`).join('');
            } else {
                liveCard.techs.innerHTML = '<span class="italic opacity-30">Configura tecnologías...</span>';
            }

            // Actualizar Icono (Forzar reemplazo directo en el contenedor persistente)
            const iconName = formData.get('icono_estado') || 'zap';
            liveCard.badgeIconBg.innerHTML = `<i data-lucide="${iconName}" class="w-5 h-5"></i>`;
            
            // Actualizar Colores y Sombras
            liveCard.badgeIconBg.classList.value = `w-10 h-10 bg-${colorClass}/20 dark:bg-${colorClass}/20 rounded-full flex items-center justify-center text-${colorClass} dark:text-${colorClass}`;
            liveCard.btn.classList.value = `px-6 py-3 bg-${colorClass} text-gray-900 font-bold rounded-xl text-sm transition-all shadow-lg shadow-${colorClass}/20`;
            liveCard.container.style.boxShadow = `0 8px 30px rgba(${rgbShadow}, 0.08)`;

            if (typeof lucide !== 'undefined') lucide.createIcons();
        };

        // Escuchar cambios en todos los inputs
        pForm.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('input', updateLivePreview);
        });

        // Auto-generación de Slug
        const nombreInput = pForm.querySelector('input[name="nombre"]');
        const slugInput = pForm.querySelector('input[name="slug"]');
        
        nombreInput.addEventListener('input', (e) => {
            const slug = e.target.value
                .toLowerCase()
                .trim()
                .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                .replace(/[^a-z0-9 -]/g, "")
                .replace(/\s+/g, "-")
                .replace(/-+/g, "-");
            
            slugInput.value = slug;
        });

        // Preview de Imagen en Tiempo Real (Ajustado)
        const imageUpload = document.getElementById('image-upload');
        const imagePreview = document.getElementById('image-preview');
        
        imageUpload.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    imagePreview.src = event.target.result;
                    imagePreview.classList.remove('opacity-20');
                    liveCard.img.src = event.target.result;
                    liveCard.img.style.opacity = '1';
                    liveCard.img.classList.remove('opacity-30', 'mix-blend-multiply');
                };
                reader.readAsDataURL(file);
            }
        });

        // Carga inicial
        updateLivePreview();
    });

    const pForm = document.getElementById('project-form');
    pForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(pForm);
        
        try {
            const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
            const result = await response.json();
            if (result.success) {
                const isEdit = formData.get('id') !== '';
                window.location.href = `admin.php?tab=proyectos&msg=${isEdit ? 'proyecto_modificado' : 'proyecto_creado'}`;
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error(error);
            alert('Error de conexión con el servidor');
        }
    });

    // LÓGICA DE BORRADO DE GALERÍA (INMEDIATO)
    window.deleteGalleryImg = function(id, element) {
        if (!confirm('¿Estás seguro de eliminar esta imagen? Esta acción se ejecutará de inmediato y no se puede deshacer.')) return;

        const formData = new FormData();
        formData.append('action', 'delete_gallery_image');
        formData.append('id', id);

        // Efecto visual de "procesando"
        element.classList.add('opacity-50', 'pointer-events-none');

        fetch('../api/admin_actions.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Animación de salida
                element.style.transform = 'scale(0.8)';
                element.style.opacity = '0';
                setTimeout(() => {
                    element.remove();
                    // Ocultar sección si ya no hay imágenes
                    const remaining = document.querySelectorAll('.gallery-item');
                    if (remaining.length === 0) {
                        const section = document.getElementById('gallery-section');
                        if (section) section.classList.add('hidden');
                    }
                }, 300);
            } else {
                element.classList.remove('opacity-50', 'pointer-events-none');
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            element.classList.remove('opacity-50', 'pointer-events-none');
            console.error('Error:', error);
            alert('Ocurrió un error al intentar eliminar la imagen.');
        });
    };
</script>
</body>
</html>
