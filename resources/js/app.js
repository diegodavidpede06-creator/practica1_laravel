/*
|--------------------------------------------------------------------------
| Sistema de Gestión de Tareas y Evidencias
|--------------------------------------------------------------------------
| Laravel 13 + Blade
| JavaScript puro — sin librerías externas
|--------------------------------------------------------------------------
*/

'use strict';


/*
|--------------------------------------------------------------------------
| 1. CONFIGURACIÓN GENERAL
|--------------------------------------------------------------------------
*/

const App = {
    selectors: {
        html: 'html',
        body: 'body',

        themeToggle: '[data-theme-toggle]',

        sidebar: '[data-sidebar]',
        sidebarOverlay: '[data-sidebar-overlay]',
        mobileMenu: '[data-mobile-menu]',

        passwordToggle: '[data-password-toggle]',

        modalOpen: '[data-modal-open]',
        modalClose: '[data-modal-close]',
        modalBackdrop: '.modal-backdrop',

        fileInput: '[data-file-input]',
        fileName: '[data-file-name]',

        confirmAction: '[data-confirm]',
        autoDismiss: '[data-auto-dismiss]',

        toastClose: '[data-toast-close]',
    },

    theme: {
        key: 'sistema-tareas-theme',
        dark: 'dark',
        light: 'light',
    },

    maxPdfSize: 10 * 1024 * 1024,
};


/*
|--------------------------------------------------------------------------
| 2. INICIALIZACIÓN
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    App.initTheme();
    App.initThemeToggle();

    App.initMobileSidebar();

    App.initPasswordToggle();

    App.initModals();

    App.initFileUpload();

    App.initConfirmations();

    App.initAutoDismiss();

    App.initToastClose();

    App.initForms();

});


/*
|--------------------------------------------------------------------------
| 3. TEMA CLARO / OSCURO
|--------------------------------------------------------------------------
*/

App.initTheme = function () {

    const savedTheme = localStorage.getItem(App.theme.key);

    if (savedTheme === App.theme.dark) {
        document.documentElement.setAttribute(
            'data-theme',
            App.theme.dark
        );

        return;
    }

    if (savedTheme === App.theme.light) {
        document.documentElement.setAttribute(
            'data-theme',
            App.theme.light
        );

        return;
    }

    /*
     * Si el usuario nunca ha seleccionado un tema,
     * utilizamos la preferencia del sistema operativo.
     */
    const prefersDark = window.matchMedia &&
        window.matchMedia('(prefers-color-scheme: dark)').matches;

    document.documentElement.setAttribute(
        'data-theme',
        prefersDark ? App.theme.dark : App.theme.light
    );
};


/*
|--------------------------------------------------------------------------
| 4. BOTÓN CAMBIAR TEMA
|--------------------------------------------------------------------------
*/

App.initThemeToggle = function () {

    const buttons = document.querySelectorAll(
        App.selectors.themeToggle
    );

    if (!buttons.length) {
        return;
    }

    buttons.forEach(button => {

        App.updateThemeIcon(button);

        button.addEventListener('click', () => {

            const currentTheme =
                document.documentElement.getAttribute('data-theme');

            const newTheme =
                currentTheme === App.theme.dark
                    ? App.theme.light
                    : App.theme.dark;

            document.documentElement.setAttribute(
                'data-theme',
                newTheme
            );

            localStorage.setItem(
                App.theme.key,
                newTheme
            );

            buttons.forEach(item => {
                App.updateThemeIcon(item);
            });
        });
    });
};


/*
|--------------------------------------------------------------------------
| 5. ACTUALIZAR ICONO DEL TEMA
|--------------------------------------------------------------------------
*/

App.updateThemeIcon = function (button) {

    const currentTheme =
        document.documentElement.getAttribute('data-theme');

    const sunIcon = button.querySelector(
        '[data-theme-icon="sun"]'
    );

    const moonIcon = button.querySelector(
        '[data-theme-icon="moon"]'
    );

    if (sunIcon) {
        sunIcon.classList.toggle(
            'hidden',
            currentTheme !== App.theme.dark
        );
    }

    if (moonIcon) {
        moonIcon.classList.toggle(
            'hidden',
            currentTheme === App.theme.dark
        );
    }

    const label =
        currentTheme === App.theme.dark
            ? 'Cambiar a modo claro'
            : 'Cambiar a modo oscuro';

    button.setAttribute('aria-label', label);
    button.setAttribute('title', label);
};


/*
|--------------------------------------------------------------------------
| 6. SIDEBAR RESPONSIVE
|--------------------------------------------------------------------------
*/

App.initMobileSidebar = function () {

    const sidebar = document.querySelector(
        App.selectors.sidebar
    );

    const overlay = document.querySelector(
        App.selectors.sidebarOverlay
    );

    const menuButton = document.querySelector(
        App.selectors.mobileMenu
    );

    if (!sidebar || !menuButton) {
        return;
    }


    /*
     * Abrir sidebar
     */
    menuButton.addEventListener('click', () => {

        sidebar.classList.add('mobile-open');

        if (overlay) {
            overlay.classList.add('show');
        }

        document.body.style.overflow = 'hidden';
    });


    /*
     * Cerrar sidebar mediante overlay
     */
    if (overlay) {

        overlay.addEventListener('click', () => {
            App.closeMobileSidebar();
        });
    }


    /*
     * Cerrar sidebar al seleccionar una opción
     */
    const sidebarLinks =
        sidebar.querySelectorAll('.sidebar-link');

    sidebarLinks.forEach(link => {

        link.addEventListener('click', () => {

            if (window.innerWidth <= 800) {
                App.closeMobileSidebar();
            }
        });
    });


    /*
     * Si la ventana vuelve a escritorio,
     * limpiamos el estado móvil.
     */
    window.addEventListener('resize', () => {

        if (window.innerWidth > 800) {

            sidebar.classList.remove('mobile-open');

            if (overlay) {
                overlay.classList.remove('show');
            }

            document.body.style.overflow = '';
        }
    });
};


/*
|--------------------------------------------------------------------------
| 7. CERRAR SIDEBAR
|--------------------------------------------------------------------------
*/

App.closeMobileSidebar = function () {

    const sidebar = document.querySelector(
        App.selectors.sidebar
    );

    const overlay = document.querySelector(
        App.selectors.sidebarOverlay
    );

    if (sidebar) {
        sidebar.classList.remove('mobile-open');
    }

    if (overlay) {
        overlay.classList.remove('show');
    }

    document.body.style.overflow = '';
};


/*
|--------------------------------------------------------------------------
| 8. MOSTRAR / OCULTAR CONTRASEÑA
|--------------------------------------------------------------------------
*/

App.initPasswordToggle = function () {

    const buttons = document.querySelectorAll(
        App.selectors.passwordToggle
    );

    buttons.forEach(button => {

        button.addEventListener('click', () => {

            const targetId =
                button.getAttribute('data-password-toggle');

            if (!targetId) {
                return;
            }

            const input =
                document.getElementById(targetId);

            if (!input) {
                return;
            }

            const isPassword =
                input.type === 'password';

            input.type =
                isPassword
                    ? 'text'
                    : 'password';

            const eyeIcon =
                button.querySelector('[data-eye-icon]');

            const eyeOffIcon =
                button.querySelector('[data-eye-off-icon]');

            if (eyeIcon) {
                eyeIcon.classList.toggle(
                    'hidden',
                    isPassword
                );
            }

            if (eyeOffIcon) {
                eyeOffIcon.classList.toggle(
                    'hidden',
                    !isPassword
                );
            }

            button.setAttribute(
                'aria-label',
                isPassword
                    ? 'Ocultar contraseña'
                    : 'Mostrar contraseña'
            );
        });
    });
};


/*
|--------------------------------------------------------------------------
| 9. MODALES
|--------------------------------------------------------------------------
*/

App.initModals = function () {

    const openButtons =
        document.querySelectorAll(
            App.selectors.modalOpen
        );

    const closeButtons =
        document.querySelectorAll(
            App.selectors.modalClose
        );


    /*
     * Abrir modal
     */
    openButtons.forEach(button => {

        button.addEventListener('click', () => {

            const modalId =
                button.getAttribute('data-modal-open');

            if (!modalId) {
                return;
            }

            App.openModal(modalId);
        });
    });


    /*
     * Cerrar modal
     */
    closeButtons.forEach(button => {

        button.addEventListener('click', () => {

            const modal =
                button.closest('.modal-backdrop');

            if (modal) {
                App.closeModal(modal);
            }
        });
    });


    /*
     * Cerrar haciendo clic en el fondo
     */
    document
        .querySelectorAll(App.selectors.modalBackdrop)
        .forEach(backdrop => {

            backdrop.addEventListener('click', event => {

                if (event.target === backdrop) {
                    App.closeModal(backdrop);
                }
            });
        });


    /*
     * Cerrar con tecla ESC
     */
    document.addEventListener('keydown', event => {

        if (event.key !== 'Escape') {
            return;
        }

        const openedModal =
            document.querySelector(
                '.modal-backdrop.show'
            );

        if (openedModal) {
            App.closeModal(openedModal);
        }
    });
};


/*
|--------------------------------------------------------------------------
| 10. ABRIR MODAL
|--------------------------------------------------------------------------
*/

App.openModal = function (modalId) {

    const modal =
        document.getElementById(modalId);

    if (!modal) {
        return;
    }

    modal.classList.add('show');

    document.body.style.overflow = 'hidden';

    /*
     * Enfocar automáticamente el primer elemento
     * que pueda recibir interacción.
     */
    setTimeout(() => {

        const focusable =
            modal.querySelector(
                'input, select, textarea, button'
            );

        if (focusable) {
            focusable.focus();
        }

    }, 50);
};


/*
|--------------------------------------------------------------------------
| 11. CERRAR MODAL
|--------------------------------------------------------------------------
*/

App.closeModal = function (modal) {

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    /*
     * Solo recuperamos el scroll si no hay otro
     * modal abierto.
     */
    const anotherModal =
        document.querySelector(
            '.modal-backdrop.show'
        );

    if (!anotherModal) {
        document.body.style.overflow = '';
    }
};


/*
|--------------------------------------------------------------------------
| 12. CARGA DE ARCHIVO PDF
|--------------------------------------------------------------------------
*/

App.initFileUpload = function () {

    const inputs =
        document.querySelectorAll(
            App.selectors.fileInput
        );

    inputs.forEach(input => {

        input.addEventListener('change', event => {

            const file =
                event.target.files[0];

            if (!file) {
                return;
            }

            const validation =
                App.validatePdf(file);

            if (!validation.valid) {

                input.value = '';

                App.showToast(
                    validation.message,
                    'error'
                );

                return;
            }

            App.displayFileName(
                input,
                file
            );
        });
    });
};


/*
|--------------------------------------------------------------------------
| 13. VALIDAR PDF
|--------------------------------------------------------------------------
*/

App.validatePdf = function (file) {

    const extension =
        file.name
            .split('.')
            .pop()
            .toLowerCase();

    const isPdf =
        extension === 'pdf' ||
        file.type === 'application/pdf';

    if (!isPdf) {

        return {
            valid: false,
            message: 'Solo se permiten archivos PDF.',
        };
    }


    if (file.size > App.maxPdfSize) {

        return {
            valid: false,
            message: 'El archivo no puede superar los 10 MB.',
        };
    }


    return {
        valid: true,
        message: '',
    };
};


/*
|--------------------------------------------------------------------------
| 14. MOSTRAR NOMBRE DEL ARCHIVO
|--------------------------------------------------------------------------
*/

App.displayFileName = function (input, file) {

    const targetSelector =
        input.getAttribute('data-file-name');

    let target = null;

    if (targetSelector) {

        target =
            document.querySelector(targetSelector);
    }

    /*
     * También permite utilizar:
     *
     * data-file-input="evidence"
     *
     * y buscar:
     *
     * [data-file-name="evidence"]
     */
    if (!target) {

        const identifier =
            input.getAttribute('id');

        if (identifier) {

            target =
                document.querySelector(
                    `[data-file-name="${identifier}"]`
                );
        }
    }

    if (!target) {
        return;
    }

    target.textContent =
        `${file.name} — ${App.formatFileSize(file.size)}`;

    target.classList.remove('text-muted');
};


/*
|--------------------------------------------------------------------------
| 15. FORMATO DE TAMAÑO DE ARCHIVO
|--------------------------------------------------------------------------
*/

App.formatFileSize = function (bytes) {

    if (bytes === 0) {
        return '0 B';
    }

    const units = [
        'B',
        'KB',
        'MB',
        'GB'
    ];

    const index =
        Math.floor(
            Math.log(bytes) /
            Math.log(1024)
        );

    const size =
        bytes /
        Math.pow(1024, index);

    return `${size.toFixed(index === 0 ? 0 : 1)} ${units[index]}`;
};


/*
|--------------------------------------------------------------------------
| 16. CONFIRMACIONES
|--------------------------------------------------------------------------
*/

App.initConfirmations = function () {

    const elements =
        document.querySelectorAll(
            App.selectors.confirmAction
        );

    elements.forEach(element => {

        element.addEventListener('click', event => {

            const message =
                element.getAttribute(
                    'data-confirm'
                );

            if (!message) {
                return;
            }

            const confirmed =
                window.confirm(message);

            if (!confirmed) {
                event.preventDefault();
            }
        });
    });
};


/*
|--------------------------------------------------------------------------
| 17. AUTO CERRAR ALERTAS
|--------------------------------------------------------------------------
*/

App.initAutoDismiss = function () {

    const elements =
        document.querySelectorAll(
            App.selectors.autoDismiss
        );

    elements.forEach(element => {

        const seconds =
            parseInt(
                element.getAttribute(
                    'data-auto-dismiss'
                ),
                10
            ) || 5;

        setTimeout(() => {

            element.style.opacity = '0';
            element.style.transform = 'translateY(-5px)';

            setTimeout(() => {

                element.remove();

            }, 200);

        }, seconds * 1000);
    });
};


/*
|--------------------------------------------------------------------------
| 18. CERRAR TOAST
|--------------------------------------------------------------------------
*/

App.initToastClose = function () {

    const buttons =
        document.querySelectorAll(
            App.selectors.toastClose
        );

    buttons.forEach(button => {

        button.addEventListener('click', () => {

            const toast =
                button.closest('.toast');

            if (!toast) {
                return;
            }

            App.removeToast(toast);
        });
    });
};


/*
|--------------------------------------------------------------------------
| 19. ELIMINAR TOAST
|--------------------------------------------------------------------------
*/

App.removeToast = function (toast) {

    toast.style.opacity = '0';
    toast.style.transform = 'translateY(8px)';

    setTimeout(() => {

        toast.remove();

    }, 180);
};


/*
|--------------------------------------------------------------------------
| 20. MOSTRAR TOAST
|--------------------------------------------------------------------------
*/

App.showToast = function (
    message,
    type = 'success'
) {

    let container =
        document.querySelector(
            '.toast-container'
        );

    /*
     * Si todavía no existe el contenedor,
     * lo creamos dinámicamente.
     */
    if (!container) {

        container =
            document.createElement('div');

        container.className =
            'toast-container';

        document.body.appendChild(container);
    }


    const toast =
        document.createElement('div');

    toast.className =
        `toast toast-${type}`;


    const icon =
        document.createElement('div');

    icon.className =
        'toast-icon';

    icon.innerHTML =
        type === 'error'
            ? App.icons.error
            : App.icons.success;


    const content =
        document.createElement('div');

    content.className =
        'toast-content';

    content.textContent =
        message;


    const close =
        document.createElement('button');

    close.type =
        'button';

    close.className =
        'toast-close';

    close.setAttribute(
        'aria-label',
        'Cerrar'
    );

    close.innerHTML =
        App.icons.close;


    close.addEventListener(
        'click',
        () => App.removeToast(toast)
    );


    toast.appendChild(icon);
    toast.appendChild(content);
    toast.appendChild(close);

    container.appendChild(toast);


    /*
     * Los mensajes desaparecen automáticamente.
     */
    setTimeout(() => {

        if (toast.isConnected) {
            App.removeToast(toast);
        }

    }, 4500);
};


/*
|--------------------------------------------------------------------------
| 21. ICONOS SVG PARA TOASTS
|--------------------------------------------------------------------------
*/

App.icons = {

    success: `
        <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M20 6 9 17l-5-5"/>
        </svg>
    `,

    error: `
        <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <circle cx="12" cy="12" r="9"/>
            <path d="m15 9-6 6"/>
            <path d="m9 9 6 6"/>
        </svg>
    `,

    close: `
        <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M18 6 6 18"/>
            <path d="m6 6 12 12"/>
        </svg>
    `,
};


/*
|--------------------------------------------------------------------------
| 22. FORMULARIOS
|--------------------------------------------------------------------------
*/

App.initForms = function () {

    const forms =
        document.querySelectorAll('form');

    forms.forEach(form => {

        /*
         * Evita doble envío accidental.
         */
        form.addEventListener('submit', () => {

            const submitButtons =
                form.querySelectorAll(
                    'button[type="submit"]'
                );

            submitButtons.forEach(button => {

                /*
                 * No deshabilitamos botones que tengan
                 * explícitamente data-no-lock.
                 */
                if (
                    button.hasAttribute(
                        'data-no-lock'
                    )
                ) {
                    return;
                }

                /*
                 * Pequeño retraso para permitir que
                 * Laravel procese normalmente el formulario.
                 */
                setTimeout(() => {

                    button.disabled = true;

                }, 0);
            });
        });
    });
};


/*
|--------------------------------------------------------------------------
| 23. PREVENIR DOBLE CLICK EN ACCIONES
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'click',
    event => {

        const button =
            event.target.closest(
                '[data-loading-button]'
            );

        if (!button) {
            return;
        }

        if (
            button.hasAttribute(
                'data-loading'
            )
        ) {
            event.preventDefault();
            return;
        }

        button.setAttribute(
            'data-loading',
            'true'
        );

        button.disabled = true;
    }
);


/*
|--------------------------------------------------------------------------
| 24. CERRAR ALERTAS MANUALMENTE
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'click',
    event => {

        const button =
            event.target.closest(
                '[data-alert-close]'
            );

        if (!button) {
            return;
        }

        const alert =
            button.closest('.alert');

        if (!alert) {
            return;
        }

        alert.style.opacity = '0';

        setTimeout(() => {
            alert.remove();
        }, 180);
    }
);


/*
|--------------------------------------------------------------------------
| 25. CONFIRMACIÓN ESPECIAL PARA CANCELAR TAREAS
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'click',
    event => {

        const button =
            event.target.closest(
                '[data-cancel-task]'
            );

        if (!button) {
            return;
        }

        const taskName =
            button.getAttribute(
                'data-task-name'
            );

        const message =
            taskName
                ? `¿Deseas cancelar la tarea "${taskName}"? Esta acción afectará a todos los alumnos y no se podrá editar posteriormente.`
                : '¿Deseas cancelar esta tarea? Esta acción no se puede deshacer.';

        const confirmed =
            window.confirm(message);

        if (!confirmed) {
            event.preventDefault();
        }
    }
);


/*
|--------------------------------------------------------------------------
| 26. VALIDACIÓN VISUAL DE CALIFICACIÓN
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'input',
    event => {

        const input =
            event.target.closest(
                '[data-grade-input]'
            );

        if (!input) {
            return;
        }

        let value =
            parseFloat(input.value);

        if (Number.isNaN(value)) {
            input.classList.remove(
                'grade-excellent',
                'grade-average',
                'grade-low'
            );

            return;
        }

        /*
         * Limitar visualmente el valor.
         * La validación definitiva la hará Laravel.
         */
        if (value > 10) {
            input.value = 10;
            value = 10;
        }

        if (value < 0) {
            input.value = 0;
            value = 0;
        }


        input.classList.remove(
            'grade-excellent',
            'grade-average',
            'grade-low'
        );


        if (value >= 9) {

            input.classList.add(
                'grade-excellent'
            );

        } else if (value >= 6) {

            input.classList.add(
                'grade-average'
            );

        } else {

            input.classList.add(
                'grade-low'
            );
        }
    }
);


/*
|--------------------------------------------------------------------------
| 27. SELECCIÓN DE TIPO DE TAREA
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'change',
    event => {

        const radio =
            event.target.closest(
                '[data-task-type]'
            );

        if (!radio) {
            return;
        }

        /*
         * Los estilos visuales son manejados por CSS
         * utilizando :checked.
         *
         * Aquí dejamos el punto de extensión
         * para futuras necesidades.
         */
        document
            .querySelectorAll(
                '[data-task-type]'
            )
            .forEach(input => {

                const label =
                    document.querySelector(
                        `label[for="${input.id}"]`
                    );

                if (!label) {
                    return;
                }

                label.setAttribute(
                    'aria-checked',
                    input.checked
                );
            });
    }
);


/*
|--------------------------------------------------------------------------
| 28. DETECCIÓN DE FORMULARIOS CON ARCHIVOS
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'change',
    event => {

        const input =
            event.target.closest(
                'input[type="file"]'
            );

        if (!input) {
            return;
        }

        const file =
            input.files &&
            input.files.length
                ? input.files[0]
                : null;

        if (!file) {
            return;
        }

        /*
         * El sistema solo admite un archivo.
         */
        if (input.files.length > 1) {

            App.showToast(
                'Solo puedes seleccionar un archivo.',
                'error'
            );

            input.value = '';

            return;
        }
    }
);


/*
|--------------------------------------------------------------------------
| 29. DETECTAR CAMBIOS NO GUARDADOS
|--------------------------------------------------------------------------
|
| Se puede activar en un formulario específico usando:
|
| <form data-unsaved-form>
|
|--------------------------------------------------------------------------
*/

App.initUnsavedChanges = function () {

    const forms =
        document.querySelectorAll(
            '[data-unsaved-form]'
        );

    forms.forEach(form => {

        let changed = false;

        form.addEventListener(
            'input',
            () => {
                changed = true;
            }
        );

        form.addEventListener(
            'change',
            () => {
                changed = true;
            }
        );

        form.addEventListener(
            'submit',
            () => {
                changed = false;
            }
        );

        window.addEventListener(
            'beforeunload',
            event => {

                if (!changed) {
                    return;
                }

                event.preventDefault();
                event.returnValue = '';
            }
        );
    });
};


/*
|--------------------------------------------------------------------------
| 30. UTILIDAD PARA OBTENER CSRF TOKEN
|--------------------------------------------------------------------------
*/

App.getCsrfToken = function () {

    const meta =
        document.querySelector(
            'meta[name="csrf-token"]'
        );

    return meta
        ? meta.getAttribute('content')
        : null;
};


/*
|--------------------------------------------------------------------------
| 31. FETCH POST CON CSRF
|--------------------------------------------------------------------------
|
| Esta función queda preparada para futuras acciones
| AJAX si posteriormente necesitamos utilizarlas.
|
|--------------------------------------------------------------------------
*/

App.post = async function (
    url,
    data = {}
) {

    const token =
        App.getCsrfToken();

    const response =
        await fetch(url, {

            method: 'POST',

            headers: {
                'Content-Type':
                    'application/json',

                'Accept':
                    'application/json',

                ...(token
                    ? {
                        'X-CSRF-TOKEN':
                            token
                    }
                    : {}),
            },

            body:
                JSON.stringify(data),
        });


    if (!response.ok) {

        throw new Error(
            'No fue posible completar la solicitud.'
        );
    }


    return response.json();
};


/*
|--------------------------------------------------------------------------
| 32. UTILIDAD PARA FECHAS
|--------------------------------------------------------------------------
*/

App.formatDate = function (date) {

    if (!date) {
        return '';
    }

    const parsed =
        new Date(date);

    if (Number.isNaN(
        parsed.getTime()
    )) {
        return date;
    }

    return new Intl.DateTimeFormat(
        'es-MX',
        {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
        }
    ).format(parsed);
};


/*
|--------------------------------------------------------------------------
| 33. UTILIDAD PARA FECHA Y HORA
|--------------------------------------------------------------------------
*/

App.formatDateTime = function (date) {

    if (!date) {
        return '';
    }

    const parsed =
        new Date(date);

    if (Number.isNaN(
        parsed.getTime()
    )) {
        return date;
    }

    return new Intl.DateTimeFormat(
        'es-MX',
        {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        }
    ).format(parsed);
};


/*
|--------------------------------------------------------------------------
| 34. EXPORTAR APP
|--------------------------------------------------------------------------
|
| Permitimos acceder al objeto desde otros scripts
| si posteriormente una vista necesita alguna función.
|
|--------------------------------------------------------------------------
*/

window.App = App;