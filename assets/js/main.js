// Configuración de Tailwind CSS
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

// Prevención de destellos (FOUC) en el cambio de tema
if (localStorage.getItem('color-theme') === 'dark') {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}

// Inicialización de componentes al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar íconos de Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Establecer año actual en el footer
    const yearElement = document.getElementById('year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }

    // --- LÓGICA DEL DARK MODE (Toggle) ---
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    if (themeToggleBtn && darkIcon && lightIcon) {
        // Mostrar el icono correcto al cargar
        if (document.documentElement.classList.contains('dark')) {
            darkIcon.classList.remove('hidden');
        } else {
            lightIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', function() {
            // Alternar iconos
            darkIcon.classList.toggle('hidden');
            lightIcon.classList.toggle('hidden');

            // Alternar tema y guardar preferencia
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });
    }

    // --- LÓGICA DEL CHAT FLOTANTE ---
    const chatWindow = document.getElementById('chat-window');
    const chatToggleBtn = document.getElementById('chat-toggle-btn');
    const chatCloseBtn = document.getElementById('chat-close-btn');
    const iconMessage = document.getElementById('icon-message');
    const iconClose = document.getElementById('icon-close');
    const chatInput = document.getElementById('chat-input');
    const chatSendBtn = document.getElementById('chat-send-btn');

    if (chatToggleBtn && chatWindow) {
        function toggleChat() {
            const isOpen = chatWindow.classList.contains('opacity-100');
            
            if (!isOpen) {
                // Abrir animación
                chatWindow.classList.remove('hidden'); // Mostrar físicamente en el DOM
                
                // Forzar reflow para animación
                void chatWindow.offsetWidth;

                chatWindow.classList.remove('invisible', 'opacity-0', 'translate-y-4', 'scale-95', 'pointer-events-none');
                chatWindow.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                if (iconMessage) {
                    iconMessage.classList.remove('block');
                    iconMessage.classList.add('hidden');
                }
                if (iconClose) {
                    iconClose.classList.remove('hidden');
                    iconClose.classList.add('block');
                }
            } else {
                // Cerrar animación
                chatWindow.classList.add('invisible', 'opacity-0', 'translate-y-4', 'scale-95', 'pointer-events-none');
                chatWindow.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                if (iconMessage) {
                    iconMessage.classList.remove('hidden');
                    iconMessage.classList.add('block');
                }
                if (iconClose) {
                    iconClose.classList.remove('block');
                    iconClose.classList.add('hidden');
                }

                // Esperar a que termine la animación para ocultar físicamente
                setTimeout(() => {
                    chatWindow.classList.add('hidden');
                }, 500);
            }
        }

        // --- APERTURA AUTOMÁTICA CON ANIMACIÓN ---
        // Se abre el chat con un pequeño retraso para notar el efecto
        setTimeout(() => {
            if (chatWindow.classList.contains('opacity-0')) {
                toggleChat();
            }
        }, 800);

        // --- REDIRECCIÓN A WHATSAPP ---
        function sendToWhatsApp() {
            const message = chatInput.value.trim();
            if (message) {
                const phoneNumber = '526672644610';
                const header = "Soporte Code Digital";
                const fullMessage = `${header}\n\n${message}`;
                const encodedMessage = encodeURIComponent(fullMessage);
                const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
                window.open(whatsappUrl, '_blank');
                chatInput.value = ''; // Limpiar campo
            }
        }

        chatToggleBtn.addEventListener('click', toggleChat);
        if (chatCloseBtn) {
            chatCloseBtn.addEventListener('click', toggleChat);
        }

        // Listener para el botón de enviar
        if (chatSendBtn) {
            chatSendBtn.addEventListener('click', sendToWhatsApp);
        }

        // Listener para la tecla Enter
        if (chatInput) {
            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    sendToWhatsApp();
                }
            });
        }
    }

    // --- LÓGICA DEL MODAL DE DEMO ---
    const demoModal = document.getElementById('demo-modal');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const closeModalBtn = document.getElementById('close-modal');
    const demoForm = document.getElementById('demo-form');
    const demoSuccess = document.getElementById('demo-success');
    const modalProjectName = document.getElementById('modal-project-name');
    const openModalBtns = document.querySelectorAll('.open-demo-modal');

    function openDemoModal(projectName) {
        if (!demoModal) return;
        
        modalProjectName.textContent = projectName;
        demoModal.classList.remove('opacity-0', 'pointer-events-none');
        demoModal.classList.add('opacity-100', 'pointer-events-auto');
        
        // Animación interna de la tarjeta
        const modalCard = demoModal.querySelector('.relative.bg-white');
        if (modalCard) {
            modalCard.classList.remove('scale-95');
            modalCard.classList.add('scale-100');
        }

        // Reiniciar estado del formulario
        if (demoForm && demoSuccess) {
            demoForm.classList.remove('hidden');
            demoSuccess.classList.add('hidden');
            demoForm.reset();
        }
    }

    function closeDemoModal() {
        if (!demoModal) return;
        
        demoModal.classList.add('opacity-0', 'pointer-events-none');
        demoModal.classList.remove('opacity-100', 'pointer-events-auto');
        
        const modalCard = demoModal.querySelector('.relative.bg-white');
        if (modalCard) {
            modalCard.classList.add('scale-95');
            modalCard.classList.remove('scale-100');
        }
    }

    // Event Delegation para apertura de modales (mucho más fiable en móviles)
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.open-demo-modal');
        if (btn) {
            const projectName = btn.getAttribute('data-project-name');
            openDemoModal(projectName);
        }
    });

    if (closeModalBtn) closeModalBtn.addEventListener('click', closeDemoModal);
    if (modalBackdrop) modalBackdrop.addEventListener('click', closeDemoModal);

    // Manejo de ESC para cerrar
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDemoModal();
    });

    // --- LÓGICA DE ENVÍO DE FORMULARIOS ---
    function handleFormSubmit(formId, successCallback) {
        const form = document.getElementById(formId);
        if (!form) return;

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // La validación de HTML5 (oninput, pattern, maxlength) ya filtra los 10 dígitos
            if (!form.checkValidity()) return;

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            
            // Estado de carga
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Enviando...';
            lucide.createIcons();

            // Simulación de envío (1.5s)
            setTimeout(() => {
                successCallback();
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
                lucide.createIcons();
                form.reset();
            }, 1500);
        });
    }

    // Inicializar formularios
    if (demoForm) {
        handleFormSubmit('demo-form', () => {
            demoForm.classList.add('hidden');
            demoSuccess.classList.remove('hidden');
        });
    }

    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        handleFormSubmit('contact-form', () => {
            alert('¡Mensaje enviado con éxito! Nos pondremos en contacto contigo pronto.');
        });
    }

    // --- LÓGICA DEL MENÚ MÓVIL ---
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
    const mobileMenuContent = document.getElementById('mobile-menu-content');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    const yearMobile = document.getElementById('year-mobile');

    if (yearMobile) {
        yearMobile.textContent = new Date().getFullYear();
    }

    if (mobileMenuBtn && mobileMenu && mobileMenuContent) {
        function openMobileMenu() {
            console.log("Abriendo menú móvil...");
            mobileMenu.classList.remove('hidden'); // Mostrar físicamente
            
            // Forzar un reflow para que la transición funcione tras quitar 'hidden'
            void mobileMenu.offsetWidth;
            
            mobileMenu.classList.remove('invisible', 'pointer-events-none');
            // Usar un pequeño delay para que la transición de opacidad se note tras quitar 'invisible'
            setTimeout(() => {
                mobileMenuBackdrop.classList.replace('opacity-0', 'opacity-100');
                mobileMenuContent.classList.replace('translate-x-full', 'translate-x-0');
            }, 10);
            document.body.classList.add('overflow-hidden');
        }

        function closeMobileMenu() {
            console.log("Cerrando menú móvil...");
            mobileMenuBackdrop.classList.replace('opacity-100', 'opacity-0');
            mobileMenuContent.classList.replace('translate-x-0', 'translate-x-full');
            document.body.classList.remove('overflow-hidden');
            
            // Esperar a que termine la animación (500ms) para ocultar con invisible y hidden
            setTimeout(() => {
                mobileMenu.classList.add('invisible', 'pointer-events-none');
                mobileMenu.classList.add('hidden'); // Ocultar físicamente
            }, 500);
        }

        mobileMenuBtn.addEventListener('click', openMobileMenu);
        if (mobileMenuClose) mobileMenuClose.addEventListener('click', closeMobileMenu);
        if (mobileMenuBackdrop) mobileMenuBackdrop.addEventListener('click', closeMobileMenu);

        // Cerrar al hacer clic en un enlace
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });

        // Cerrar con ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeMobileMenu();
        });
    }
});
