<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            @include('layouts.sidebar')
        </nav>

        <!-- Main Content Wrapper -->
        <div id="content">
            <!-- Topbar -->
            @include('layouts.topbar')

            <!-- Main Content -->
            <main class="flex-grow-1 p-4 bg-light">
                <div class="container-fluid">
                    @if (isset($header))
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                            <h1 class="h3 fw-bold text-dark">{{ $header }}</h1>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
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
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-enable DataTables on listing tables (skip dashboards and tables marked .no-datatable)
            if (window.jQuery && jQuery.fn && jQuery.fn.DataTable) {
                const $ = jQuery;
                $('table.table').each(function () {
                    const $tbl = $(this);
                    // Skip if explicitly disabled, lacks a thead, or inside a container marked as dashboard
                    if ($tbl.hasClass('no-datatable')) return;
                    if ($tbl.find('thead').length === 0) return;
                    if ($tbl.closest('.dashboard, [data-page-type=\"dashboard\"]').length) return;
                    if ($tbl.data('dt-initialized')) return;
                    try {
                        $tbl.DataTable({
                            paging: true,
                            pageLength: 10,
                            lengthChange: true,
                            ordering: true,
                            order: [],
                            responsive: true,
                            autoWidth: false,
                            language: {
                                search: 'Search:',
                                lengthMenu: 'Show _MENU_',
                                info: 'Showing _START_ to _END_ of _TOTAL_',
                                infoEmpty: 'No entries',
                            }
                        });
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

            // Global Confirmation Modal Logic
            const confirmationModalEl = document.getElementById('confirmationModal');
            if (confirmationModalEl) {
                const confirmationModal = new bootstrap.Modal(confirmationModalEl);
                const confirmButton = document.getElementById('confirmButton');
                const confirmationMessage = document.getElementById('confirmationMessage');
                let targetForm = null;

                // Handle forms with data-confirm-message attribute
                document.addEventListener('submit', function(e) {
                    const form = e.target;
                    const message = form.getAttribute('data-confirm-message');
                    
                    if (message) {
                        e.preventDefault();
                        targetForm = form;
                        confirmationMessage.textContent = message;
                        
                        // Check if it's a delete/danger action
                        if (form.getAttribute('data-confirm-style') === 'danger' || message.toLowerCase().includes('delete') || message.toLowerCase().includes('cancel')) {
                            confirmButton.classList.remove('btn-primary');
                            confirmButton.classList.add('btn-danger');
                        } else {
                            confirmButton.classList.remove('btn-danger');
                            confirmButton.classList.add('btn-primary');
                        }
                        
                        confirmationModal.show();
                    }
                });

                confirmButton.addEventListener('click', function() {
                    if (targetForm) {
                        // Remove the attribute to prevent the listener from triggering again
                        targetForm.removeAttribute('data-confirm-message');
                        targetForm.submit();
                        confirmationModal.hide();
                    }
                });
            }
        });
    </script>
    
    @include('components.confirm-modal')
    @stack('scripts')
</body>
</html>


