<!-- Mobile sidebar overlay -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-gray-900 bg-opacity-50 lg:hidden"></div>

<!-- Sidebar -->
<aside 
    :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 lg:translate-x-0 lg:static lg:inset-0"
>
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700 bg-indigo-600 dark:bg-indigo-900">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-white font-bold text-xl">
            <x-application-logo class="w-8 h-8 fill-current text-white" />
            <span>School ERP</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-5 px-4 space-y-1 pb-4">
        <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="fas fa-tachometer-alt">
            {{ __('Dashboard') }}
        </x-nav-link-sidebar>

        @role('Super Admin')
        <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Administration</div>
        <x-nav-link-sidebar :href="route('super-admin.schools.index')" :active="request()->routeIs('super-admin.schools.*')" icon="fas fa-school">
            {{ __('Schools') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('super-admin.admin-users.index')" :active="request()->routeIs('super-admin.admin-users.*')" icon="fas fa-users-cog">
            {{ __('Admins') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('super-admin.payments.index')" :active="request()->routeIs('super-admin.payments.*')" icon="fas fa-money-bill-wave">
            {{ __('Payments') }}
        </x-nav-link-sidebar>
        @endrole

        @role('School Admin')
        <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">School Management</div>
        <x-nav-link-sidebar :href="route('campuses.index')" :active="request()->routeIs('campuses.*')" icon="fas fa-building">
            {{ __('Campuses') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('admin.subscription.index')" :active="request()->routeIs('admin.subscription.*')" icon="fas fa-file-invoice">
            {{ __('Subscription') }}
        </x-nav-link-sidebar>
        @endrole

        @role('Super Admin|School Admin')
        <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Analytics</div>
        <x-nav-link-sidebar :href="route('analytics.index')" :active="request()->routeIs('analytics.index')" icon="fas fa-chart-pie">
            {{ __('Analytics Dashboard') }}
        </x-nav-link-sidebar>

        <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Academic</div>
        <x-nav-link-sidebar :href="route('attendance.index')" :active="request()->routeIs('attendance.*')" icon="fas fa-calendar-check">
            {{ __('Student Attendance') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('teacher-attendance.index')" :active="request()->routeIs('teacher-attendance.*')" icon="fas fa-clipboard-user">
            {{ __('Teacher Attendance') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('exams.index')" :active="request()->routeIs('exams.*')" icon="fas fa-edit">
            {{ __('Exams') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('grades.index')" :active="request()->routeIs('grades.*')" icon="fas fa-star">
            {{ __('Grades') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('marks.index')" :active="request()->routeIs('marks.index') || request()->routeIs('marks.create')" icon="fas fa-marker">
            {{ __('Marks Entry') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('marks.report_card')" :active="request()->routeIs('marks.report_card')" icon="fas fa-file-alt">
            {{ __('Report Cards') }}
        </x-nav-link-sidebar>

        <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Finance</div>
        <x-nav-link-sidebar :href="route('fee-types.index')" :active="request()->routeIs('fee-types.*')" icon="fas fa-tags">
            {{ __('Fee Types') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('fee-structures.index')" :active="request()->routeIs('fee-structures.*')" icon="fas fa-list-alt">
            {{ __('Fee Structures') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('fee-invoices.index')" :active="request()->routeIs('fee-invoices.*')" icon="fas fa-file-invoice-dollar">
            {{ __('Fee Invoices') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('financial-years.index')" :active="request()->routeIs('financial-years.*')" icon="fas fa-calendar-alt">
            {{ __('Financial Years') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('accounting.income.index')" :active="request()->routeIs('accounting.income.*')" icon="fas fa-arrow-circle-down">
            {{ __('Income') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('accounting.expense.index')" :active="request()->routeIs('accounting.expense.*')" icon="fas fa-arrow-circle-up">
            {{ __('Expenses') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('accounting.reports.profit_loss')" :active="request()->routeIs('accounting.reports.profit_loss')" icon="fas fa-chart-line">
            {{ __('Profit & Loss') }}
        </x-nav-link-sidebar>

        <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">HR & Admin</div>
        <x-nav-link-sidebar :href="route('payroll.salaries.index')" :active="request()->routeIs('payroll.*')" icon="fas fa-hand-holding-usd">
            {{ __('Payroll') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('hr.staff.index')" :active="request()->routeIs('hr.*')" icon="fas fa-users">
            {{ __('HR') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('inventory.items.index')" :active="request()->routeIs('inventory.*')" icon="fas fa-boxes">
            {{ __('Inventory') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('transport.vehicles.index')" :active="request()->routeIs('transport.*')" icon="fas fa-bus">
            {{ __('Transport') }}
        </x-nav-link-sidebar>
        @endrole

        @role('Teacher')
        <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Teacher Area</div>
        <x-nav-link-sidebar :href="route('attendance.index')" :active="request()->routeIs('attendance.*')" icon="fas fa-calendar-check">
            {{ __('Take Attendance') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('teacher.my-attendance')" :active="request()->routeIs('teacher.my-attendance')" icon="fas fa-user-clock">
            {{ __('My Attendance') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('hr.leave.my')" :active="request()->routeIs('hr.leave.*')" icon="fas fa-calendar-minus">
            {{ __('My Leave') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('library.my')" :active="request()->routeIs('library.my')" icon="fas fa-book">
            {{ __('My Library') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('marks.index')" :active="request()->routeIs('marks.index') || request()->routeIs('marks.create')" icon="fas fa-marker">
            {{ __('Marks Entry') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('marks.report_card')" :active="request()->routeIs('marks.report_card')" icon="fas fa-file-alt">
            {{ __('Report Cards') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('fee-invoices.index')" :active="request()->routeIs('fee-invoices.*')" icon="fas fa-file-invoice-dollar">
            {{ __('Fee Collection') }}
        </x-nav-link-sidebar>
        @endrole

        @role('Student|Parent')
        <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">My Account</div>
        <x-nav-link-sidebar :href="route('student.my-attendance')" :active="request()->routeIs('student.my-attendance')" icon="fas fa-user-clock">
            {{ __('My Attendance') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('student.report_card')" :active="request()->routeIs('student.report_card')" icon="fas fa-file-alt">
            {{ __('Report Card') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('student.invoices')" :active="request()->routeIs('student.invoices')" icon="fas fa-file-invoice">
            {{ __('My Invoices') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('library.my')" :active="request()->routeIs('library.my')" icon="fas fa-book">
            {{ __('My Library') }}
        </x-nav-link-sidebar>
        @endrole

        <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Communication</div>
        <x-nav-link-sidebar :href="route('communication.notices.index')" :active="request()->routeIs('communication.notices.*')" icon="fas fa-bullhorn">
            {{ __('Notices') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('communication.events.index')" :active="request()->routeIs('communication.events.*')" icon="fas fa-calendar-day">
            {{ __('Events') }}
        </x-nav-link-sidebar>
        <x-nav-link-sidebar :href="route('communication.messages.index')" :active="request()->routeIs('communication.messages.*')" icon="fas fa-envelope">
            {{ __('Messages') }}
        </x-nav-link-sidebar>
    </nav>
</aside>