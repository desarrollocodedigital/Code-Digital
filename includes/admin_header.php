<?php 
/**
 * Admin Header Include
 * Centraliza los estilos y scripts globales.
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Admin Dashboard'; ?> | Code Digital</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            cyan: '#00E5FF',
                            lime: '#B2FF05',
                        }
                    }
                }
            }
        }
    </script>
    <script>
        // --- SCRIPT ANTI-FLASH PARA DARK MODE ---
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Global JS (Dark Mode, etc) -->
    <script src="../assets/js/main.js"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }

        @keyframes marquee { 0% { transform: translateX(0%); } 100% { transform: translateX(-100%); } }
        @keyframes marquee2 { 0% { transform: translateX(100%); } 100% { transform: translateX(0%); } }
        .animate-marquee { animation: marquee 30s linear infinite; }
        .animate-marquee2 { animation: marquee2 30s linear infinite; }
        .mask-fade { mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent); }
    </style>
</head>
<?php 
// Lógica Global de Notificaciones (Toast)
$msg_code = $_GET['msg'] ?? '';
$toast_msg = '';
$toast_icon = 'check-circle';

if ($msg_code) {
    switch ($msg_code) {
        case 'proyecto_creado': $toast_msg = 'Proyecto creado exitosamente en el sistema.'; break;
        case 'proyecto_modificado': $toast_msg = 'Los datos del proyecto se actualizaron correctamente.'; break;
        case 'proyecto_eliminado': $toast_msg = 'Proyecto eliminado permanentemente.'; $toast_icon = 'trash-2'; break;
        case 'cliente_creado': $toast_msg = 'Alianza o cliente registrado exitosamente.'; break;
        case 'cliente_modificado': $toast_msg = 'Datos del cliente actualizados.'; break;
        case 'cliente_eliminado': $toast_msg = 'Cliente eliminado del sistema.'; $toast_icon = 'trash-2'; break;
        case 'mensaje_leido': $toast_msg = 'Mensaje CRM marcado como leído y procesado.'; break;
        case 'mensaje_eliminado': $toast_msg = 'Contacto CRM borrado permanentemente de la base de datos.'; $toast_icon = 'trash-2'; break;
        case 'config_actualizada': $toast_msg = 'Configuración del sitio actualizada correctamente.'; break;
        case 'creds_enviadas': $toast_msg = 'Credenciales marcadas como entregadas vía WhatsApp.'; break;
        case 'lead_convertido': $toast_msg = 'El mensaje ha sido transformado en un Cliente Potencial.'; break;
        case 'lead_creado': $toast_msg = 'Nuevo prospecto registrado exitosamente en el CRM.'; break;
        case 'lead_modificado': $toast_msg = 'Se editó la información del prospecto correctamente.'; break;
        case 'email_enviado': $toast_msg = 'El correo electrónico ha sido enviado y registrado en el CRM.'; break;
        case 'plantilla_guardada': $toast_msg = 'La plantilla de correo se ha guardado correctamente.'; break;
        case 'plantilla_eliminada': $toast_msg = 'Plantilla de correo eliminada permanentemente.'; $toast_icon = 'trash-2'; break;
        case 'pass_actualizada': $toast_msg = 'Tu contraseña ha sido actualizada. La seguridad de tu cuenta está al día.'; $toast_icon = 'lock'; break;
    }
}
?>
<body class="font-sans bg-[#f8fafc] dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition-colors duration-300 overflow-x-hidden">

<?php if ($toast_msg): ?>
<!-- Global Toast Notification -->
<div id="toast-notification" class="fixed top-24 right-6 lg:right-10 z-[100] bg-white dark:bg-gray-900 border border-brand-cyan/20 shadow-[0_10px_40px_rgba(0,229,255,0.15)] dark:shadow-[0_10px_40px_rgba(0,229,255,0.05)] rounded-2xl p-4 flex items-center gap-4 transform transition-all duration-500 translate-x-12 opacity-0">
    <div class="w-10 h-10 rounded-full bg-brand-cyan/10 flex items-center justify-center text-brand-cyan">
        <i data-lucide="<?php echo $toast_icon; ?>" class="w-5 h-5"></i>
    </div>
    <div class="mr-4">
        <h4 class="text-sm font-bold text-gray-900 dark:text-white">Operación Exitosa</h4>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5"><?php echo $toast_msg; ?></p>
    </div>
    <button onclick="document.getElementById('toast-notification').remove()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors ml-auto absolute top-2 right-2 p-2">
        <i data-lucide="x" class="w-3.5 h-3.5"></i>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const toast = document.getElementById('toast-notification');
            if (toast) {
                toast.classList.remove('translate-x-12', 'opacity-0');
                setTimeout(() => {
                    toast.classList.add('translate-x-12', 'opacity-0');
                    setTimeout(() => toast.remove(), 500);
                }, 4500);
            }
        }, 100);
        
        if (window.history.replaceState) {
            const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + window.location.search.replace(/&?msg=[^&]*/g, '').replace(/^\?$/, '');
            window.history.replaceState({path: cleanUrl}, '', cleanUrl);
        }
    });
</script>
<?php endif; ?>

<script>
    // Función Global para Toasts (Soporte AJAX) - Siempre disponible
    window.showToast = function(message, icon = 'check-circle') {
        const oldToast = document.getElementById('toast-notification');
        if (oldToast) oldToast.remove();

        const toastHtml = `
        <div id="toast-notification" class="fixed top-24 right-6 lg:right-10 z-[100] bg-white dark:bg-gray-900 border border-brand-cyan/20 shadow-[0_10px_40px_rgba(0,229,255,0.15)] dark:shadow-[0_10px_40px_rgba(0,229,255,0.05)] rounded-2xl p-4 flex items-center gap-4 transform transition-all duration-500 translate-x-12 opacity-0">
            <div class="w-10 h-10 rounded-full bg-brand-cyan/10 flex items-center justify-center text-brand-cyan">
                <i data-lucide="${icon}" class="w-5 h-5"></i>
            </div>
            <div class="mr-4">
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Operación Exitosa</h4>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">${message}</p>
            </div>
            <button onclick="document.getElementById('toast-notification').remove()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors ml-auto absolute top-2 right-2 p-2">
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
            </button>
        </div>`;

        document.body.insertAdjacentHTML('beforeend', toastHtml);
        if (typeof lucide !== 'undefined') lucide.createIcons();

        const toast = document.getElementById('toast-notification');
        setTimeout(() => {
            if (toast) {
                toast.classList.remove('translate-x-12', 'opacity-0');
                setTimeout(() => {
                    if (toast) {
                        toast.classList.add('translate-x-12', 'opacity-0');
                        setTimeout(() => toast.remove(), 500);
                    }
                }, 4500);
            }
        }, 10);
    };
</script>
