<?php 
include '../models/proyectos.php'; 
include '../models/clientes.php'; 
include '../models/mensajes.php'; 

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
}

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
?>

<!-- TAB DASHBOARD -->
<div id="tab-dashboard" class="p-6 lg:p-10 space-y-8 animate-fade-in <?php echo $current_tab === 'dashboard' ? 'block' : 'hidden'; ?>">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Panel de Control <span class="text-brand-cyan">.</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Gestión integral de la infraestructura digital.</p>
        </div>
    </div>
    <!-- Bento Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all hover:shadow-xl group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-brand-cyan/10 rounded-2xl group-hover:bg-brand-cyan/20">
                    <i data-lucide="briefcase" class="text-brand-cyan w-6 h-6"></i>
                </div>
                <span class="text-[10px] font-bold text-brand-lime bg-brand-lime/10 px-2 py-1 rounded-full">+12%</span>
            </div>
            <div class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter"><?php echo count($proyectos); ?></div>
            <div class="text-sm font-semibold text-gray-500 mt-1 uppercase tracking-widest text-[10px]">Proyectos</div>
        </div>
        <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all hover:shadow-xl group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-brand-lime/10 rounded-2xl group-hover:bg-brand-lime/20">
                    <i data-lucide="users" class="text-brand-lime w-6 h-6"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter"><?php echo count($clientes); ?></div>
            <div class="text-sm font-semibold text-gray-500 mt-1 uppercase tracking-widest text-[10px]">Clientes</div>
        </div>
        <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all hover:shadow-xl group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-brand-cyan/10 rounded-2xl group-hover:bg-brand-cyan/20">
                    <i data-lucide="activity" class="text-brand-cyan w-6 h-6"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">99.9%</div>
            <div class="text-sm font-semibold text-gray-500 mt-1 uppercase tracking-widest text-[10px]">Uptime AI</div>
        </div>
        <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all hover:shadow-xl group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-brand-cyan/10 rounded-2xl group-hover:bg-brand-cyan/20">
                    <i data-lucide="message-circle" class="text-brand-cyan w-6 h-6"></i>
                </div>
            </div>
            <div class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">158</div>
            <div class="text-sm font-semibold text-gray-500 mt-1 uppercase tracking-widest text-[10px]">Mensajes</div>
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

    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left min-w-[700px]">
                <tr class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Proyecto</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Acciones</th>
                </tr>
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
            </table>
        </div>
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
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left min-w-[900px]">
                <tr class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest w-16">Status</th>
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
                            <div class="flex items-center justify-end gap-2">
                                <?php if($m['estado'] === 'nuevo'): ?>
                                <button onclick="markMsgRead(<?php echo $m['id']; ?>)" class="p-2.5 text-gray-400 hover:text-brand-cyan hover:bg-brand-cyan/10 rounded-xl transition-all" title="Marcar como leido"><i data-lucide="check" class="w-5 h-5"></i></button>
                                <?php endif; ?>
                                <button onclick="deleteMsg(<?php echo $m['id']; ?>)" class="p-2.5 text-gray-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all" title="Eliminar mensaje"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

</div> <!-- Close content-container from sidebar include -->
</main>
</div> <!-- Close flex from sidebar include -->

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Marcar navegación activa
        const currentTab = '<?php echo $current_tab; ?>';
        const navItem = document.getElementById('nav-' + currentTab);
        if (navItem) {
            navItem.classList.add('bg-brand-cyan/10', 'text-brand-cyan', 'border-brand-cyan/20');
            navItem.classList.remove('text-gray-500', 'dark:text-gray-400');
            if (currentTab === 'clientes') navItem.classList.replace('text-brand-cyan', 'text-brand-lime');
        }
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });

    async function deleteItem(type, id) {
        if (!confirm('¿Estás seguro de que deseas eliminar este elemento?')) return;
        
        const formData = new FormData();
        formData.append('action', type === 'project' ? 'delete_project' : 'delete_client');
        formData.append('id', id);

        try {
            const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
            const result = await response.json();
            if (result.success) {
                const msg = type === 'project' ? 'proyecto_eliminado' : 'cliente_eliminado';
                window.location.href = `admin.php?tab=<?php echo $current_tab; ?>&msg=${msg}`;
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error(error);
            alert('Error de conexión');
        }
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
        } catch (error) {
            alert('Error de conexión');
        }
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
        } catch (error) {
            alert('Error de conexión');
        }
    }
</script>

</body>
</html>
