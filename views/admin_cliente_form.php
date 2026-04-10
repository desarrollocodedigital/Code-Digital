<?php require_once '../includes/auth_guard.php'; ?>
<?php
/**
 * Página de Formulario: Clientes
 */
require_once __DIR__ . '/../config/db.php';

$id = $_GET['id'] ?? null;
$cliente = null;

if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        $cliente = $stmt->fetch();
    } catch (PDOException $e) {
        $error = "Error al cargar el cliente: " . $e->getMessage();
    }
}

$title = ($cliente ? "Editar" : "Nuevo") . " Cliente";
$page_title = $title;
$current_tab = 'clientes';

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
?>

<div class="p-6 lg:p-10 space-y-8 animate-fade-in max-w-2xl mx-auto">
    <div class="flex items-center gap-4 mb-2">
        <a href="admin.php?tab=clientes" class="p-2.5 bg-white dark:bg-gray-900 text-gray-500 hover:text-brand-lime rounded-xl border border-gray-100 dark:border-gray-800 transition-all shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white"><?php echo $title; ?> <span class="text-brand-lime">.</span></h2>
    </div>

    <?php if (isset($error)): ?>
        <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-2xl flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span class="font-medium"><?php echo $error; ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden">
        <form id="client-form" class="p-8 lg:p-12 space-y-10">
            <input type="hidden" name="id" value="<?php echo $cliente['id'] ?? ''; ?>">
            <input type="hidden" name="action" value="save_client">

            <div class="space-y-4">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="building" class="w-3.5 h-3.5"></i> Nombre de la Empresa
                </label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre'] ?? ''); ?>" placeholder="Ej. Inzunza Transformadores" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-lime rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" required />
                <p class="text-[10px] text-gray-500 font-medium">Este nombre aparecerá en la marquesina principal del sitio.</p>
            </div>

            <div class="space-y-4">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="zap" class="w-3.5 h-3.5"></i> Icono de Marca (Lucide)
                </label>
                <div class="flex gap-4">
                    <input type="text" id="icon-input" name="icono" value="<?php echo htmlspecialchars($cliente['icono'] ?? 'zap'); ?>" placeholder="Ej. shield, zap, star" class="flex-1 bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-lime rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" />
                    <div id="icon-preview" class="w-16 h-16 bg-brand-lime/10 border border-brand-lime/20 rounded-2xl flex items-center justify-center text-brand-lime transition-all">
                        <i data-lucide="<?php echo $cliente['icono'] ?? 'zap'; ?>" class="w-8 h-8"></i>
                    </div>
                </div>
                <p class="text-[10px] text-gray-500 font-medium">Usa nombres de <a href="https://lucide.dev/icons/" target="_blank" class="text-brand-lime hover:underline">Lucide Icons</a>.</p>
            </div>

            <div class="flex items-center justify-end gap-6 pt-6">
                <a href="admin.php?tab=clientes" class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">Cancelar y Volver</a>
                <button type="submit" class="bg-brand-lime text-gray-900 px-10 py-5 rounded-[2rem] font-bold shadow-xl shadow-brand-lime/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-3">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Guardar Marca
                </button>
            </div>
        </form>
    </div>
</div>

</div> <!-- Close content-container from sidebar -->
</main>
</div> <!-- Close flex from sidebar -->

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();

        // Preview de Icono en Tiempo Real
        const iconInput = document.getElementById('icon-input');
        const iconPreview = document.getElementById('icon-preview');
        
        iconInput.addEventListener('input', (e) => {
            const iconName = e.target.value.trim() || 'help-circle';
            iconPreview.innerHTML = `<i data-lucide="${iconName}" class="w-8 h-8"></i>`;
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    });

    const cForm = document.getElementById('client-form');
    cForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(cForm);
        
        try {
            const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
            const result = await response.json();
            if (result.success) {
                const isEdit = formData.get('id') !== '';
                window.location.href = `admin.php?tab=clientes&msg=${isEdit ? 'cliente_modificado' : 'cliente_creado'}`;
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error(error);
            alert('Error de conexión con el servidor');
        }
    });
</script>
</body>
</html>
