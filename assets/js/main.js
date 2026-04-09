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

// Nota: La inicialización de la clase 'dark' se hace ahora directamente en el <head> de los archivos HTML
// para evitar el FOUC (Flash of Unstyled Content).

// Inicialización de componentes al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    // --- MOTOR DE TRACKING (ANALÍTICA INTERNA) ---
    window.trackEvent = async function(type, page = window.location.pathname.split('/').pop() || 'index.php', metadata = null) {
        try {
            // Detectar si estamos en una subcarpeta (views) para ajustar la ruta
            const isSubfolder = window.location.pathname.includes('/views/');
            const apiPath = isSubfolder ? '../api/track_event.php' : 'api/track_event.php';

            await fetch(apiPath, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ type, page, metadata }),
                keepalive: true // CRÍTICO: Evita que se cancele la petición al navegar
            });
        } catch (e) { console.error('Tracking error:', e); }
    };

    // Listeners Automáticos para CTAs
    document.addEventListener('click', (e) => {
        const target = e.target.closest('a, button');
        if (!target) return;

        // Limpiar el texto: quitar espacios, convertir a minúsculas y quitar caracteres de iconos
        const text = target.innerText.toLowerCase().trim();
        const href = target.getAttribute('href') || '';

        // 1. Evento: Agendar (WhatsApp)
        if (text.includes('agendar') || href.includes('wa.me')) {
            trackEvent('agendar');
        }
        // 2. Evento: Hablar con un experto
        else if (text.includes('experto')) {
            trackEvent('experto');
        }
        // 3. Evento: Iniciar Proyecto
        else if (text.includes('iniciar mi proyecto')) {
            trackEvent('iniciar_proyecto');
        }
        // 4. Evento: Solicitar Demo (con nombre de proyecto)
        else if (text.includes('solicitar demo')) {
            const projectTitle = target.getAttribute('data-project-name') || 
                               target.closest('.group')?.querySelector('.flex.items-center.gap-3 span')?.innerText || 
                               'Desconocido';
            trackEvent('solicitar_demo', undefined, projectTitle.trim());
        }
        // 5. Evento: Ver Caso (con nombre de proyecto)
        else if (text.includes('ver caso')) {
            const projectTitle = target.closest('.group')?.querySelector('.flex.items-center.gap-3 span')?.innerText || 
                               'Desconocido';
            trackEvent('ver_caso', undefined, projectTitle.trim());
        }
        // 6. Evento: Formulario de Contacto (Landing)
        else if (text.includes('enviar mensaje') && !target.closest('.chat-window')) {
            trackEvent('contacto_formulario');
        }
    });

    // --- TRACKING AUTOMÁTICO DE VISITAS (SOLO EN INDEX) ---
    const isIndex = window.location.pathname.endsWith('index.php') || window.location.pathname === '/' || window.location.pathname.endsWith('Code-Digital/');
    if (isIndex) {
        trackEvent('visita');
    }

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
        // Mostrar el icono opuesto al tema actual para indicar la acción a realizar
        if (document.documentElement.classList.contains('dark')) {
            lightIcon.classList.remove('hidden');
            darkIcon.classList.add('hidden');
        } else {
            darkIcon.classList.remove('hidden');
            lightIcon.classList.add('hidden');
        }

        themeToggleBtn.addEventListener('click', function() {
            // Alternar tema y guardar preferencia
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                // Cambiar icono a Luna (para indicar que puede volver a oscuro)
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                // Cambiar icono a Sol (para indicar que puede volver a claro)
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
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
        function toggleChat(isManual = false) {
            const isOpen = chatWindow.classList.contains('opacity-100');
            
            if (!isOpen) {
                // Abrir animación
                chatWindow.classList.remove('hidden'); // Mostrar físicamente en el DOM
                
                // Track Event: Solo si es una interacción manual del usuario
                if (isManual && window.trackEvent) window.trackEvent('soporte');

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
        // Pasamos isManual = false (por defecto) para NO trackear esto
        setTimeout(() => {
            if (chatWindow.classList.contains('opacity-0')) {
                toggleChat(false);
            }
        }, 800);

        // --- REDIRECCIÓN A WHATSAPP ---
        function sendToWhatsApp() {
            const message = chatInput.value.trim();
            if (message) {
                // Track Event: Soporte (Confirmación de envío)
                if (window.trackEvent) window.trackEvent('soporte');

                const phoneNumber = '526672644610';
                const header = "Soporte Code Digital";
                const fullMessage = `${header}\n\n${message}`;
                const encodedMessage = encodeURIComponent(fullMessage);
                const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
                window.open(whatsappUrl, '_blank');
                chatInput.value = ''; // Limpiar campo
            }
        }

        chatToggleBtn.addEventListener('click', () => toggleChat(true));
        if (chatCloseBtn) {
            chatCloseBtn.addEventListener('click', () => toggleChat(true));
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

    // --- LÓGICA DE ENVÍO DE FORMULARIOS UNIFICADA ---
    async function handleFormSubmit(formId, successCallback) {
        const form = document.getElementById(formId);
        if (!form) return;

        const submitBtn = form.querySelector('button[type="submit"]');
        if (!submitBtn) return;

        // Referencias internas para feedback visual
        const btnText = form.querySelector('[id*="btn-text"]');
        const iconContainer = form.querySelector('[id*="btn-icon-container"]');
        
        const updateIcon = (iconName, animate = false) => {
            if (!iconContainer) return;
            iconContainer.innerHTML = `<i data-lucide="${iconName}" class="w-4 h-4 ${animate ? 'animate-spin' : ''}"></i>`;
            if (typeof lucide !== 'undefined') lucide.createIcons();
        };

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!form.checkValidity()) return;

            const originalHTML = submitBtn.innerHTML;
            const originalText = btnText ? btnText.innerText : '';
            
            // Estado de carga
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            if (btnText) btnText.innerText = 'Enviando...';
            updateIcon('loader-2', true);

            const formData = new FormData(form);
            
            // Metadatos automáticos
            if (formId === 'demo-form') {
                formData.append('tipo', 'demo');
                if (modalProjectName) formData.append('proyecto', modalProjectName.textContent);
            } else {
                formData.append('tipo', 'contacto');
            }

            try {
                const apiPath = window.apiHandlerPath || 'api/contact_handler.php';
                const response = await fetch(apiPath, { method: 'POST', body: formData });
                const result = await response.json();

                if (result.success) {
                    if (btnText) btnText.innerText = '¡Enviado!';
                    updateIcon('check-circle', false);
                    submitBtn.classList.replace('bg-brand-cyan', 'bg-brand-lime');
                    
                    if (successCallback) successCallback();
                    form.reset();

                    setTimeout(() => {
                        if (btnText) btnText.innerText = originalText;
                        updateIcon('send', false);
                        submitBtn.classList.replace('bg-brand-lime', 'bg-brand-cyan');
                        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                        submitBtn.disabled = false;
                    }, 5000);
                } else {
                    alert('Error: ' + result.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Hubo un error al procesar tu solicitud.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }
        });
    }

    // Inicializar formularios
    if (demoForm) {
        handleFormSubmit('demo-form', () => {
            demoForm.classList.add('hidden');
            demoSuccess.classList.remove('hidden');
            
            // Cerrar el modal automáticamente después de 2 segundos
            setTimeout(() => {
                closeDemoModal();
                // Opcional: Resetear la vista del modal para la próxima vez
                setTimeout(() => {
                    demoForm.classList.remove('hidden');
                    demoSuccess.classList.add('hidden');
                }, 500);
            }, 2000);
        });
    }

    // Inicialización global del formulario de contacto
    handleFormSubmit('contact-form');

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
