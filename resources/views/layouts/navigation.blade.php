<nav class="navbar navbar-expand-lg navbar-light bg-body border-bottom shadow-sm sticky-top">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-text-top text-primary" style="height: 30px; width: auto;" />
        </a>

        <!-- Hamburger -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>

                @role('Super Admin')
                <x-nav-link :href="route('super-admin.schools.index')" :active="request()->routeIs('super-admin.schools.*')">
                    {{ __('Schools') }}
                </x-nav-link>
                 <x-nav-link :href="route('super-admin.admin-users.index')" :active="request()->routeIs('super-admin.admin-users.*')">
                    {{ __('Admins') }}
                </x-nav-link>
                <x-nav-link :href="route('super-admin.payments.index')" :active="request()->routeIs('super-admin.payments.*')">
                    {{ __('Payments') }}
                </x-nav-link>
                @endrole

                @role('School Admin')
                <x-nav-link :href="route('campuses.index')" :active="request()->routeIs('campuses.*')">
                    {{ __('Campuses') }}
                </x-nav-link>
                <x-nav-link :href="route('admin.subscription.index')" :active="request()->routeIs('admin.subscription.*')">
                    {{ __('Subscription') }}
                </x-nav-link>
                @endrole

                @role('Super Admin|School Admin')
                <x-nav-link :href="route('attendance.index')" :active="request()->routeIs('attendance.*')">
                    {{ __('Student Attendance') }}
                </x-nav-link>
                <x-nav-link :href="route('teacher-attendance.index')" :active="request()->routeIs('teacher-attendance.*')">
                    {{ __('Teacher Attendance') }}
                </x-nav-link>
                <x-nav-link :href="route('exams.index')" :active="request()->routeIs('exams.*')">
                    {{ __('Exams') }}
                </x-nav-link>
                <x-nav-link :href="route('grades.index')" :active="request()->routeIs('grades.*')">
                    {{ __('Grades') }}
                </x-nav-link>
                <x-nav-link :href="route('marks.index')" :active="request()->routeIs('marks.index') || request()->routeIs('marks.create')">
                    {{ __('Marks Entry') }}
                </x-nav-link>
                <x-nav-link :href="route('marks.report_card')" :active="request()->routeIs('marks.report_card')">
                    {{ __('Report Cards') }}
                </x-nav-link>
                <x-nav-link :href="route('fee-types.index')" :active="request()->routeIs('fee-types.*')">
                    {{ __('Fee Types') }}
                </x-nav-link>
                <x-nav-link :href="route('fee-structures.index')" :active="request()->routeIs('fee-structures.*')">
                    {{ __('Fee Structures') }}
                </x-nav-link>
                <x-nav-link :href="route('fee-invoices.index')" :active="request()->routeIs('fee-invoices.*')">
                    {{ __('Fee Invoices') }}
                </x-nav-link>
                <x-nav-link :href="route('financial-years.index')" :active="request()->routeIs('financial-years.*')">
                    {{ __('Financial Years') }}
                </x-nav-link>
                <x-nav-link :href="route('accounting.income.index')" :active="request()->routeIs('accounting.income.*')">
                    {{ __('Income') }}
                </x-nav-link>
                <x-nav-link :href="route('accounting.expense.index')" :active="request()->routeIs('accounting.expense.*')">
                    {{ __('Expenses') }}
                </x-nav-link>
                <x-nav-link :href="route('accounting.reports.profit_loss')" :active="request()->routeIs('accounting.reports.profit_loss')">
                    {{ __('Profit & Loss') }}
                </x-nav-link>
                <x-nav-link :href="route('payroll.salaries.index')" :active="request()->routeIs('payroll.*')">
                    {{ __('Payroll') }}
                </x-nav-link>
                <x-nav-link :href="route('hr.staff.index')" :active="request()->routeIs('hr.*')">
                    {{ __('HR') }}
                </x-nav-link>
                <x-nav-link :href="route('inventory.items.index')" :active="request()->routeIs('inventory.*')">
                    {{ __('Inventory') }}
                </x-nav-link>
                <x-nav-link :href="route('transport.vehicles.index')" :active="request()->routeIs('transport.*')">
                    {{ __('Transport') }}
                </x-nav-link>
                @endrole

                @role('Teacher')
                <x-nav-link :href="route('attendance.index')" :active="request()->routeIs('attendance.*')">
                    {{ __('Take Attendance') }}
                </x-nav-link>
                <x-nav-link :href="route('teacher.my-attendance')" :active="request()->routeIs('teacher.my-attendance')">
                    {{ __('My Attendance') }}
                </x-nav-link>
                <x-nav-link :href="route('hr.leave.my')" :active="request()->routeIs('hr.leave.*')">
                    {{ __('My Leave') }}
                </x-nav-link>
                <x-nav-link :href="route('library.my')" :active="request()->routeIs('library.my')">
                    {{ __('My Library') }}
                </x-nav-link>
                <x-nav-link :href="route('marks.index')" :active="request()->routeIs('marks.index') || request()->routeIs('marks.create')">
                    {{ __('Marks Entry') }}
                </x-nav-link>
                <x-nav-link :href="route('marks.report_card')" :active="request()->routeIs('marks.report_card')">
                    {{ __('Report Cards') }}
                </x-nav-link>
                <x-nav-link :href="route('fee-invoices.index')" :active="request()->routeIs('fee-invoices.*')">
                    {{ __('Fee Collection') }}
                </x-nav-link>
                @endrole

                @role('Student|Parent')
                <x-nav-link :href="route('student.my-attendance')" :active="request()->routeIs('student.my-attendance')">
                    {{ __('My Attendance') }}
                </x-nav-link>
                <x-nav-link :href="route('student.report_card')" :active="request()->routeIs('student.report_card')">
                    {{ __('Report Card') }}
                </x-nav-link>
                <x-nav-link :href="route('student.invoices')" :active="request()->routeIs('student.invoices')">
                    {{ __('My Invoices') }}
                </x-nav-link>
                <x-nav-link :href="route('library.my')" :active="request()->routeIs('library.my')">
                    {{ __('My Library') }}
                </x-nav-link>
                @endrole

                <!-- Communication (All Roles) -->
                <x-nav-link :href="route('communication.notices.index')" :active="request()->routeIs('communication.notices.*')">
                    {{ __('Notices') }}
                </x-nav-link>
                <x-nav-link :href="route('communication.events.index')" :active="request()->routeIs('communication.events.*')">
                    {{ __('Events') }}
                </x-nav-link>
                <x-nav-link :href="route('communication.messages.index')" :active="request()->routeIs('communication.messages.*')">
                    {{ __('Messages') }}
                </x-nav-link>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <hr class="dropdown-divider">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

