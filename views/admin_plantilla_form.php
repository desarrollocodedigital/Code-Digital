<?php
/**
 * Página de Formulario: Plantillas de Correo
 */
require_once __DIR__ . '/../config/db.php';

$id = $_GET['id'] ?? null;
$plantilla = null;

if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM plantillas_email WHERE id = ?");
        $stmt->execute([$id]);
        $plantilla = $stmt->fetch();
    } catch (PDOException $e) {
        $error = "Error al cargar la plantilla: " . $e->getMessage();
    }
}

$title = ($plantilla ? "Editar" : "Nueva") . " Plantilla";
$page_title = $title;

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
?>

<div class="p-6 lg:p-10 space-y-8 animate-fade-in max-w-[1600px] mx-auto">
    <div class="flex items-center justify-between gap-4 mb-2">
        <div class="flex items-center gap-4">
            <a href="admin.php?tab=plantillas" class="p-2.5 bg-white dark:bg-gray-900 text-gray-500 hover:text-brand-cyan rounded-xl border border-gray-100 dark:border-gray-800 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white"><?php echo $title; ?> <span class="text-brand-cyan">.</span></h2>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-brand-cyan/5 rounded-full border border-brand-cyan/10">
            <span class="w-2 h-2 rounded-full bg-brand-cyan animate-pulse"></span>
            <span class="text-[10px] font-black text-brand-cyan uppercase tracking-widest">Editor en Vivo Activo</span>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
        <!-- Columna Editor -->
        <div class="space-y-8">
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden">
                <form id="template-form" class="p-8 lg:p-12 space-y-8">
                    <input type="hidden" name="id" value="<?php echo $plantilla['id'] ?? ''; ?>">
                    <input type="hidden" name="action" value="save_template">

                    <!-- Información Básica -->
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i data-lucide="tag" class="w-3.5 h-3.5"></i> Nombre de la Plantilla (Interno)
                            </label>
                            <input type="text" name="titulo" value="<?php echo htmlspecialchars($plantilla['titulo'] ?? ''); ?>" placeholder="Ej: Bienvenida Clientes Nuevos" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" required />
                        </div>

                        <div class="space-y-3">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i data-lucide="mail" class="w-3.5 h-3.5"></i> Asunto del Correo
                            </label>
                            <input type="text" name="asunto" value="<?php echo htmlspecialchars($plantilla['asunto'] ?? ''); ?>" placeholder="Ej: ¡Bienvenido a Code Digital!" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" required />
                        </div>
                    </div>

                    <!-- Editor HTML -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <i data-lucide="code" class="w-3.5 h-3.5"></i> Cuerpo del Correo (HTML Soportado)
                            </label>
                            <button type="button" onclick="insertVariable('[[CONTENIDO_LIBRE]]')" class="text-[10px] font-black bg-brand-cyan/10 text-brand-cyan hover:bg-brand-cyan hover:text-gray-900 px-3 py-1.5 rounded-lg border border-brand-cyan/20 transition-all flex items-center gap-2">
                                <i data-lucide="plus-circle" class="w-3 h-3"></i> Insertar Contenido Libre
                            </button>
                        </div>
                        <div class="relative group">
                            <textarea id="template-body" name="cuerpo" rows="18" placeholder="Escribe aquí el código de tu plantilla..." class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-[2rem] px-8 py-6 outline-none transition-all resize-none font-mono text-sm leading-relaxed text-gray-900 dark:text-white"><?php echo htmlspecialchars($plantilla['cuerpo'] ?? ''); ?></textarea>
                            <div class="absolute bottom-4 right-8 text-[10px] font-bold text-gray-400 uppercase tracking-widest pointer-events-none group-focus-within:text-brand-cyan transition-colors">
                                Editor HTML Activo
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-end gap-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                        <a href="admin.php?tab=plantillas" class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">Descartar</a>
                        <button type="submit" class="bg-brand-cyan text-gray-900 px-10 py-5 rounded-[2rem] font-bold shadow-xl shadow-brand-cyan/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-3">
                            <i data-lucide="save" class="w-5 h-5"></i>
                            Guardar Plantilla
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna Previsualización -->
        <div class="flex flex-col gap-6">
            <div class="flex items-center gap-2 px-1">
                <i data-lucide="eye" class="text-brand-cyan w-4 h-4"></i>
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Vista Previa en Tiempo Real</h3>
            </div>

            <!-- Preview Container -->
            <div class="flex-1 bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden flex flex-col">
                <!-- Browser Bar Decor -->
                <div class="h-12 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800 flex items-center px-6 gap-3">
                    <div class="flex gap-1.5">
                        <div class="w-2.5 h-2.5 rounded-full bg-red-400/20"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-amber-400/20"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-green-400/20"></div>
                    </div>
                    <div class="flex-1 bg-white dark:bg-gray-900 rounded-lg h-6 flex items-center px-3 text-[10px] text-gray-400 font-mono overflow-hidden whitespace-nowrap opacity-50">
                        preview.codedigital.com/template/<?php echo $plantilla['id'] ?? 'new'; ?>
                    </div>
                </div>

                <!-- Iframe for isolated rendering -->
                <iframe id="preview-frame" class="w-full h-full min-h-[600px] bg-white"></iframe>

                <!-- Helper Footer -->
                <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800">
                    <p class="text-[9px] font-bold text-gray-400 uppercase text-center tracking-widest">
                        Representación visual aproximada del cliente de correo
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</div> <!-- Close content-container from sidebar -->
</main>
</div> <!-- Close flex from sidebar -->

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Marcar navegación activa
        const navPlantillas = document.getElementById('nav-plantillas');
        if (navPlantillas) {
            navPlantillas.classList.add('bg-brand-cyan/10', 'text-brand-cyan', 'border-brand-cyan/20');
            navPlantillas.classList.remove('text-gray-500', 'dark:text-gray-400');
        }

        const templateBody = document.getElementById('template-body');
        const previewFrame = document.getElementById('preview-frame');

        const updatePreview = () => {
            const html = templateBody.value;
            // Usamos un pequeño hack para inyectar estilos base si el usuario no los pone
            const baseStyles = `
                <style>
                    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 20px; white-space: pre-wrap; }
                    .contenido-libre-tag { background: rgba(0, 229, 255, 0.1); border: 1px dashed #00E5FF; padding: 4px 8px; border-radius: 4px; color: #008fa3; font-weight: bold; white-space: nowrap; }
                </style>
            `;
            // Resaltar visualmente la etiqueta de contenido libre en el preview
            const renderedHtml = html.replace(/\[\[CONTENIDO_LIBRE\]\]/g, '<span class="contenido-libre-tag">[[ Aquí irá tu mensaje personalizado ]]</span>');
            
            const doc = previewFrame.contentDocument || previewFrame.contentWindow.document;
            doc.open();
            doc.write(baseStyles + renderedHtml);
            doc.close();
        };

        templateBody.addEventListener('input', updatePreview);
        updatePreview(); // Carga inicial

        // Manejo del Formulario
        const templateForm = document.getElementById('template-form');
        templateForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(templateForm);
            
            try {
                const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) {
                    window.location.href = 'admin.php?tab=plantillas&msg=plantilla_guardada';
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error(error);
                alert('Error de conexión con el servidor');
            }
        });
    });

    // Función global para insertar variables
    function insertVariable(variable) {
        const textarea = document.getElementById('template-body');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;
        const before = text.substring(0, start);
        const after = text.substring(end, text.length);
        
        textarea.value = before + variable + after;
        textarea.focus();
        textarea.selectionStart = textarea.selectionEnd = start + variable.length;
        
        // Disparar evento input para actualizar preview
        const event = new Event('input', { bubbles: true });
        textarea.dispatchEvent(event);
    }
</script>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
