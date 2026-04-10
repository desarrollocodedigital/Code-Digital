<?php 
/**
 * Admin Sidebar & Top Nav
 */
?>
<!-- DASHBOARD CONTAINER -->
<div class="flex min-h-screen">
    <!-- SIDEBAR (Desktop Only) -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-gray-900 border-r border-gray-100 dark:border-gray-800 transition-all duration-300">
        <div class="h-full flex flex-col p-6">
            <!-- Branding -->
            <div class="flex items-center gap-2 mb-10 px-2 cursor-pointer" onclick="window.location.href='admin.php'">
                <svg width="32" height="32" viewBox="0 0 100 100">
                    <path d="M 35 25 L 15 50 L 35 75" fill="none" stroke="currentColor" class="text-gray-900 dark:text-white" stroke-width="12" stroke-linecap="square" />
                    <path d="M 58 15 L 42 85" fill="none" stroke="#00E5FF" stroke-width="12" stroke-linecap="square" />
                    <path d="M 65 25 L 85 50 L 65 75" fill="none" stroke="#B2FF05" stroke-width="12" stroke-linecap="square" />
                </svg>
                <span class="text-2xl font-bold tracking-tighter text-gray-900 dark:text-white flex items-center">
                    <span class="font-medium mr-0.5">Admin</span><span class="text-brand-lime">Panel</span>
                </span>
            </div>

            <!-- Navigation -->
            <?php 
                // Asegurar que el contador de mensajes esté disponible en todas las vistas
                if (!isset($unread_count)) {
                    try {
                        $stmt_sidebar_count = $pdo->query("SELECT COUNT(*) as unread FROM mensajes WHERE estado = 'nuevo'");
                        $unread_count = $stmt_sidebar_count->fetch()['unread'];
                    } catch (Exception $e) {
                        $unread_count = 0;
                    }
                }
                $tab_activa = $current_tab ?? ($_GET['tab'] ?? 'dashboard'); 
            ?>
            <nav class="flex-1 space-y-2">
                <?php 
                $nav_items = [
                    ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
                    ['id' => 'proyectos', 'label' => 'Proyectos', 'icon' => 'briefcase'],
                    ['id' => 'clientes', 'label' => 'Clientes', 'icon' => 'users'],
                    ['id' => 'mensajes', 'label' => 'Mensajes', 'icon' => 'mail', 'badge' => true],
                    ['id' => 'potenciales', 'label' => 'C. Potenciales', 'icon' => 'user-plus'],
                    ['id' => 'metricas', 'label' => 'Métricas', 'icon' => 'bar-chart-3'],
                    ['id' => 'plantillas', 'label' => 'Plantillas', 'icon' => 'layout-template'],
                    ['id' => 'configuracion', 'label' => 'Configuración', 'icon' => 'settings'],
                ];

                foreach ($nav_items as $item): 
                    $isActive = ($tab_activa === $item['id']);
                    $activeClasses = $isActive ? 'bg-brand-cyan/10 text-brand-cyan border-brand-cyan/20' : 'text-gray-500 dark:text-gray-400 border-transparent hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white';
                ?>
                    <a href="admin.php?tab=<?php echo $item['id']; ?>" id="nav-<?php echo $item['id']; ?>" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-2xl border font-semibold group transition-all <?php echo $activeClasses; ?>">
                        <div class="flex items-center gap-3">
                            <i data-lucide="<?php echo $item['icon']; ?>" class="w-5 h-5"></i>
                            <span><?php echo $item['label']; ?></span>
                        </div>
                        <?php if(isset($item['badge']) && $item['badge'] && isset($unread_count) && $unread_count > 0): ?>
                             <span class="bg-brand-cyan text-gray-900 text-[10px] font-black px-2 py-0.5 rounded-full"><?php echo $unread_count; ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <!-- Footer Sidebar -->
            <div class="mt-auto pt-6 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between px-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-cyan to-brand-lime flex items-center justify-center font-bold text-gray-900 uppercase text-xs">S</div>
                    <div>
                        <div class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-widest">Super Admin</div>
                    </div>
                </div>
                <a href="../api/auth_handler.php?action=logout" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all" title="Cerrar Sesión">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 lg:ml-72 min-h-screen flex flex-col transition-all duration-300 w-full max-w-full min-w-0">
        <!-- TOP BAR -->
        <header class="h-20 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 px-6 lg:px-10 flex items-center justify-between sticky top-0 z-40 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <h1 id="page-title" class="text-xl font-bold text-gray-900 dark:text-white"><?php echo $page_title ?? 'Resumen del Sistema'; ?></h1>
            </div>
            <div class="flex items-center gap-4">
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl p-3.5 transition-all">
                    <i id="theme-toggle-dark-icon" data-lucide="moon" class="hidden w-5 h-5"></i>
                    <i id="theme-toggle-light-icon" data-lucide="sun" class="hidden w-5 h-5"></i>
                </button>
            </div>
        </header>

        <!-- CONTENIDO DINÁMICO -->
        <div id="content-container" class="w-full max-w-full flex-1">
