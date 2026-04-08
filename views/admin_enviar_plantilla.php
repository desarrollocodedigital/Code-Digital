<?php require_once '../includes/auth_guard.php'; ?>
<?php
/**
 * Página de Envío: Plantillas de Correo
 */
require_once __DIR__ . '/../config/db.php';

// Obtener todas las plantillas para el selector
$stmtApps = $pdo->query("SELECT * FROM plantillas_email ORDER BY titulo ASC");
$plantillas = $stmtApps->fetchAll();

$email_destinatario = $_GET['email'] ?? '';
$page_title = "Enviar Correo";

include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';
?>

<div class="p-6 lg:p-10 space-y-8 animate-fade-in max-w-[1600px] mx-auto">
    <div class="flex items-center justify-between gap-4 mb-2">
        <div class="flex items-center gap-4">
            <a href="admin.php?tab=mensajes" class="p-2.5 bg-white dark:bg-gray-900 text-gray-500 hover:text-brand-cyan rounded-xl border border-gray-100 dark:border-gray-800 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">Enviar Correo <span class="text-indigo-500">.</span></h2>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-indigo-500/5 rounded-full border border-indigo-500/10">
            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
            <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">Master Sender CRM</span>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-12">
        <!-- Columna Configuración del Envío -->
        <div class="space-y-8">
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden">
                <form id="form-sender" class="p-8 lg:p-12 space-y-8">
                    <input type="hidden" name="action" value="send_template_email">

                    <!-- Destinatario -->
                    <div class="space-y-3">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="user" class="w-3.5 h-3.5"></i> Email del Destinatario
                        </label>
                        <input type="email" name="email" id="field-email" value="<?php echo htmlspecialchars($email_destinatario); ?>" placeholder="ejemplo@cliente.com" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-900 dark:text-white" required />
                    </div>

                    <!-- Selector de Plantilla -->
                    <div class="space-y-3">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="layout-template" class="w-3.5 h-3.5"></i> Seleccionar Plantilla
                        </label>
                        <div class="relative">
                            <select name="template_id" id="template-selector" class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-2xl px-6 py-4 outline-none transition-all appearance-none font-medium text-gray-900 dark:text-white pr-12 cursor-pointer" required>
                                <option value="">-- Elige una plantilla base --</option>
                                <?php foreach ($plantillas as $p): ?>
                                    <option value="<?php echo $p['id']; ?>" data-body='<?php echo json_encode($p['cuerpo']); ?>' data-subject="<?php echo htmlspecialchars($p['asunto']); ?>">
                                        <?php echo htmlspecialchars($p['titulo']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje Libre -->
                    <div class="space-y-4">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Mensaje Personalizado
                        </label>
                        <div class="relative group">
                            <textarea name="mensaje_libre" id="field-mensaje-libre" rows="12" placeholder="Escribe aquí el corazón de tu propuesta..." class="w-full bg-gray-50 dark:bg-gray-800 border border-transparent focus:border-brand-cyan rounded-[2rem] px-8 py-6 outline-none transition-all resize-none font-medium leading-relaxed text-gray-900 dark:text-white"></textarea>
                            <div class="absolute bottom-4 right-8 text-[9px] font-bold text-gray-400 uppercase tracking-widest pointer-events-none flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-cyan animate-pulse"></span> Se inyectará en [[CONTENIDO_LIBRE]]
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-end gap-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                        <a href="admin.php?tab=mensajes" class="text-sm font-bold text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">Tal vez luego</a>
                        <button type="submit" id="submit-btn" class="bg-indigo-600 text-white px-10 py-5 rounded-[2rem] font-bold shadow-xl shadow-indigo-600/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-3">
                            <i data-lucide="send" class="w-5 h-5"></i>
                            Enviar Propuesta por PHPMailer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna Previsualización -->
        <div class="flex flex-col gap-6">
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-2">
                    <i data-lucide="eye" class="text-indigo-500 w-4 h-4"></i>
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Composición Final</h3>
                </div>
                <div id="live-subject" class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic opacity-60">Sujeto: Sin plantilla</div>
            </div>

            <div class="flex-1 bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden flex flex-col min-h-[700px]">
                <!-- Browser Bar -->
                <div class="h-12 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800 flex items-center px-6 gap-3">
                    <div class="flex gap-1.5">
                        <div class="w-2.5 h-2.5 rounded-full bg-red-400/20"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-amber-400/20"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-green-400/20"></div>
                    </div>
                    <div class="flex-1 bg-white dark:bg-gray-900 rounded-lg h-7 flex items-center px-4 text-[10px] text-gray-400 font-mono opacity-50">
                        client-inbox://mail.view/preview
                    </div>
                </div>

                <!-- Iframe Preview -->
                <iframe id="final-preview" class="w-full h-full bg-white"></iframe>

                <!-- Context Hint -->
                <div class="p-6 bg-indigo-500/5 border-t border-indigo-500/10">
                    <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest leading-relaxed flex items-center gap-2 italic">
                        <i data-lucide="info" class="w-3 h-3"></i> Esta vista combina tu mensaje con el diseño de la plantilla seleccionada.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</div> <!-- Close sidebar content wrapper -->
</main>
</div> <!-- Close sidebar flex -->

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selector = document.getElementById('template-selector');
        const mensajeLibre = document.getElementById('field-mensaje-libre');
        const iframe = document.getElementById('final-preview');
        const subjectEl = document.getElementById('live-subject');
        const form = document.getElementById('form-sender');
        const submitBtn = document.getElementById('submit-btn');

        const updatePreview = () => {
            const selectedOption = selector.options[selector.selectedIndex];
            if (!selectedOption.value) {
                const doc = iframe.contentDocument || iframe.contentWindow.document;
                doc.open();
                doc.write('<body style="font-family: sans-serif; display: flex; align-items: center; justify-content: center; height: 90vh; color: #999; text-transform: uppercase; font-size: 11px; font-weight: bold; letter-spacing: 0.1em;">Selecciona una plantilla para previsualizar...</body>');
                doc.close();
                subjectEl.textContent = 'Asunto: Sin plantilla';
                return;
            }

            let body = JSON.parse(selectedOption.dataset.body);
            const subject = selectedOption.dataset.subject;
            const textLibre = mensajeLibre.value || '<span style="color: #999; font-style: italic;">(Escribe tu mensaje personalizado aquí...)</span>';
            
            // Reemplazo de variable
            const finalHtml = body.replace(/\[\[CONTENIDO_LIBRE\]\]/g, `<div style="white-space: pre-wrap; margin: 10px 0;">${textLibre}</div>`);
            
            subjectEl.textContent = 'Asunto: ' + subject;

            const baseStyles = `
                <style>
                    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 20px; }
                </style>
            `;

            const doc = iframe.contentDocument || iframe.contentWindow.document;
            doc.open();
            doc.write(baseStyles + finalHtml);
            doc.close();
        };

        selector.addEventListener('change', updatePreview);
        mensajeLibre.addEventListener('input', updatePreview);
        updatePreview();

        // Manejo del Envío
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const originalBtn = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Enviando Propuesta...';
            if (typeof lucide !== 'undefined') lucide.createIcons();

            const formData = new FormData(form);
            try {
                const response = await fetch('../api/admin_actions.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) {
                    window.location.href = 'admin.php?tab=mensajes&msg=email_enviado';
                } else {
                    alert('Error: ' + result.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtn;
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }
            } catch (error) {
                console.error(error);
                alert('Error de conexión con el servidor');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtn;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }
        });

        // Lucide Icons
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
</body>
</html>
