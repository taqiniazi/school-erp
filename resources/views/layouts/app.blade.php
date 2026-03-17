<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        (function () {
            const serverTheme = @json(auth()->check() ? data_get(auth()->user()->ui_settings, 'theme') : null);
            const storedTheme = localStorage.getItem('ui.theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = storedTheme ?? serverTheme ?? (prefersDark ? 'dark' : 'light');
            document.documentElement.dataset.bsTheme = theme;
            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/inter.css') }}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/all.min.css') }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- DataTables (local) -->
    <link href="{{ asset('vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    
    <!-- Custom CSS for Admin Panel -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
    
    <!-- Chart.js -->
    <script src="{{ asset('js/chart.js') }}"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
    <div class="wrapper admin-shell">
        <!-- Sidebar -->
        <nav id="sidebar">
            @include('layouts.sidebar')
        </nav>

        <!-- Main Content Wrapper -->
        <div id="content">
            <!-- Topbar -->
            @include('layouts.topbar')

            <!-- Main Content -->
            <main class="flex-grow-1 p-4 bg-body-tertiary admin-main">
                <div class="container-fluid">
                    @if (isset($header))
                        @php
                            $headerValue = trim((string) $header);
                            $headerHasHtml = \Illuminate\Support\Str::contains($headerValue, '<');
                        @endphp

                        <div class="page-header">
                            @if ($headerHasHtml)
                                {!! $header !!}
                            @else
                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                                    <h1 class="h3 fw-bold text-dark mb-0">{{ $header }}</h1>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div id="ajaxAlertContainer"></div>

                    @if(!empty($flashSuccess))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $flashSuccess }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <ul class="mb-0 list-unstyled">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery + DataTables (local) -->
    <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/Sortable.min.js') }}"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        function cleanupOverlays() {
            const hasShownModal = document.querySelector('.modal.show, .modal.showing, .offcanvas.show, .offcanvas.showing');
            if (hasShownModal) return;
            document.querySelectorAll('.modal-backdrop, .offcanvas-backdrop').forEach((el) => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
        }

        window.addEventListener('pageshow', cleanupOverlays);

        document.addEventListener('DOMContentLoaded', function() {
            cleanupOverlays();
            window.setTimeout(cleanupOverlays, 50);
            window.setTimeout(cleanupOverlays, 300);

            if (window.jQuery && jQuery.fn && jQuery.fn.DataTable) {
                const $ = jQuery;
                if ($.fn.dataTable && $.fn.dataTable.ext && $.fn.dataTable.ext.errMode) {
                    $.fn.dataTable.ext.errMode = 'none';
                }
                $('table.table').each(function () {
                    const $tbl = $(this);
                    if ($tbl.hasClass('no-datatable')) return;
                    if ($tbl.find('thead').length === 0) return;
                    if ($tbl.closest('.dashboard, [data-page-type=\"dashboard\"]').length) return;
                    if ($tbl.data('dt-initialized')) return;
                    const headerCount = $tbl.find('thead th').length;
                    const $rows = $tbl.find('tbody tr');
                    if ($rows.length === 1) {
                        const $cells = $rows.eq(0).children('td');
                        if ($cells.length !== headerCount || $cells.attr('colspan')) {
                            const msg = ($cells.text() || '').trim();
                            $rows.remove();
                            $tbl.data('dt-empty-msg', msg || 'No data available');
                        }
                    }
                    try {
                        const language = {
                            search: 'Search:',
                            lengthMenu: 'Show _MENU_',
                            info: 'Showing _START_ to _END_ of _TOTAL_',
                            infoEmpty: 'No entries',
                            emptyTable: $tbl.data('dt-empty-msg') || 'No data available'
                        };
                        const dom = $tbl.attr('data-dt-dom');
                        const paging = $tbl.attr('data-dt-paging');
                        const lengthChange = $tbl.attr('data-dt-length-change');
                        const searching = $tbl.attr('data-dt-searching');
                        const pageLengthAttr = $tbl.attr('data-dt-page-length');
                        const pageLength = pageLengthAttr ? parseInt(pageLengthAttr, 10) : 10;

                        const dt = $tbl.DataTable({
                            paging: paging !== 'false',
                            pageLength: Number.isFinite(pageLength) ? pageLength : 10,
                            lengthChange: lengthChange !== 'false',
                            searching: searching !== 'false',
                            ordering: true,
                            order: [],
                            responsive: true,
                            autoWidth: false,
                            language,
                            ...(dom ? { dom } : {}),
                        });

                        const tableId = $tbl.attr('id');
                        if (tableId) {
                            document.querySelectorAll(`[data-dt-target="${tableId}"]`).forEach((input) => {
                                if (!(input instanceof HTMLInputElement)) return;
                                if (input.dataset.dtBound) return;
                                input.dataset.dtBound = '1';
                                input.addEventListener('input', function () {
                                    dt.search(input.value || '').draw();
                                });
                            });
                        }
                        $tbl.data('dt-initialized', true);
                    } catch (e) {
                        console.error('DataTable init failed for a table:', e);
                    }
                });
            }

            const sidebar = document.getElementById('sidebar');
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            
            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }

            const confirmationModalEl = document.getElementById('confirmationModal');
            if (confirmationModalEl) {
                const confirmationModal = new bootstrap.Modal(confirmationModalEl);
                const confirmButton = document.getElementById('confirmButton');
                const confirmationMessage = document.getElementById('confirmationMessage');
                const alertContainer = document.getElementById('ajaxAlertContainer');
                let targetAction = null;
                let isAjax = false;

                function escapeHtml(text) {
                    return String(text)
                        .replaceAll('&', '&amp;')
                        .replaceAll('<', '&lt;')
                        .replaceAll('>', '&gt;')
                        .replaceAll('"', '&quot;')
                        .replaceAll("'", '&#039;');
                }

                function showAlert(type, message) {
                    if (!alertContainer) return;
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = `
                        <div class="alert alert-${escapeHtml(type)} alert-dismissible fade show shadow-sm border-0" role="alert">
                            ${escapeHtml(message)}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    alertContainer.appendChild(wrapper.firstElementChild);
                    window.setTimeout(() => {
                        const el = alertContainer.querySelector('.alert');
                        if (!el) return;
                        const alert = bootstrap.Alert.getOrCreateInstance(el);
                        alert.close();
                    }, 3500);
                }

                function getConfirmMessageFromInline(handler) {
                    if (!handler) return null;
                    const m = String(handler).match(/confirm\((['"])(.*?)\1\)/);
                    return m ? m[2] : null;
                }

                function isDeleteForm(form) {
                    if (!form) return false;
                    const methodAttr = (form.getAttribute('method') || '').toLowerCase();
                    if (methodAttr === 'delete') return true;
                    const methodInput = form.querySelector('input[name="_method"]');
                    return methodAttr === 'post' && methodInput && String(methodInput.value).toUpperCase() === 'DELETE';
                }

                async function ajaxSubmitForm(form) {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json, text/plain, */*',
                        },
                        body: formData,
                        redirect: 'follow',
                    });

                    if (!response.ok) {
                        let message = 'Request failed.';
                        try {
                            const data = await response.json();
                            if (data?.message) message = data.message;
                        } catch (_) {
                        }
                        throw new Error(message);
                    }
                }

                function removeRowForForm(form) {
                    const tr = form.closest('tr');
                    if (!tr) return;
                    const table = tr.closest('table');
                    if (window.jQuery && table) {
                        const $ = window.jQuery;
                        const $tbl = $(table);
                        if ($tbl.data('dt-initialized') && $.fn.DataTable) {
                            const dt = $tbl.DataTable();
                            dt.row(tr).remove().draw(false);
                            return;
                        }
                    }
                    tr.remove();
                }

                document.addEventListener(
                    'submit',
                    function (e) {
                    const form = e.target;

                    if (!(form instanceof HTMLFormElement)) return;

                    const forceConfirm = isDeleteForm(form);
                    const message =
                        form.getAttribute('data-confirm-message') ||
                        getConfirmMessageFromInline(form.getAttribute('onsubmit')) ||
                        (forceConfirm ? 'Delete this record?' : null);

                    if (message && !form.dataset.skipConfirm) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        targetAction = { type: 'form', el: form };
                        isAjax = forceConfirm;
                        confirmationMessage.textContent = message;

                        if (forceConfirm || form.getAttribute('data-confirm-style') === 'danger' || message.toLowerCase().includes('delete') || message.toLowerCase().includes('cancel')) {
                            confirmButton.classList.remove('btn-primary');
                            confirmButton.classList.add('btn-danger');
                        } else {
                            confirmButton.classList.remove('btn-danger');
                            confirmButton.classList.add('btn-primary');
                        }
                        
                        confirmationModal.show();
                    }
                    },
                    true
                );

                document.addEventListener(
                    'click',
                    function (e) {
                        const el = e.target instanceof Element ? e.target.closest('[onclick]') : null;
                        if (!el) return;
                        const inline = el.getAttribute('onclick');
                        const message = getConfirmMessageFromInline(inline);
                        if (!message) return;
                        e.preventDefault();
                        e.stopPropagation();

                        const form = el.closest('form');
                        if (form && isDeleteForm(form)) {
                            targetAction = { type: 'form', el: form };
                            isAjax = true;
                        } else if (form) {
                            targetAction = { type: 'form', el: form };
                            isAjax = false;
                        } else {
                            targetAction = { type: 'link', el };
                            isAjax = false;
                        }

                        confirmationMessage.textContent = message;
                        confirmButton.classList.remove('btn-primary');
                        confirmButton.classList.add('btn-danger');
                        confirmationModal.show();
                    },
                    true
                );

                confirmButton.addEventListener('click', async function() {
                    if (!targetAction) return;
                    confirmButton.disabled = true;

                    try {
                        if (targetAction.type === 'form') {
                            const form = targetAction.el;
                            if (isAjax) {
                                await ajaxSubmitForm(form);
                                removeRowForForm(form);
                                showAlert('success', 'Deleted successfully.');
                            } else {
                                form.dataset.skipConfirm = '1';
                                form.submit();
                            }
                        } else if (targetAction.type === 'link') {
                            window.location.href = targetAction.el.getAttribute('href') || '#';
                        }
                        confirmationModal.hide();
                    } catch (err) {
                        showAlert('danger', err?.message || 'Delete failed.');
                    } finally {
                        confirmButton.disabled = false;
                        if (targetAction?.type === 'form') {
                            delete targetAction.el.dataset.skipConfirm;
                        }
                        targetAction = null;
                        isAjax = false;
                    }
                });
            }
        });
    </script>
    
    @include('components.confirm-modal')
    @stack('scripts')
</body>
</html>
