<?php 
require_once '../config/db.php';

$id = $_GET['id'] ?? null;
$client = null;

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM clientes_potenciales WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch();
    
    if (!$client) {
        die("Cliente potencial no encontrado");
    }
}

$page_title = $client ? "Editar Prospecto" : "Nuevo Prospecto";
include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
?>

<div class="p-6 lg:p-10 max-w-4xl mx-auto animate-fade-in w-full">
    <!-- Encabezado con Botón de Regreso -->
    <div class="flex items-center gap-4 mb-8">
        <a href="admin.php?tab=potenciales" class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-500 hover:text-indigo-500 hover:border-indigo-500 transition-all shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white"><?php echo $client ? 'Editar' : 'Nuevo'; ?> Prospecto <span class="text-indigo-500">.</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1 font-medium">Completa la información del lead comercial.</p>
        </div>
    </div>

    <!-- Contenedor Principal Formulario -->
    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden flex flex-col md:flex-row">
        
        <!-- Columna Formulario -->
        <div class="w-full p-8 md:p-10 bg-gray-50/30 dark:bg-gray-900/50">
            <form id="potential-client-form" class="space-y-6">
                <?php if($client): ?>
                    <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
                <?php endif; ?>
                <input type="hidden" name="action" value="save_potential_client">
                
                <h3 class="text-sm font-bold tracking-widest text-gray-400 uppercase mb-4 border-b border-gray-200 dark:border-gray-800 pb-2">Datos de Contacto</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Nombre Completo <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($client['nombre'] ?? ''); ?>" required class="w-full bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-medium" placeholder="Ej. Ana García">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($client['email'] ?? ''); ?>" required class="w-full bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-medium" placeholder="ana@empresa.com">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Teléfono / Celular <span class="text-red-500">*</span></label>
                        <input type="tel" name="telefono" value="<?php echo htmlspecialchars($client['telefono'] ?? ''); ?>" required maxlength="10" minlength="10" pattern="[0-9]{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric" class="w-full bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-medium" placeholder="Ej. 6671234567">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Empresa o Cargo (Opcional)</label>
                        <input type="text" name="empresa_cargo" value="<?php echo htmlspecialchars($client['empresa_cargo'] ?? ''); ?>" class="w-full bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-medium" placeholder="Ej. Director de Marketing / SysCorp">
                    </div>
                </div>

                <h3 class="text-sm font-bold tracking-widest text-gray-400 uppercase mb-4 mt-8 border-b border-gray-200 dark:border-gray-800 pb-2">Seguimiento CRM</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Estado del Lead</label>
                        <div class="relative">
                            <select name="estado" class="w-full appearance-none bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-3 text-sm font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all cursor-pointer">
                                <?php 
                                $estados = ['nuevo' => 'Nuevo', 'en proceso' => 'En Proceso', 'finalizado' => 'Finalizado', 'perdido' => 'Perdido'];
                                foreach ($estados as $val => $label) {
                                    $selected = ($client && $client['estado'] === $val) ? 'selected' : '';
                                    echo "<option value=\"$val\" $selected>$label</option>";
                                }
                                ?>
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Descripción o Necesidad</label>
                    <textarea name="descripcion" rows="4" class="w-full bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-medium resize-none shadow-inner" placeholder="Escribe detalles sobre lo que necesita el cliente..."><?php echo htmlspecialchars($client['descripcion'] ?? ''); ?></textarea>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-800">
                    <a href="admin.php?tab=potenciales" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">Cancelar</a>
                    <button type="submit" id="btn-save" class="flex items-center gap-2 px-8 py-3 bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-sm group">
                        <span id="btn-text">Guardar Prospecto</span>
                        <i id="btn-icon" data-lucide="save" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
</main>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') lucide.createIcons();
    
    // Marcar item en el sidebar
    const navItem = document.getElementById('nav-potenciales');
    if (navItem) {
        navItem.classList.add('bg-brand-cyan/10', 'text-brand-cyan', 'border-brand-cyan/20');
        navItem.classList.remove('text-gray-500', 'dark:text-gray-400');
    }

    const form = document.getElementById('potential-client-form');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btnText = document.getElementById('btn-text');
            const btnIcon = document.getElementById('btn-icon');
            const btnSave = document.getElementById('btn-save');
            
            // Estado de Carga
            const originalText = btnText.innerText;
            const originalIconName = btnIcon.getAttribute('data-lucide');
            btnText.innerText = 'Guardando...';
            btnIcon.setAttribute('data-lucide', 'loader-2');
            btnIcon.classList.add('animate-spin');
            if (typeof lucide !== 'undefined') lucide.createIcons();
            btnSave.disabled = true;
            btnSave.classList.add('opacity-75', 'cursor-not-allowed');

            try {
                const formData = new FormData(form);
                const response = await fetch('../api/admin_actions.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    const isEdit = document.querySelector('input[name="id"]');
                    const msgCode = isEdit ? 'lead_modificado' : 'lead_creado';
                    window.location.href = `admin.php?tab=potenciales&msg=${msgCode}`;
                } else {
                    alert('Error: ' + result.message);
                    resetBtn();
                }
            } catch (error) {
                console.error(error);
                alert('Hubo un error al guardar o verificar los datos del prospecto.');
                resetBtn();
            }
            
            function resetBtn() {
                btnText.innerText = originalText;
                btnIcon.setAttribute('data-lucide', originalIconName);
                btnIcon.classList.remove('animate-spin');
                if (typeof lucide !== 'undefined') lucide.createIcons();
                btnSave.disabled = false;
                btnSave.classList.remove('opacity-75', 'cursor-not-allowed');
            }
        });
    }
});
</script>
</body>
</html>
