<?php 
require_once '../includes/auth_guard.php';
include '../models/proyectos.php'; 
include '../models/clientes.php'; 
include '../models/mensajes.php'; 
include '../models/clientes_potenciales.php'; 
include '../models/ajustes.php'; 
include '../models/plantillas.php'; 

$ajustes = getAjustes();
$plantillas = getPlantillas();
$current_tab = $_GET['tab'] ?? 'dashboard';
$title = "Dashboard";
$page_title = "Resumen del Sistema";

if ($current_tab === 'proyectos') {
    $title = "Proyectos";
    $page_title = "Administración de Casos de Éxito";
} elseif ($current_tab === 'clientes') {
    $title = "Clientes";
    $page_title = "Alianzas y Colaboraciones";
} elseif ($current_tab === 'mensajes') {
    $title = "Mensajes";
    $page_title = "Bandeja de Entrada CRM";
} elseif ($current_tab === 'potenciales') {
    $title = "C. Potenciales";
    $page_title = "Clientes Potenciales (CRM)";
} elseif ($current_tab === 'configuracion') {
    $title = "Configuración";
    $page_title = "Ajustes del Sitio";
} elseif ($current_tab === 'plantillas') {
    $title = "Plantillas";
    $page_title = "Gestión de Correos";
}

// Lógica de Actividad Reciente para el Dashboard
$actividades = [];
if (!empty($mensajes)) {
    foreach (array_slice($mensajes, 0, 5) as $m) {
        $actividades[] = [
            'tipo' => 'mensaje',
            'subtipo' => $m['tipo'],
            'titulo' => $m['nombre'],
            'fecha' => $m['fecha_creacion'],
            'resumen' => (strlen($m['descripcion']) > 60) ? substr($m['descripcion'], 0, 57) . '...' : $m['descripcion'],
            'leido' => ($m['estado'] === 'leido')
        ];
    }
}
if (!empty($clientes_potenciales)) {
    foreach (array_slice($clientes_potenciales, 0, 5) as $cp) {
        $actividades[] = [
            'tipo' => 'prospecto',
            'subtipo' => $cp['estado'],
            'titulo' => $cp['nombre'],
            'fecha' => $cp['fecha_creacion'],
            'resumen' => $cp['empresa_cargo'] ?? 'Nuevo prospecto registrado',
            'leido' => true
        ];
    }
}
usort($actividades, function($a, $b) {
    return strtotime($b['fecha']) - strtotime($a['fecha']);
});
$actividades_recientes = array_slice($actividades, 0, 5);

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
?>

<!-- TAB DASHBOARD -->
<div id="tab-dashboard" class="p-6 lg:p-10 space-y-8 animate-fade-in <?php echo $current_tab === 'dashboard' ? 'block' : 'hidden'; ?>">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Centro de Mando <span class="text-brand-cyan">.</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium italic">Visión estratégica de tu ecosistema de software.</p>
        </div>
        <div class="flex items-center gap-3 bg-white dark:bg-gray-800 p-2 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
            <span class="relative flex h-3 w-3 ml-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-lime opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-brand-lime"></span>
            </span>
            <span class="text-xs font-black uppercase tracking-widest text-gray-400 mr-2">Sistema Online</span>
        </div>
    </div>

    <!-- Bento Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- Proyectos Card -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1 group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-brand-cyan/10 rounded-2xl group-hover:bg-brand-cyan/20 transition-colors">
                    <i data-lucide="briefcase" class="text-brand-cyan w-6 h-6"></i>
                </div>
                <i data-lucide="arrow-up-right" class="text-gray-300 dark:text-gray-700 w-5 h-5 group-hover:text-brand-cyan transition-colors"></i>
            </div>
            <div class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter"><?php echo count($proyectos); ?></div>
            <div class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-[0.2em]">Casos de Éxito</div>
        </div>

        <!-- Clientes Card -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1 group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-brand-lime/10 rounded-2xl group-hover:bg-brand-lime/20 transition-colors">
                    <i data-lucide="users" class="text-brand-lime w-6 h-6"></i>
                </div>
                <i data-lucide="globe" class="text-gray-300 dark:text-gray-700 w-5 h-5 group-hover:text-brand-lime transition-colors"></i>
            </div>
            <div class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter"><?php echo count($clientes); ?></div>
            <div class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-[0.2em]">Alianzas Activas</div>
        </div>

        <!-- Prospectos Card -->
        <div class="bg-indigo-500 p-6 rounded-[2.5rem] shadow-lg shadow-indigo-500/20 transition-all hover:shadow-2xl hover:scale-[1.02] group relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="p-3 bg-white/20 rounded-2xl">
                    <i data-lucide="user-plus" class="text-white w-6 h-6"></i>
                </div>
            </div>
            <div class="text-4xl font-black text-white tracking-tighter relative z-10"><?php echo $potenciales_activos ?? 0; ?></div>
            <div class="text-[10px] font-bold text-white/70 mt-1 uppercase tracking-[0.2em] relative z-10">Leads Calificados</div>
        </div>

        <!-- Mensajes Card -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1 group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-cyan-50 dark:bg-cyan-900/30 rounded-2xl group-hover:bg-brand-cyan/20 transition-colors">
                    <i data-lucide="mail-search" class="text-brand-cyan w-6 h-6"></i>
                </div>
                <?php if(isset($unread_count) && $unread_count > 0): ?>
                    <span class="flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-brand-cyan opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-brand-cyan"></span>
                    </span>
                <?php endif; ?>
            </div>
            <div class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter"><?php echo count($mensajes); ?></div>
            <div class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-[0.2em]">Mensajes Totales</div>
        </div>
    </div>

    <!-- Main Dashboard Body -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Quick Actions Panel -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm">
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-400 mb-6 flex items-center gap-2">
                    <i data-lucide="zap" class="w-4 h-4 text-brand-lime"></i> Acciones Rápidas
                </h3>
                <div class="grid grid-cols-1 gap-3">
                    <a href="admin.php?tab=potenciales" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 hover:bg-brand-cyan/10 hover:border-brand-cyan/30 border border-transparent rounded-2xl transition-all group">
                        <div class="flex items-center gap-3">
                            <i data-lucide="plus-circle" class="w-5 h-5 text-gray-400 group-hover:text-brand-cyan"></i>
                            <span class="font-bold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white text-sm">Ver Prospectos</span>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="admin_proyecto_form.php" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 hover:bg-brand-lime/10 hover:border-brand-lime/30 border border-transparent rounded-2xl transition-all group">
                        <div class="flex items-center gap-3">
                            <i data-lucide="briefcase" class="w-5 h-5 text-gray-400 group-hover:text-brand-lime"></i>
                            <span class="font-bold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white text-sm">Nuevo Proyecto</span>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="admin.php?tab=mensajes" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 hover:bg-brand-cyan/10 hover:border-brand-cyan/30 border border-transparent rounded-2xl transition-all group">
                        <div class="flex items-center gap-3">
                            <i data-lucide="mail" class="w-5 h-5 text-gray-400 group-hover:text-brand-cyan"></i>
                            <span class="font-bold text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white text-sm">Revisar Bandeja</span>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Mini Tips / Uptime -->
            <div class="bg-gray-900 p-8 rounded-[2.5rem] border border-gray-800 shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:scale-110 transition-transform">
                    <i data-lucide="code-2" class="w-32 h-32 text-brand-cyan"></i>
                </div>
                <div class="relative z-10">
                    <h4 class="text-white font-bold text-lg mb-2">Code Digital Cloud</h4>
                    <p class="text-gray-400 text-xs leading-relaxed mb-6">Tu infraestructura de software está operando al 100% de capacidad analítica.</p>
                    <div class="flex items-center gap-4">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full border-2 border-gray-900 bg-brand-cyan"></div>
                            <div class="w-8 h-8 rounded-full border-2 border-gray-900 bg-brand-lime"></div>
                            <div class="w-8 h-8 rounded-full border-2 border-gray-900 bg-gray-700"></div>
                        </div>
                        <span class="text-[10px] font-black uppercase text-brand-cyan tracking-widest">Active Nodes</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="lg:col-span-8 bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm p-8 flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-400 flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-brand-cyan"></i> Actividad Reciente
                </h3>
                <span class="text-[10px] font-bold text-gray-400 bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full uppercase tracking-widest">Últimos 5 Eventos</span>
            </div>

            <div class="space-y-4 flex-1">
                <?php if(empty($actividades_recientes)): ?>
                    <div class="flex flex-col items-center justify-center py-20 text-center space-y-4">
                        <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-full border border-gray-100 dark:border-gray-700">
                            <i data-lucide="coffee" class="text-gray-300 w-12 h-12"></i>
                        </div>
                        <p class="text-gray-400 font-medium">Todo está tranquilo por aquí.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($actividades_recientes as $act): 
                        $icon = 'circle';
                        $colorClass = 'text-gray-400 bg-gray-100';
                        if($act['tipo'] === 'mensaje') {
                            $icon = ($act['subtipo'] === 'demo') ? 'monitor' : 'mail';
                            $colorClass = 'text-brand-cyan bg-brand-cyan/10';
                        } else {
                            $icon = 'user-plus';
                            $colorClass = 'text-brand-lime bg-brand-lime/10';
                        }
                    ?>
                    <div class="flex items-start gap-4 p-5 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-3xl transition-all border border-transparent hover:border-gray-100 dark:hover:border-gray-800 group <?php echo (!$act['leido']) ? 'border-l-4 border-l-brand-cyan' : ''; ?>">
                        <div class="p-3 <?php echo $colorClass; ?> rounded-2xl group-hover:scale-110 transition-transform">
                            <i data-lucide="<?php echo $icon; ?>" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-4 mb-1">
                                <h4 class="font-bold text-gray-900 dark:text-white truncate"><?php echo htmlspecialchars($act['titulo']); ?></h4>
                                <span class="text-[10px] font-black text-gray-400 uppercase flex-shrink-0"><?php echo date('h:i A', strtotime($act['fecha'])); ?></span>
                            </div>
                            <p class="text-xs text-gray-500 leading-relaxed truncate"><?php echo htmlspecialchars($act['resumen']); ?></p>
                            <div class="mt-2 flex items-center gap-3">
                                <span class="text-[9px] font-black uppercase text-gray-400 tracking-tighter px-2 py-0.5 border border-gray-100 dark:border-gray-800 rounded-md"><?php echo ($act['tipo'] === 'mensaje') ? 'Mensaje CRM' : 'Propsecto'; ?></span>
                                <span class="text-[9px] font-black uppercase text-gray-400 tracking-tighter"><?php echo date('d M', strtotime($act['fecha'])); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="pt-4 mt-auto border-t border-gray-50 dark:border-gray-800 text-center">
                        <a href="admin.php?tab=mensajes" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-brand-cyan transition-colors">Ver historial completo</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<!-- TAB PROYECTOS -->
<div id="tab-proyectos" class="p-6 lg:p-10 space-y-8 animate-fade-in <?php echo $current_tab === 'proyectos' ? 'block' : 'hidden'; ?>">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Proyectos <span class="text-brand-lime">.</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Gestiona tu portafolio de casos de éxito.</p>
        </div>
        <a href="admin_proyecto_form.php" class="flex items-center gap-2 px-6 py-3 bg-brand-cyan text-gray-900 font-bold rounded-xl shadow-lg shadow-brand-cyan/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-sm font-sans">
            <i data-lucide="plus" class="w-4 h-4"></i> Nuevo Proyecto
        </a>
    </div>

    <!-- Buscador de Proyectos -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-3">
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i> Vista de Portafolio
            </h3>
            <?php if(!empty($p_search)): ?>
                <a href="?tab=proyectos&p_search=" class="text-[10px] font-bold text-gray-400 hover:text-red-500 transition-colors uppercase tracking-widest ml-2">
                    Limpiar Búsqueda
                </a>
            <?php endif; ?>
        </div>
        
        <form method="GET" class="relative group min-w-[300px]">
            <input type="hidden" name="tab" value="proyectos">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 group-focus-within:text-brand-cyan transition-colors"></i>
            <input type="text" name="p_search" value="<?php echo htmlspecialchars($p_search); ?>" placeholder="Buscar proyecto por nombre..." class="w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl py-2.5 pl-11 pr-4 text-xs font-medium focus:outline-none focus:border-brand-cyan/50 focus:ring-4 focus:ring-brand-cyan/5 transition-all md:min-w-[320px]">
        </form>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left min-w-[700px]">
                <tr class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Proyecto</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Acciones</th>
                </tr>
                <?php if(empty($proyectos)): ?>
                <tr>
                    <td colspan="2" class="px-8 py-10 text-center text-gray-500 font-medium">No se encontraron proyectos con ese nombre.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($proyectos as $p): ?>
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-all group border-b border-gray-50 dark:border-gray-800 last:border-0">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center font-black text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 group-hover:border-brand-cyan transition-all"><?php echo $p['inicial_logo']; ?></div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white"><?php echo $p['nombre']; ?></div>
                                    <div class="text-xs text-gray-500 font-medium truncate max-w-[200px]"><?php echo $p['tagline']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="admin_proyecto_form.php?id=<?php echo $p['db_id']; ?>" class="p-2.5 text-gray-400 hover:text-brand-cyan hover:bg-brand-cyan/10 rounded-xl transition-all"><i data-lucide="edit-3" class="w-5 h-5"></i></a>
                                <button onclick="deleteItem('project', <?php echo $p['db_id']; ?>)" class="p-2.5 text-gray-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>

        <!-- Pagination Proyectos -->
        <?php if($p_total_pages > 1): ?>
        <div class="px-8 py-6 bg-gray-50/30 dark:bg-gray-800/20 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="text-xs text-gray-500 font-medium tracking-tight">
                Mostrando página <span class="text-gray-900 dark:text-white font-bold"><?php echo $p_current_page; ?></span> de <span class="text-gray-900 dark:text-white font-bold"><?php echo $p_total_pages; ?></span>
            </div>

            <div class="flex items-center gap-2">
                <!-- Anterior -->
                <?php if($p_current_page > 1): ?>
                    <a href="?tab=proyectos&p_p=<?php echo $p_current_page - 1; ?>&p_search=<?php echo urlencode($p_search); ?>" class="p-2.5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-xl hover:border-brand-cyan hover:text-brand-cyan transition-all">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </a>
                <?php else: ?>
                    <div class="p-2.5 bg-white/50 dark:bg-gray-800/50 border border-gray-50 dark:border-gray-800 text-gray-300 dark:text-gray-600 rounded-xl cursor-not-allowed">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </div>
                <?php endif; ?>

                <div class="flex items-center gap-1">
                    <?php 
                    $p_start = max(1, $p_current_page - 2);
                    $p_end = min($p_total_pages, $p_current_page + 2);
                    for($i = $p_start; $i <= $p_end; $i++): ?>
                        <a href="?tab=proyectos&p_p=<?php echo $i; ?>&p_search=<?php echo urlencode($p_search); ?>" class="w-10 h-10 flex items-center justify-center rounded-xl text-xs font-bold transition-all <?php echo $i === $p_current_page ? 'bg-brand-cyan text-gray-900 shadow-md shadow-brand-cyan/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-brand-cyan/30'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>

                <!-- Siguiente -->
                <?php if($p_current_page < $p_total_pages): ?>
                    <a href="?tab=proyectos&p_p=<?php echo $p_current_page + 1; ?>&p_search=<?php echo urlencode($p_search); ?>" class="p-2.5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-xl hover:border-brand-cyan hover:text-brand-cyan transition-all">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </a>
                <?php else: ?>
                    <div class="p-2.5 bg-white/50 dark:bg-gray-800/50 border border-gray-50 dark:border-gray-800 text-gray-300 dark:text-gray-600 rounded-xl cursor-not-allowed">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- TAB CLIENTES -->
<div id="tab-clientes" class="p-6 lg:p-10 space-y-8 animate-fade-in <?php echo $current_tab === 'clientes' ? 'block' : 'hidden'; ?> w-full max-w-full">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Clientes <span class="text-brand-lime">.</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Gestiona tus alianzas estratégicas.</p>
        </div>
        <a href="admin_cliente_form.php" class="flex items-center gap-2 px-6 py-3 bg-brand-lime text-gray-900 font-bold rounded-xl shadow-lg shadow-brand-lime/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-sm font-sans">
            <i data-lucide="plus" class="w-4 h-4"></i> Nuevo Cliente
        </a>
    </div>

    <!-- Vista Previa del Carrusel -->
    <div class="bg-gray-50/50 dark:bg-gray-800/30 rounded-[2.5rem] p-6 md:p-8 border border-gray-100 dark:border-gray-800 transition-colors duration-300">
        <div class="flex items-center gap-2 mb-6">
            <span class="w-2 h-2 rounded-full bg-brand-lime animate-pulse"></span>
            <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Vista Previa en Vivo</h3>
        </div>
        <div class="relative flex overflow-hidden rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 group h-24 items-center mask-fade w-full">
            <div class="py-2 animate-marquee whitespace-nowrap flex items-center gap-12 pr-12 opacity-40 grayscale group-hover:grayscale-0 transition-all duration-700">
                <?php foreach ($clientes as $c): ?>
                    <span class="text-xl font-black text-gray-900 dark:text-white tracking-tighter flex items-center gap-3">
                        <i data-lucide="<?php echo $c['icono']; ?>" class="w-6 h-6 text-brand-lime"></i> <?php echo $c['nombre']; ?>
                    </span>
                <?php endforeach; ?>
                <?php foreach ($clientes as $c): ?>
                    <span class="text-xl font-black text-gray-900 dark:text-white tracking-tighter flex items-center gap-3">
                        <i data-lucide="<?php echo $c['icono']; ?>" class="w-6 h-6 text-brand-lime"></i> <?php echo $c['nombre']; ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-x-auto custom-scrollbar">
        <table class="w-full text-left min-w-[600px]">
            <tr class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Empresa</th>
                <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Icono</th>
                <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Acciones</th>
            </tr>
            <?php foreach ($clientes as $c): ?>
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-all group border-b border-gray-50 dark:border-gray-800 last:border-0">
                <td class="px-8 py-6 font-bold text-gray-900 dark:text-white"><?php echo $c['nombre']; ?></td>
                <td class="px-8 py-6"><i data-lucide="<?php echo $c['icono']; ?>" class="w-6 h-6 text-brand-cyan"></i></td>
                <td class="px-8 py-6 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="admin_cliente_form.php?id=<?php echo $c['id']; ?>" class="p-2.5 text-gray-400 hover:text-brand-lime hover:bg-brand-lime/10 rounded-xl transition-all"><i data-lucide="edit-3" class="w-5 h-5"></i></a>
                        <button onclick="deleteItem('client', <?php echo $c['id']; ?>)" class="p-2.5 text-gray-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<!-- TAB MENSAJES -->
<div id="tab-mensajes" class="p-6 lg:p-10 space-y-8 animate-fade-in <?php echo $current_tab === 'mensajes' ? 'block' : 'hidden'; ?> w-full max-w-full">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Mensajes <span class="text-brand-cyan">.</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Bandeja de prospectos y leads desde la Landing Page.</p>
        </div>
        <a href="admin_enviar_plantilla.php" class="flex items-center gap-2 px-6 py-3 bg-brand-cyan text-gray-900 font-bold rounded-2xl shadow-lg shadow-brand-cyan/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-sm">
            <i data-lucide="send" class="w-4 h-4"></i>
            <span>Enviar Correo</span>
        </a>
    </div>
    
    <!-- Filtros de Mensajes -->
    <div class="flex flex-wrap items-center gap-3">
        <a href="?tab=mensajes&status=all" class="px-5 py-2 rounded-xl text-xs font-bold transition-all <?php echo $filter_status === 'all' ? 'bg-brand-cyan text-gray-900 shadow-lg shadow-brand-cyan/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-brand-cyan/30'; ?>">
            Todos
        </a>
        <a href="?tab=mensajes&status=nuevo" class="px-5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 <?php echo $filter_status === 'nuevo' ? 'bg-brand-cyan text-gray-900 shadow-lg shadow-brand-cyan/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-brand-cyan/30'; ?>">
            <span class="w-2 h-2 rounded-full bg-brand-cyan <?php echo $filter_status === 'nuevo' ? 'animate-pulse' : ''; ?>"></span>
            No leídos
        </a>
        <a href="?tab=mensajes&status=leido" class="px-5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 <?php echo $filter_status === 'leido' ? 'bg-brand-cyan text-gray-900 shadow-lg shadow-brand-cyan/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-brand-cyan/30'; ?>">
            <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
            Leídos
        </a>
        
        <?php if($filter_status !== 'all'): ?>
            <a href="?tab=mensajes&status=all" class="text-[10px] font-bold text-gray-400 hover:text-red-500 transition-colors uppercase tracking-widest ml-2">
                Limpiar Filtros
            </a>
        <?php endif; ?>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left min-w-[900px]">
                <tr class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest w-16">Status</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Origen</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Contacto</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Mensaje</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Acciones</th>
                </tr>
                <?php if(empty($mensajes)): ?>
                <tr>
                    <td colspan="4" class="px-8 py-10 text-center text-gray-500 font-medium">No hay mensajes en la bandeja de entrada.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($mensajes as $m): ?>
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-all group border-b border-gray-50 dark:border-gray-800 last:border-0 <?php echo $m['estado'] === 'nuevo' ? 'bg-brand-cyan/5 dark:bg-brand-cyan/5 border-l-4 border-l-brand-cyan' : 'opacity-75'; ?>">
                        <td class="px-8 py-6 text-center">
                            <?php if($m['estado'] === 'nuevo'): ?>
                                <span class="relative flex h-3 w-3 mx-auto">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-cyan opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-brand-cyan"></span>
                                </span>
                            <?php else: ?>
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-gray-400 mx-auto"></i>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-6">
                            <?php if($m['tipo'] === 'demo'): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-brand-lime/10 text-brand-lime border border-brand-lime/20">
                                    <i data-lucide="monitor" class="w-3 h-3"></i> Demo
                                </span>
                                <?php if($m['proyecto'] && $m['tipo'] === 'demo'): ?>
                                    <div class="text-[9px] font-black text-gray-400 mt-1 uppercase tracking-tighter">PROYECTO: <?php echo htmlspecialchars($m['proyecto']); ?></div>
                                <?php endif; ?>
                            <?php elseif($m['tipo'] === 'plantilla'): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-500/10 text-indigo-500 border border-indigo-500/20">
                                    <i data-lucide="send" class="w-3 h-3"></i> Saliente
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-brand-cyan/10 text-brand-cyan border border-brand-cyan/20">
                                    <i data-lucide="mail" class="w-3 h-3"></i> Contacto
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-6">
                            <div class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <?php echo htmlspecialchars($m['nombre']); ?>
                            </div>
                            <div class="text-xs text-gray-500 font-medium mt-1 flex flex-col gap-0.5">
                                <a href="mailto:<?php echo htmlspecialchars($m['email']); ?>" class="hover:text-brand-cyan transition-colors flex items-center gap-1"><i data-lucide="mail" class="w-3 h-3"></i> <?php echo htmlspecialchars($m['email']); ?></a>
                                <a href="tel:<?php echo htmlspecialchars($m['celular']); ?>" class="hover:text-brand-cyan transition-colors flex items-center gap-1"><i data-lucide="phone" class="w-3 h-3"></i> <?php echo htmlspecialchars($m['celular']); ?></a>
                            </div>
                            <div class="text-[10px] text-gray-400 font-bold uppercase mt-2">
                                RECIBIDO: <?php echo date('d M Y, h:i A', strtotime($m['fecha_creacion'])); ?>
                                <?php if($m['estado'] === 'leido' && !empty($m['fecha_lectura'])): ?>
                                    <br><span class="text-brand-cyan">LEÍDO: <?php echo date('d M Y, h:i A', strtotime($m['fecha_lectura'])); ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm text-gray-600 dark:text-gray-300 font-medium max-w-lg leading-relaxed"><?php echo nl2br(htmlspecialchars($m['descripcion'])); ?></p>
                        </td>
                        <td class="px-8 py-6 text-right align-top">
                            <div class="flex items-center justify-end gap-2 flex-wrap">
                                <?php if($m['tipo'] === 'demo'): ?>
                                     <?php 
                                    $wpMsg = rawurlencode("Hola {$m['nombre']}, aquí tienes tus credenciales para el demo de {$m['proyecto']}: \n\nLink: \nUsuario: \nContraseña: \n\n¡Quedo a tu disposición si tienes dudas!");
                                    ?>
                                     <?php 
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $m['celular']);
                                    // Si tiene 10 dígitos, asumimos que es México y falta el 52
                                    if (strlen($cleanPhone) === 10) $cleanPhone = '52' . $cleanPhone;
                                    ?>
                                    <a href="https://wa.me/<?php echo $cleanPhone; ?>?text=<?php echo $wpMsg; ?>" target="_blank" class="p-2 text-gray-400 hover:text-green-500 hover:bg-green-500/10 rounded-xl transition-all border border-transparent hover:border-green-500/20" title="Enviar credenciales por WhatsApp">
                                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                                    </a>
                                    <?php if(isset($m['creds_sent']) && $m['creds_sent']): ?>
                                        <button disabled class="p-2 text-green-500 bg-green-500/10 rounded-xl cursor-default" title="Credenciales ya enviadas">
                                            <i data-lucide="check-square" class="w-4 h-4"></i>
                                        </button>
                                    <?php else: ?>
                                        <button onclick="markCredsSent(<?php echo $m['id']; ?>)" class="p-2 text-gray-400 hover:text-brand-lime hover:bg-brand-lime/10 rounded-xl transition-all border border-transparent hover:border-brand-lime/20" title="Marcar credenciales como enviadas">
                                            <i data-lucide="square" class="w-4 h-4"></i>
                                        </button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if(isset($m['lead_id']) && !empty($m['lead_id'])): ?>
                                        <a href="admin_cliente_potencial_form.php?id=<?php echo $m['lead_id']; ?>" class="flex items-center gap-1.5 p-2 px-3 text-[10px] font-bold text-indigo-500 bg-indigo-500/10 rounded-xl hover:bg-indigo-500/20 transition-all uppercase tracking-wider" title="Ver en Clientes Potenciales">
                                            <i data-lucide="user-check" class="w-3.5 h-3.5"></i> Es un Lead
                                        </a>
                                    <?php else: ?>
                                        <button onclick="convertToLead(<?php echo $m['id']; ?>)" class="flex items-center gap-1.5 p-2 px-3 text-[10px] font-bold text-gray-400 hover:text-indigo-500 hover:bg-indigo-500/10 rounded-xl transition-all uppercase tracking-wider border border-gray-200 dark:border-gray-800 hover:border-indigo-500/30" title="Convertir a Cliente Potencial">
                                            <i data-lucide="user-plus" class="w-3.5 h-3.5"></i> Lead
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                 <a href="admin_enviar_plantilla.php?email=<?php echo urlencode($m['email']); ?>" class="p-2 text-gray-400 hover:text-brand-cyan hover:bg-brand-cyan/10 rounded-xl transition-all" title="Responder con plantilla">
                                    <i data-lucide="reply" class="w-4 h-4"></i>
                                </a>

                                <div class="w-px h-6 bg-gray-200 dark:bg-gray-800 mx-1"></div>

                                <?php if($m['estado'] === 'nuevo'): ?>
                                <button onclick="markMsgRead(<?php echo $m['id']; ?>)" class="p-2 text-gray-400 hover:text-brand-cyan hover:bg-brand-cyan/10 rounded-xl transition-all" title="Marcar como leido"><i data-lucide="check" class="w-4 h-4"></i></button>
                                <?php endif; ?>
                                <button onclick="deleteMsg(<?php echo $m['id']; ?>)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all" title="Eliminar mensaje"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
        
        <!-- Paginación de Mensajes -->
        <?php if($total_pages > 1): ?>
        <div class="px-8 py-5 border-t border-gray-50 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-800/20 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                Página <span class="text-brand-cyan"><?php echo $current_page; ?></span> de <?php echo $total_pages; ?>
                <span class="ml-2 text-[10px] opacity-50 font-medium">(<?php echo $total_items; ?> mensajes en total)</span>
            </div>
            
            <div class="flex items-center gap-2">
                <!-- Botón Anterior -->
                <?php if($current_page > 1): ?>
                    <a href="?tab=mensajes&status=<?php echo $filter_status; ?>&p=<?php echo $current_page - 1; ?>" class="p-2.5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-xl hover:border-brand-cyan hover:text-brand-cyan transition-all">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </a>
                <?php else: ?>
                    <div class="p-2.5 bg-white/50 dark:bg-gray-800/50 border border-gray-50 dark:border-gray-800 text-gray-300 dark:text-gray-600 rounded-xl cursor-not-allowed">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </div>
                <?php endif; ?>

                <!-- Números de Página (Limitados para no desbordar) -->
                <div class="flex items-center gap-1">
                    <?php 
                    $start_range = max(1, $current_page - 2);
                    $end_range = min($total_pages, $current_page + 2);
                    
                    for($i = $start_range; $i <= $end_range; $i++): ?>
                        <a href="?tab=mensajes&status=<?php echo $filter_status; ?>&p=<?php echo $i; ?>" class="w-10 h-10 flex items-center justify-center rounded-xl text-xs font-bold transition-all <?php echo $i === $current_page ? 'bg-brand-cyan text-gray-900 shadow-md shadow-brand-cyan/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-brand-cyan/30'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>

                <!-- Botón Siguiente -->
                <?php if($current_page < $total_pages): ?>
                    <a href="?tab=mensajes&status=<?php echo $filter_status; ?>&p=<?php echo $current_page + 1; ?>" class="p-2.5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-xl hover:border-brand-cyan hover:text-brand-cyan transition-all">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </a>
                <?php else: ?>
                    <div class="p-2.5 bg-white/50 dark:bg-gray-800/50 border border-gray-50 dark:border-gray-800 text-gray-300 dark:text-gray-600 rounded-xl cursor-not-allowed">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- TAB CLIENTES POTENCIALES -->
<div id="tab-potenciales" class="p-6 lg:p-10 space-y-8 animate-fade-in <?php echo $current_tab === 'potenciales' ? 'block' : 'hidden'; ?>">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Clientes Potenciales <span class="text-indigo-500">.</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Gestión y seguimiento de prospectos comerciales.</p>
        </div>
        <a href="admin_cliente_potencial_form.php" class="flex items-center gap-2 px-6 py-3 bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-sm font-sans flex-shrink-0">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Nuevo Prospecto
        </a>
    </div>

    <!-- Filtros de Clientes Potenciales -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <!-- Filtros de Clientes Potenciales -->
        <div class="flex flex-wrap items-center gap-3">
            <a href="?tab=potenciales&cp_status=all&search=<?php echo urlencode($cp_search); ?>" class="px-5 py-2 rounded-xl text-xs font-bold transition-all <?php echo $cp_filter_status === 'all' ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-indigo-500/30'; ?>">
                Todos
            </a>
            <a href="?tab=potenciales&cp_status=nuevo&search=<?php echo urlencode($cp_search); ?>" class="px-5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 <?php echo $cp_filter_status === 'nuevo' ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-indigo-500/30'; ?>">
                <span class="w-2 h-2 rounded-full bg-cyan-400 <?php echo $cp_filter_status === 'nuevo' ? 'animate-pulse' : ''; ?>"></span>
                Nuevos
            </a>
            <a href="?tab=potenciales&cp_status=en proceso&search=<?php echo urlencode($cp_search); ?>" class="px-5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 <?php echo $cp_filter_status === 'en proceso' ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-indigo-500/30'; ?>">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                En Proceso
            </a>
            <a href="?tab=potenciales&cp_status=finalizado&search=<?php echo urlencode($cp_search); ?>" class="px-5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 <?php echo $cp_filter_status === 'finalizado' ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-indigo-500/30'; ?>">
                <span class="w-2 h-2 rounded-full bg-lime-400"></span>
                Finalizados
            </a>
            <a href="?tab=potenciales&cp_status=perdido&search=<?php echo urlencode($cp_search); ?>" class="px-5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 <?php echo $cp_filter_status === 'perdido' ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-indigo-500/30'; ?>">
                <span class="w-2 h-2 rounded-full bg-red-400"></span>
                Perdidos
            </a>
            
            <?php if($cp_filter_status !== 'all' || !empty($cp_search)): ?>
                <a href="?tab=potenciales&cp_status=all" class="text-[10px] font-bold text-gray-400 hover:text-red-500 transition-colors uppercase tracking-widest ml-2">
                    Limpiar Búsqueda
                </a>
            <?php endif; ?>
        </div>

        <!-- Buscador por Nombre -->
        <form method="GET" class="relative group min-w-[300px]">
            <input type="hidden" name="tab" value="potenciales">
            <input type="hidden" name="cp_status" value="<?php echo htmlspecialchars($cp_filter_status); ?>">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
            <input type="text" name="search" value="<?php echo htmlspecialchars($cp_search); ?>" placeholder="Buscar por nombre..." class="w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl py-2.5 pl-11 pr-4 text-xs font-medium focus:outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all md:min-w-[320px]">
        </form>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left min-w-[900px]">
                <tr class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest w-16 text-center">Estado</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Contacto</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest w-1/3">Detalles</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Acciones</th>
                </tr>
                <?php if(empty($clientes_potenciales)): ?>
                    <tr><td colspan="4" class="px-8 py-10 text-center text-gray-500 font-medium">No hay prospectos registrados.</td></tr>
                <?php else: ?>
                    <?php foreach ($clientes_potenciales as $cp): 
                        // Colores por estado
                        $badgeClass = '';
                        $iconName = 'circle';
                        switch($cp['estado']) {
                            case 'nuevo': 
                                $badgeClass = 'bg-cyan-100 text-cyan-700 border-cyan-200 dark:bg-cyan-900/30 dark:text-cyan-400 dark:border-cyan-800'; 
                                $iconName = 'sparkles';
                                break;
                            case 'en proceso': 
                                $badgeClass = 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800'; 
                                $iconName = 'clock';
                                break;
                            case 'finalizado': 
                                $badgeClass = 'bg-lime-100 text-lime-700 border-lime-200 dark:bg-lime-900/30 dark:text-lime-500 dark:border-lime-800'; 
                                $iconName = 'check-circle-2';
                                break;
                            case 'perdido': 
                                $badgeClass = 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 flex'; 
                                $iconName = 'x-circle';
                                break;
                        }
                    ?>
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-all group border-b border-gray-50 dark:border-gray-800 last:border-0 <?php echo $cp['estado'] === 'nuevo' ? 'bg-cyan-50/30 dark:bg-cyan-900/5' : ''; ?>">
                        <td class="px-8 py-6 text-center align-top">
                            <span class="inline-flex items-center justify-center p-2 rounded-full border <?php echo $badgeClass; ?> mx-auto" title="<?php echo ucfirst($cp['estado']); ?>">
                                <i data-lucide="<?php echo $iconName; ?>" class="w-4 h-4"></i>
                            </span>
                        </td>
                        <td class="px-8 py-6 align-top">
                            <div class="font-bold text-gray-900 dark:text-white flex items-center gap-2 text-base">
                                <?php echo htmlspecialchars($cp['nombre']); ?>
                            </div>
                            <?php if(!empty($cp['empresa_cargo'])): ?>
                                <div class="text-[11px] font-black tracking-wider uppercase text-indigo-500 dark:text-indigo-400 mt-1 mb-2">
                                    <?php echo htmlspecialchars($cp['empresa_cargo']); ?>
                                </div>
                            <?php else: ?>
                                <div class="mt-2 mb-1"></div> <!-- Espaciador -->
                            <?php endif; ?>
                            
                            <div class="text-xs text-gray-500 font-medium flex flex-col gap-1.5">
                                <a href="mailto:<?php echo htmlspecialchars($cp['email']); ?>" class="hover:text-brand-cyan transition-colors flex items-center gap-1.5"><i data-lucide="mail" class="w-3.5 h-3.5"></i> <?php echo htmlspecialchars($cp['email']); ?></a>
                                <a href="tel:<?php echo htmlspecialchars($cp['telefono']); ?>" class="hover:text-brand-cyan transition-colors flex items-center gap-1.5"><i data-lucide="phone" class="w-3.5 h-3.5"></i> <?php echo htmlspecialchars($cp['telefono']); ?></a>
                            </div>
                            <div class="text-[10px] text-gray-400 font-bold uppercase mt-3">
                                REGISTRO: <?php echo date('d M Y', strtotime($cp['fecha_creacion'])); ?>
                            </div>
                        </td>
                        <td class="px-8 py-6 align-top">
                            <p class="text-sm text-gray-600 dark:text-gray-300 font-medium leading-relaxed"><?php echo nl2br(htmlspecialchars($cp['descripcion'] ?? 'Sin descripción proporcionada.')); ?></p>
                        </td>
                        <td class="px-8 py-6 text-right align-top">
                            <div class="flex items-center justify-end gap-2">
                                <a href="admin_cliente_potencial_form.php?id=<?php echo $cp['id']; ?>" class="p-2.5 text-gray-400 hover:text-indigo-500 hover:bg-indigo-500/10 rounded-xl transition-all" title="Editar prospecto"><i data-lucide="edit-3" class="w-5 h-5"></i></a>
                                <button onclick="deleteItem('potential_client', <?php echo $cp['id']; ?>)" class="p-2.5 text-gray-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all" title="Eliminar prospecto"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>

        <!-- Paginación de Clientes Potenciales -->
        <?php if($cp_total_pages > 1): ?>
        <div class="px-8 py-5 border-t border-gray-50 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-800/20 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                Página <span class="text-indigo-500"><?php echo $cp_current_page; ?></span> de <?php echo $cp_total_pages; ?>
                <span class="ml-2 text-[10px] opacity-50 font-medium">(<?php echo $cp_total_items; ?> prospectos)</span>
            </div>
            
            <div class="flex items-center gap-2">
                <!-- Anterior -->
                <?php if($cp_current_page > 1): ?>
                    <a href="?tab=potenciales&cp_status=<?php echo $cp_filter_status; ?>&cp_p=<?php echo $cp_current_page - 1; ?>&search=<?php echo urlencode($cp_search); ?>" class="p-2.5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-xl hover:border-indigo-500 hover:text-indigo-500 transition-all">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </a>
                <?php else: ?>
                    <div class="p-2.5 bg-white/50 dark:bg-gray-800/50 border border-gray-50 dark:border-gray-800 text-gray-300 dark:text-gray-600 rounded-xl cursor-not-allowed">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </div>
                <?php endif; ?>

                <div class="flex items-center gap-1">
                    <?php 
                    $cp_start = max(1, $cp_current_page - 2);
                    $cp_end = min($cp_total_pages, $cp_current_page + 2);
                    for($i = $cp_start; $i <= $cp_end; $i++): ?>
                        <a href="?tab=potenciales&cp_status=<?php echo $cp_filter_status; ?>&cp_p=<?php echo $i; ?>&search=<?php echo urlencode($cp_search); ?>" class="w-10 h-10 flex items-center justify-center rounded-xl text-xs font-bold transition-all <?php echo $i === $cp_current_page ? 'bg-indigo-500 text-white shadow-md shadow-indigo-500/20' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-indigo-500/30'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>

                <!-- Siguiente -->
                <?php if($cp_current_page < $cp_total_pages): ?>
                    <a href="?tab=potenciales&cp_status=<?php echo $cp_filter_status; ?>&cp_p=<?php echo $cp_current_page + 1; ?>&search=<?php echo urlencode($cp_search); ?>" class="p-2.5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-xl hover:border-indigo-500 hover:text-indigo-500 transition-all">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </a>
                <?php else: ?>
                    <div class="p-2.5 bg-white/50 dark:bg-gray-800/50 border border-gray-50 dark:border-gray-800 text-gray-300 dark:text-gray-600 rounded-xl cursor-not-allowed">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- TAB CONFIGURACIÓN -->
<div id="tab-configuracion" class="p-6 lg:p-10 space-y-8 animate-fade-in <?php echo $current_tab === 'configuracion' ? 'block' : 'hidden'; ?>">
    <div>
        <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Configuración <span class="text-brand-cyan">.</span></h2>
        <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Ajustes generales del sistema.</p>
    </div>
    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 p-8">
        <div class="flex items-center justify-between py-4 border-b border-gray-100 dark:border-gray-800">
            <div>
                <h3 class="font-bold text-gray-900 dark:text-white">Sección de Premios</h3>
                <p class="text-sm text-gray-500">Activar o desactivar la visualización de premios en el sitio web.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" data-clave="show_awards" class="sr-only peer config-switch" <?php echo ($ajustes['show_awards'] ?? '0') === '1' ? 'checked' : ''; ?>>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-cyan"></div>
            </label>
        </div>

        <div class="mt-8 pt-4 border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-brand-cyan/10 flex items-center justify-center text-brand-cyan">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg">Seguridad de la Cuenta</h3>
                    <p class="text-sm text-gray-500">Actualiza tus credenciales de acceso periódicamente.</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4">
                <button onclick="openModal('modal-change-password')" class="flex items-center gap-3 px-8 py-4 bg-gray-900 dark:bg-brand-cyan dark:text-gray-900 text-white font-black rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-gray-900/10 dark:shadow-brand-cyan/20 text-sm uppercase tracking-widest group">
                    <i data-lucide="shield-check" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
                    Cambiar Contraseña
                </button>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest max-w-[200px] leading-relaxed">Última actualización recomendada: Cada 90 días.</p>
            </div>
        </div>
    </div>
</div>

<!-- TAB PLANTILLAS -->
<div id="tab-plantillas" class="p-6 lg:p-10 space-y-8 animate-fade-in <?php echo $current_tab === 'plantillas' ? 'block' : 'hidden'; ?>">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Plantillas de Correo <span class="text-brand-lime">.</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Gestiona los cuerpos de mensaje predefinidos para tus clientes.</p>
        </div>
        <a href="admin_plantilla_form.php" class="flex items-center gap-2 px-6 py-3 bg-brand-lime text-gray-900 font-bold rounded-2xl shadow-lg shadow-brand-lime/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Nueva Plantilla</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if(empty($plantillas)): ?>
            <div class="col-span-full py-20 text-center bg-white dark:bg-gray-900 rounded-[2.5rem] border border-dashed border-gray-300 dark:border-gray-700">
                <i data-lucide="layout-template" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                <p class="text-gray-500 font-bold uppercase tracking-widest text-xs">No hay plantillas creadas</p>
            </div>
        <?php else: ?>
            <?php foreach($plantillas as $p): ?>
                <div class="bg-white dark:bg-gray-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 p-6 hover:shadow-xl transition-all group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="admin_plantilla_form.php?id=<?php echo $p['id']; ?>" class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg text-gray-500 hover:text-brand-cyan transition-colors">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </a>
                        <button onclick="deleteItem('template', <?php echo $p['id']; ?>)" class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg text-gray-500 hover:text-red-500 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-brand-lime/10 flex items-center justify-center text-brand-lime">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white"><?php echo htmlspecialchars($p['titulo']); ?></h4>
                    </div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Asunto:</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 font-medium line-clamp-1 mb-4"><?php echo htmlspecialchars($p['asunto']); ?></p>
                    <div class="p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                        <p class="text-[11px] text-gray-400 font-medium line-clamp-3 leading-relaxed italic"><?php echo strip_tags($p['cuerpo']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>



<!-- MODAL ENVIAR CORREO -->
<div id="modal-send-mail" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-gray-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] w-full max-w-2xl overflow-hidden shadow-2xl scale-95 transition-all duration-300 border border-gray-100 dark:border-gray-800">
        <div class="p-8 md:p-10">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white">Enviar Plantilla <span class="text-brand-cyan">.</span></h3>
                    <p class="text-sm text-gray-500 mt-1">Personaliza y envía comunicaciones profesionales.</p>
                </div>
                <button onclick="closeModal('modal-send-mail')" class="p-2 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="form-send-mail" class="space-y-6">
                <input type="hidden" name="action" value="send_template_email">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Destinatario (Email)</label>
                        <input type="email" name="email" id="mail-destinatario" required class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-cyan outline-none transition-all dark:text-white" placeholder="cliente@ejemplo.com">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Seleccionar Plantilla</label>
                        <select name="template_id" id="mail-template-selector" onchange="updateMailPreview()" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-cyan outline-none transition-all cursor-pointer dark:text-white">
                            <option value="">-- Elige una plantilla --</option>
                            <?php foreach($plantillas as $p): ?>
                                <option value="<?php echo $p['id']; ?>" data-body='<?php echo json_encode($p['cuerpo']); ?>'><?php echo htmlspecialchars($p['titulo']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Cuerpo del Mensaje (Base)</label>
                    <div id="mail-preview" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 text-sm text-gray-500 min-h-[150px] whitespace-pre-wrap italic">
                        Selecciona una plantilla para ver la base del mensaje...
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Contenido Adicional / Personalizado</label>
                    <textarea name="mensaje_libre" rows="4" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-cyan outline-none transition-all dark:text-white" placeholder="Agrega detalles específicos para este cliente..."></textarea>
                </div>

                <button type="submit" class="w-full py-4 bg-brand-cyan text-gray-900 font-black rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-brand-cyan/20 text-sm uppercase tracking-widest">
                    Enviar Propuesta Ahora
                </button>
            </form>
        </div>
    </div>
</div>

<!-- MODAL CAMBIAR CONTRASEÑA -->
<div id="modal-change-password" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-gray-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] w-full max-w-lg overflow-hidden shadow-2xl scale-95 transition-all duration-300 border border-gray-100 dark:border-gray-800">
        <div class="p-8 md:p-10">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                         <div class="w-8 h-8 rounded-lg bg-brand-cyan/10 flex items-center justify-center text-brand-cyan">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white">Seguridad <span class="text-brand-cyan">.</span></h3>
                    </div>
                    <p class="text-sm text-gray-500">Actualiza tus credenciales de acceso.</p>
                </div>
                <button onclick="closeModal('modal-change-password')" class="p-2 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="form-change-password" onsubmit="changePasswordAjax(event)" class="space-y-6">
                <input type="hidden" name="action" value="change_password">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Contraseña Actual</label>
                    <input type="password" name="current_password" required class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-brand-cyan outline-none transition-all dark:text-white" placeholder="••••••••">
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nueva Contraseña</label>
                        <input type="password" name="new_password" required class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-brand-cyan outline-none transition-all dark:text-white" placeholder="Min. 6 caracteres">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Confirmar Nueva Contraseña</label>
                        <input type="password" name="confirm_password" required class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-brand-cyan outline-none transition-all dark:text-white" placeholder="Repite la contraseña">
                    </div>
                </div>
                <button type="submit" class="w-full py-4 bg-gray-900 dark:bg-brand-cyan dark:text-gray-900 text-white font-black rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-gray-900/10 dark:shadow-brand-cyan/20 text-sm uppercase tracking-widest">
                    Confirmar Cambio
           
    <script>
        /**
         * 1. NAVEGACIÓN Y UI GLOBAL
         */
        const currentTab = "<?php echo $current_tab; ?>";
        const navEl = document.getElementById('nav-' + currentTab);
        if (navEl) {
            navEl.classList.remove('text-gray-500', 'dark:text-gray-400');
            navEl.classList.add('bg-brand-cyan/10', 'text-brand-cyan', 'border-brand-cyan/20');
        }

        if (typeof lucide !== 'undefined') lucide.createIcons();

        /**
         * 2. MODALES
         */
        function openModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.querySelector('.bg-white, .bg-gray-900').classList.replace('scale-95', 'scale-100');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.querySelector('.bg-white, .bg-gray-900').classList.replace('scale-100', 'scale-95');
        }

        /**
         * 3. CONFIGURACIÓN Y AJUSTES
         */
        document.querySelectorAll('.config-switch').forEach(checkbox => {
            checkbox.addEventListener('change', async function() {
                const clave = this.dataset.clave;
                const valor = this.checked ? '1' : '0';
                this.disabled = true;
                
                const formData = new FormData();
                formData.append('action', 'update_ajuste');
                formData.append('clave', clave);
                formData.append('valor', valor);
                
                try {
                    const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
                    const result = await response.json();
                    if (result.success) {
                        window.showToast('Configuración actualizada correctamente', 'settings');
                    } else {
                        alert('Error al guardar: ' + result.message);
                        this.checked = !this.checked;
                    }
                } catch (error) {
                    alert('Error de conexión');
                    this.checked = !this.checked;
                } finally {
                    this.disabled = false;
                }
            });
        });

        // Cambio de Contraseña Asíncrono
        async function changePasswordAjax(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const newPass = formData.get('new_password');
            const confirmPass = formData.get('confirm_password');
            
            if (newPass !== confirmPass) {
                alert('La nueva contraseña y la confirmación no coinciden.');
                return;
            }
            if (newPass.length < 6) {
                alert('La nueva contraseña debe tener al menos 6 caracteres.');
                return;
            }

            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerText;
            btn.innerText = 'PROCESANDO...';
            btn.disabled = true;

            try {
                const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) {
                    window.showToast('Contraseña actualizada correctamente', 'lock');
                    form.reset();
                    closeModal('modal-change-password');
                } else alert('Error: ' + result.message);
            } catch (error) { alert('Error de conexión'); }
            finally { btn.innerText = originalText; btn.disabled = false; }
        }

        /**
         * 4. GESTIÓN DE CONTENIDO (ELIMINACIÓN)
         */
        async function deleteItem(type, id) {
            if (!confirm('¿Estás seguro de que deseas eliminar este elemento?')) return;
            const formData = new FormData();
            let actionMsg = '';
            if (type === 'project') {
                formData.append('action', 'delete_project');
                actionMsg = 'proyecto_eliminado';
            } else if (type === 'potential_client') {
                formData.append('action', 'delete_potential_client');
                actionMsg = 'cliente_potencial_eliminado';
            } else if (type === 'template') {
                formData.append('action', 'delete_template');
                actionMsg = 'plantilla_eliminada';
            } else {
                formData.append('action', 'delete_client');
                actionMsg = 'cliente_eliminado';
            }
            formData.append('id', id);
            try {
                const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) {
                    const finalMsg = (type === 'potential_client') ? 'cliente_eliminado' : actionMsg;
                    window.location.href = `admin.php?tab=<?php echo $current_tab; ?>&msg=${finalMsg}`;
                } else alert('Error: ' + result.message);
            } catch (error) { alert('Error de conexión'); }
        }

        /**
         * 5. CRM Y MENSAJERÍA
         */
        const formTemplate = document.getElementById('form-template');
        if (formTemplate) {
            formTemplate.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(formTemplate);
                try {
                    const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
                    const result = await response.json();
                    if (result.success) window.location.href = 'admin.php?tab=plantillas&msg=plantilla_guardada';
                    else alert('Error: ' + result.message);
                } catch (error) { alert('Error de conexión'); }
            });
        }

        async function markMsgRead(id) {
            const formData = new FormData();
            formData.append('action', 'read_message');
            formData.append('id', id);
            try {
                const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) window.location.href = `admin.php?tab=mensajes&msg=mensaje_leido`;
                else alert('Error: ' + result.message);
            } catch (error) { alert('Error de conexión'); }
        }

        async function deleteMsg(id) {
            if (!confirm('¿Borrar permanentemente este mensaje?')) return;
            const formData = new FormData();
            formData.append('action', 'delete_message');
            formData.append('id', id);
            try {
                const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) window.location.href = `admin.php?tab=mensajes&msg=mensaje_eliminado`;
                else alert('Error: ' + result.message);
            } catch (error) { alert('Error de conexión'); }
        }

        async function markCredsSent(id) {
            if (!confirm('¿Marcar como credenciales enviadas?')) return;
            const formData = new FormData();
            formData.append('action', 'mark_creds_sent');
            formData.append('id', id);
            try {
                const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) window.location.href = `admin.php?tab=mensajes&msg=creds_enviadas`;
                else alert('Error: ' + result.message);
            } catch (error) { alert('Error de conexión'); }
        }

        async function convertToLead(id) {
            if (!confirm('¿Convertir este mensaje de contacto en un nuevo Cliente Potencial?')) return;
            const formData = new FormData();
            formData.append('action', 'convert_message_to_lead');
            formData.append('id', id);
            try {
                const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) window.location.href = `admin.php?tab=mensajes&msg=lead_convertido`;
                else alert('Error: ' + result.message);
            } catch (error) { alert('Error de conexión'); }
        }
    </script>

    </div> <!-- Close content-container -->
    </main> <!-- Close main -->
</div> <!-- Close flex min-h-screen -->

</body>
</html>
