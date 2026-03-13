import './bootstrap';

// Alpine.js is removed as we are using Bootstrap 5
// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();

function getCsrfToken() {
    const el = document.querySelector('meta[name="csrf-token"]');
    return el ? el.getAttribute('content') : null;
}

function getTheme() {
    return document.documentElement.dataset.bsTheme || 'light';
}

function setTheme(theme) {
    document.documentElement.dataset.bsTheme = theme;
    document.documentElement.classList.toggle('dark', theme === 'dark');
    localStorage.setItem('ui.theme', theme);
}

function initThemeToggle() {
    const toggle = document.getElementById('themeToggle');
    if (!toggle) return;

    const icon = toggle.querySelector('i');
    const updateIcon = () => {
        if (!icon) return;
        const theme = getTheme();
        icon.classList.toggle('fa-moon', theme !== 'dark');
        icon.classList.toggle('fa-sun', theme === 'dark');
    };

    updateIcon();

    toggle.addEventListener('click', async () => {
        const next = getTheme() === 'dark' ? 'light' : 'dark';
        setTheme(next);
        updateIcon();

        const csrf = getCsrfToken();
        if (!csrf) return;

        try {
            await fetch('/ui/settings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ theme: next }),
            });
        } catch (e) {
        }
    });
}

function initNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    if (!dropdown) return;

    const list = document.getElementById('notificationList');
    const badge = document.getElementById('notificationBadge');
    const markAllBtn = document.getElementById('markAllReadBtn');

    const endpoint = dropdown.getAttribute('data-notifications-endpoint');
    const markAllEndpoint = dropdown.getAttribute('data-notifications-mark-all-read');
    const indexUrl = dropdown.getAttribute('data-notifications-index-url');

    if (!endpoint || !list || !badge) return;

    const setBadge = (count) => {
        const n = Number(count) || 0;
        badge.textContent = String(n);
        badge.classList.toggle('d-none', n <= 0);
    };

    const renderList = (items) => {
        list.innerHTML = '';

        if (!items || items.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'px-3 py-3 text-center text-muted small';
            empty.textContent = 'No new notifications';
            list.appendChild(empty);
            return;
        }

        items.forEach((item) => {
            const a = document.createElement('a');
            a.className = 'list-group-item list-group-item-action border-0 px-3 py-3';
            a.href = item.url || indexUrl || '#';

            const row = document.createElement('div');
            row.className = 'd-flex align-items-start';

            const iconWrap = document.createElement('div');
            iconWrap.className = 'bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3';
            iconWrap.innerHTML = '<i class="fas fa-bell"></i>';

            const body = document.createElement('div');

            const title = document.createElement('p');
            title.className = 'mb-1 small text-dark fw-medium';
            title.textContent = item.title || 'Notification';

            const meta = document.createElement('small');
            meta.className = 'text-muted';
            meta.style.fontSize = '0.75rem';
            meta.textContent = item.created_human || '';

            body.appendChild(title);
            body.appendChild(meta);

            row.appendChild(iconWrap);
            row.appendChild(body);
            a.appendChild(row);
            list.appendChild(a);
        });
    };

    const fetchNotifications = async () => {
        try {
            const res = await fetch(`${endpoint}?limit=5`, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();
            setBadge(data.unread_count);
            renderList(data.items);
        } catch (e) {
        }
    };

    fetchNotifications();

    dropdown.addEventListener('show.bs.dropdown', () => {
        fetchNotifications();
    });

    const pollMs = 30000;
    window.setInterval(fetchNotifications, pollMs);

    if (markAllBtn && markAllEndpoint) {
        markAllBtn.addEventListener('click', async () => {
            const csrf = getCsrfToken();
            if (!csrf) return;

            try {
                const res = await fetch(markAllEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({}),
                });

                if (res.ok) {
                    await fetchNotifications();
                }
            } catch (e) {
            }
        });
    }
}

function getDashboardKey() {
    const el = document.querySelector('[data-dashboard-grid][data-dashboard-key]');
    return el ? el.getAttribute('data-dashboard-key') : null;
}

function getDashboardStorageKey(dashboardKey) {
    return `ui.dashboard.${dashboardKey}`;
}

function loadDashboardConfig(dashboardKey) {
    const raw = localStorage.getItem(getDashboardStorageKey(dashboardKey));
    if (!raw) return { order: [], hidden: [] };
    try {
        const parsed = JSON.parse(raw);
        return {
            order: Array.isArray(parsed.order) ? parsed.order : [],
            hidden: Array.isArray(parsed.hidden) ? parsed.hidden : [],
        };
    } catch {
        return { order: [], hidden: [] };
    }
}

function saveDashboardConfig(dashboardKey, config) {
    localStorage.setItem(getDashboardStorageKey(dashboardKey), JSON.stringify(config));
}

async function syncDashboardConfig(dashboardKey, config) {
    const csrf = getCsrfToken();
    if (!csrf) return;

    try {
        await fetch('/ui/settings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                dashboard: {
                    [dashboardKey]: config,
                },
            }),
        });
    } catch (e) {
    }
}

function applyDashboardConfig(grid, config) {
    const widgets = Array.from(grid.querySelectorAll('[data-widget-key]'));
    const widgetByKey = new Map(widgets.map((w) => [w.getAttribute('data-widget-key'), w]));

    if (Array.isArray(config.order) && config.order.length > 0) {
        config.order.forEach((key) => {
            const el = widgetByKey.get(key);
            if (el) grid.appendChild(el);
        });
    }

    const hiddenSet = new Set(Array.isArray(config.hidden) ? config.hidden : []);
    widgets.forEach((w) => {
        const key = w.getAttribute('data-widget-key');
        w.classList.toggle('d-none', hiddenSet.has(key));
    });
}

function initDashboard() {
    const grid = document.querySelector('[data-dashboard-grid]');
    if (!grid) return;

    const dashboardKey = getDashboardKey();
    if (!dashboardKey) return;

    const config = loadDashboardConfig(dashboardKey);
    applyDashboardConfig(grid, config);

    const modalEl = document.getElementById('dashboardCustomizeModal');
    if (modalEl) {
        const inputs = Array.from(modalEl.querySelectorAll('input[type="checkbox"][data-widget-key]'));
        const hiddenSet = new Set(config.hidden);
        inputs.forEach((input) => {
            const key = input.getAttribute('data-widget-key');
            input.checked = !hiddenSet.has(key);
        });

        modalEl.addEventListener('change', (e) => {
            const target = e.target;
            if (!(target instanceof HTMLInputElement)) return;
            if (target.type !== 'checkbox') return;
            const key = target.getAttribute('data-widget-key');
            if (!key) return;

            const cfg = loadDashboardConfig(dashboardKey);
            const hidden = new Set(cfg.hidden);
            if (target.checked) {
                hidden.delete(key);
            } else {
                hidden.add(key);
            }
            cfg.hidden = Array.from(hidden);
            saveDashboardConfig(dashboardKey, cfg);
            applyDashboardConfig(grid, cfg);
            syncDashboardConfig(dashboardKey, cfg);
        });
    }

    if (window.Sortable) {
        new window.Sortable(grid, {
            animation: 150,
            handle: '.widget-handle',
            onEnd: () => {
                const keys = Array.from(grid.querySelectorAll('[data-widget-key]')).map((el) =>
                    el.getAttribute('data-widget-key')
                ).filter(Boolean);
                const cfg = loadDashboardConfig(dashboardKey);
                cfg.order = keys;
                saveDashboardConfig(dashboardKey, cfg);
                syncDashboardConfig(dashboardKey, cfg);
            },
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
    initNotifications();
    initDashboard();
});
