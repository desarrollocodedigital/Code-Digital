<?php
/**
 * Componente: Tarjeta de Proyecto
 * Renderiza una tarjeta individual basada en el array $proyecto.
 */

// Definición de colores de marca basados en el campo 'color'
$colorBrand = $proyecto['color'] === 'lima' ? 'brand-lime' : 'brand-cyan';
$rgbShadow = $proyecto['color'] === 'lima' ? '178,255,5' : '0,229,255';

// Fix path for subdirectories if image is relative
$base_asset_path = $base_asset_path ?? '';
$imageUrl = $proyecto['imagen_url'];
if (strpos($imageUrl, 'http') !== 0 && strpos($imageUrl, '//') !== 0 && strpos($imageUrl, '/') !== 0) {
    $imageUrl = $base_asset_path . $imageUrl;
}
?>

<div class="bg-white dark:bg-gray-800 rounded-[2.5rem] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-gray-100 dark:border-gray-700 flex flex-col group hover:shadow-[0_8px_30px_rgb(<?php echo $rgbShadow; ?>,0.08)] dark:hover:shadow-[0_8px_30px_rgb(<?php echo $rgbShadow; ?>,0.15)] transition-all duration-300 hover:-translate-y-1">
    <!-- Miniatura e Indicador de Estado -->
    <div class="relative h-64 sm:h-72 overflow-hidden bg-gray-50 dark:bg-gray-700">
        <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($proyecto['nombre']); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 mix-blend-multiply opacity-90 dark:opacity-75" />
        
        <!-- Badge Flotante (Aparece al hover) -->
        <div class="absolute bottom-6 left-6 right-6 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md p-4 rounded-2xl shadow-xl z-20 transform translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 border border-white dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-<?php echo $colorBrand; ?>/20 dark:bg-<?php echo $colorBrand; ?>/20 rounded-full flex items-center justify-center text-<?php echo $colorBrand; ?> dark:text-<?php echo $colorBrand; ?>">
                    <i data-lucide="<?php echo $proyecto['icono_estado']; ?>" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="font-bold text-[#111827] dark:text-white text-sm group-hover:text-<?php echo $colorBrand; ?> transition-colors"><?php echo $proyecto['texto_estado']; ?></div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5"><?php echo $proyecto['subtexto_estado']; ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Detallado -->
    <div class="p-8 lg:p-10 flex flex-col flex-1">
        <!-- Encabezado de Proyecto -->
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center text-gray-500 font-bold text-xl border border-gray-200 dark:border-gray-600">
                <?php echo $proyecto['inicial_logo']; ?>
            </div>
            <span class="font-bold text-xl text-[#111827] dark:text-white tracking-tight group-hover:text-<?php echo $colorBrand; ?> transition-colors">
                <?php echo $proyecto['nombre']; ?>
            </span>
        </div>

        <h3 class="text-xl lg:text-2xl font-bold text-[#111827] dark:text-white mb-3 leading-tight group-hover:text-<?php echo $colorBrand; ?> transition-colors">
            <?php echo $proyecto['tagline']; ?>
        </h3>
        
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 leading-relaxed line-clamp-2">
            <?php echo $proyecto['descripcion']; ?>
        </p>

        <!-- Grid de Estadísticas -->
        <div class="grid grid-cols-3 gap-4 mb-8 bg-[#f8fafc] dark:bg-gray-900/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700">
            <?php foreach ($proyecto['estadisticas'] as $stat): ?>
                <div class="text-center">
                    <div class="text-lg font-bold text-[#111827] dark:text-white"><?php echo $stat['valor']; ?></div>
                    <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 font-semibold uppercase tracking-wider">
                        <?php echo $stat['etiqueta']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Tecnologías y Acción -->
        <div class="mt-auto">
            <div class="flex flex-wrap gap-2 mb-6">
                <?php foreach ($proyecto['tecnologias'] as $tech): ?>
                    <span class="px-2.5 py-1 bg-[#f0f4f8] dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] font-semibold uppercase tracking-wider rounded-lg border border-[#eaf4fe] dark:border-gray-600 hover:bg-<?php echo $colorBrand; ?>/10 dark:hover:bg-<?php echo $colorBrand; ?>/20 hover:border-<?php echo $colorBrand; ?>/30 hover:text-<?php echo $colorBrand; ?> dark:hover:text-<?php echo $colorBrand; ?> transition-colors cursor-default">
                        <?php echo $tech; ?>
                    </span>
                <?php endforeach; ?>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <button 
                    data-project-name="<?php echo $proyecto['nombre']; ?>"
                    type="button"
                    class="open-demo-modal relative z-30 w-full sm:w-auto px-6 py-3 bg-<?php echo $colorBrand; ?> text-gray-900 font-bold rounded-xl text-sm transition-all hover:bg-<?php echo $colorBrand; ?>/90 hover:shadow-[0_4px_20px_rgb(<?php echo $rgbShadow; ?>,0.3)] active:scale-95"
                >
                    Solicitar Demo
                </button>
                <?php $detailLink = empty($base_asset_path) ? 'views/proyecto_detalle.php' : 'proyecto_detalle.php'; ?>
                <a href="<?php echo $detailLink . '?slug=' . urlencode($proyecto['id']); ?>" class="text-[#111827] dark:text-white font-semibold text-sm flex items-center gap-2 hover:gap-3 transition-all hover:text-<?php echo $colorBrand; ?> dark:hover:text-<?php echo $colorBrand; ?>">
                    Ver Caso <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>
</div>
