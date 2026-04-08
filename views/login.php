<?php
session_start();
// Si ya está logueado, lo mandamos al admin directamente
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo | Code Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Outfit:wght@300;600;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        .glass {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.1; }
        }
    </style>
</head>
<body class="bg-gray-950 text-white min-h-screen flex items-center justify-center p-6 overflow-hidden relative">

    <!-- Orbes de luz de fondo -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-500/10 rounded-full blur-[120px] animate-pulse-slow"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-lime-500/10 rounded-full blur-[120px] animate-pulse-slow"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo / Titulo -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-cyan-500 to-lime-500 p-[1px] mb-6">
                <div class="w-full h-full bg-gray-950 rounded-2xl flex items-center justify-center">
                    <i data-lucide="shield-check" class="w-8 h-8 text-cyan-400"></i>
                </div>
            </div>
            <h1 class="text-4xl font-black font-outfit tracking-tighter mb-2">Code <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-lime-400">Digital</span></h1>
            <p class="text-gray-500 font-medium uppercase tracking-[0.3em] text-[10px]">Panel Administrativo v3.0</p>
        </div>

        <!-- Card de Login -->
        <div class="glass rounded-[2.5rem] p-8 md:p-10 shadow-2xl overflow-hidden relative group">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-500 to-lime-500 opacity-50"></div>
            
            <form id="loginForm" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Usuario</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500"></i>
                        <input type="text" name="usuario" required
                            class="w-full bg-gray-900/50 border border-gray-800 rounded-2xl py-4 pl-12 pr-4 text-sm focus:outline-none focus:border-cyan-500/50 focus:ring-4 focus:ring-cyan-500/10 transition-all placeholder:text-gray-600"
                            placeholder="correo@ejemplo.com">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Contraseña</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500"></i>
                        <input type="password" name="password" required
                            class="w-full bg-gray-900/50 border border-gray-800 rounded-2xl py-4 pl-12 pr-4 text-sm focus:outline-none focus:border-lime-500/50 focus:ring-4 focus:ring-lime-500/10 transition-all placeholder:text-gray-600"
                            placeholder="••••••••">
                    </div>
                </div>

                <div id="errorMessage" class="hidden animate-bounce text-center py-3 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-xs font-bold">
                    <!-- Error content -->
                </div>

                <button type="submit" id="btnSubmit"
                    class="w-full bg-white text-gray-950 font-black py-4 rounded-2xl shadow-xl shadow-white/5 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 group">
                    <span>ENTRAR AL PANEL</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>

        <div class="text-center mt-8">
            <p class="text-gray-600 text-[10px] font-bold uppercase tracking-widest">© 2026 Code Digital • Studio Creativo</p>
        </div>
    </div>

    <script>
        lucide.createIcons();

        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btnSubmit');
            const errorBox = document.getElementById('errorMessage');
            const formData = new FormData(e.target);

            // Estado de carga
            btn.disabled = true;
            btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> AUTENTICANDO...';
            lucide.createIcons();
            errorBox.classList.add('hidden');

            try {
                const response = await fetch('../api/auth_handler.php?action=login', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    btn.classList.replace('bg-white', 'bg-lime-500');
                    btn.classList.replace('text-gray-950', 'text-white');
                    btn.innerHTML = '<i data-lucide="check-circle-2" class="w-5 h-5"></i> ACCESO CORRECTO';
                    lucide.createIcons();
                    setTimeout(() => window.location.href = 'admin.php', 1000);
                } else {
                    errorBox.textContent = data.message;
                    errorBox.classList.remove('hidden');
                    btn.disabled = false;
                    btn.innerHTML = '<span>ENTRAR AL PANEL</span> <i data-lucide="arrow-right" class="w-5 h-5"></i>';
                    lucide.createIcons();
                }
            } catch (error) {
                console.error('Error:', error);
                errorBox.textContent = 'Error de conexión con el servidor.';
                errorBox.classList.remove('hidden');
                btn.disabled = false;
                btn.innerHTML = '<span>ENTRAR AL PANEL</span> <i data-lucide="arrow-right" class="w-5 h-5"></i>';
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
