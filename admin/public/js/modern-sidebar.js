// modern-sidebar.js

document.addEventListener("DOMContentLoaded", function () {
    const sidebar          = document.querySelector(".sidebar");
    const sidebarToggleBtn = document.querySelectorAll(".sidebar-toggle");
    const themeToggleBtn   = document.querySelector(".theme-toggle");
    const themeIcon        = themeToggleBtn ? themeToggleBtn.querySelector(".theme-icon") : null;
    const searchForm       = document.querySelector(".search-form");

    if (!sidebar || !themeToggleBtn || !themeIcon) {
        console.warn("modern-sidebar.js: Falta .sidebar o .theme-toggle en el DOM.");
        return;
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------
    const isDark = () => document.body.classList.contains("dark-theme");
    const isCollapsed = () => sidebar.classList.contains("collapsed");

    const updateThemeIcon = () => {
        // Si el sidebar está colapsado, mostramos el icono según tema actual
        // (si quieres otra lógica, la puedes ajustar aquí)
        themeIcon.textContent = isDark() ? "light_mode" : "dark_mode";
    };

    // -------------------------------------------------------
    // Inicializar tema (leer de localStorage o sistema)
    // -------------------------------------------------------
    const savedTheme        = localStorage.getItem("theme");
    const systemPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

    const shouldUseDarkTheme = savedTheme
        ? savedTheme === "dark"
        : systemPrefersDark;

    document.body.classList.toggle("dark-theme", shouldUseDarkTheme);
    updateThemeIcon();

    // Escuchar cambios del sistema SOLO si el usuario no ha elegido manualmente
    window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", e => {
        const userHasChoice = localStorage.getItem("theme") !== null;
        if (!userHasChoice) {
            document.body.classList.toggle("dark-theme", e.matches);
            updateThemeIcon();
        }
    });

    // -------------------------------------------------------
    // Toggle sidebar collapse
    // -------------------------------------------------------
    sidebarToggleBtn.forEach((btn) => {
        btn.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            updateThemeIcon();
        });
    });

    // -------------------------------------------------------
    // Expand sidebar y enfocar búsqueda (solo si existe search-form)
    // -------------------------------------------------------
    if (searchForm) {
        searchForm.addEventListener("click", () => {
            if (sidebar.classList.contains("collapsed")) {
                sidebar.classList.remove("collapsed");
                const input = searchForm.querySelector("input");
                if (input) input.focus();
                updateThemeIcon();
            }
        });
    }

    // -------------------------------------------------------
    // Botón de tema light/dark
    // -------------------------------------------------------
    themeToggleBtn.addEventListener("click", () => {
        const nowDark = document.body.classList.toggle("dark-theme");
        localStorage.setItem("theme", nowDark ? "dark" : "light");
        updateThemeIcon();

        // Opcional: sincronizar también en <html> por si tu CSS lo usa
        if (nowDark) {
            document.documentElement.classList.add("dark-theme");
        } else {
            document.documentElement.classList.remove("dark-theme");
        }
    });

    // -------------------------------------------------------
    // Iniciar sidebar colapsado en escritorio
    // -------------------------------------------------------
    if (window.innerWidth > 768) {
        sidebar.classList.add("collapsed");
        updateThemeIcon();
    }

    // -------------------------------------------------------
    // Cerrar sidebar al hacer clic fuera (móvil)
    // -------------------------------------------------------
    document.addEventListener("click", (e) => {
        const isMobile = window.innerWidth <= 768;
        if (!isMobile) return;

        const clickedInsideSidebar = sidebar.contains(e.target);
        const clickedToggle        = e.target.closest(".sidebar-toggle");

        if (!clickedInsideSidebar && !clickedToggle && !sidebar.classList.contains("collapsed")) {
            sidebar.classList.add("collapsed");
            updateThemeIcon();
        }
    });
});