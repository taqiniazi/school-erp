<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
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
                    @endrole

                    @role('School Admin')
                    <x-nav-link :href="route('campuses.index')" :active="request()->routeIs('campuses.*')">
                        {{ __('Campuses') }}
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
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @role('Super Admin')
            <x-responsive-nav-link :href="route('super-admin.schools.index')" :active="request()->routeIs('super-admin.schools.*')">
                {{ __('Schools') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('super-admin.admin-users.index')" :active="request()->routeIs('super-admin.admin-users.*')">
                {{ __('Admins') }}
            </x-responsive-nav-link>
            @endrole

            @role('School Admin')
            <x-responsive-nav-link :href="route('campuses.index')" :active="request()->routeIs('campuses.*')">
                {{ __('Campuses') }}
            </x-responsive-nav-link>
            @endrole

            <!-- Communication -->
            <x-responsive-nav-link :href="route('communication.notices.index')" :active="request()->routeIs('communication.notices.*')">
                {{ __('Notices') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('communication.events.index')" :active="request()->routeIs('communication.events.*')">
                {{ __('Events') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('communication.messages.index')" :active="request()->routeIs('communication.messages.*')">
                {{ __('Messages') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
