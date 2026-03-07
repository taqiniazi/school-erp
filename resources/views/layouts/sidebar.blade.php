<div class="sidebar-header">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <i class="fas fa-graduation-cap fa-lg text-primary"></i>
        <span>School ERP</span>
    </a>
</div>

<ul class="list-unstyled components">
    <!-- Dashboard -->
    <li>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>

    <!-- Super Admin -->
    @role('Super Admin')
        <li class="sidebar-heading">ADMINISTRATION</li>
        <li>
            <a href="{{ route('super-admin.schools.index') }}" class="{{ request()->routeIs('super-admin.schools.*') ? 'active' : '' }}">
                <i class="fas fa-school"></i> Schools
            </a>
        </li>
        <li>
            <a href="{{ route('super-admin.admin-users.index') }}" class="{{ request()->routeIs('super-admin.admin-users.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i> Admins
            </a>
        </li>
        <li>
            <a href="{{ route('super-admin.payments.index') }}" class="{{ request()->routeIs('super-admin.payments.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Payments
            </a>
        </li>
    @endrole

    <!-- School Admin -->
    @role('School Admin')
        <li class="sidebar-heading">SCHOOL MANAGEMENT</li>
        <li>
            <a href="{{ route('campuses.index') }}" class="{{ request()->routeIs('campuses.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i> Campuses
            </a>
        </li>
        <li>
            <a href="{{ route('admin.subscription.index') }}" class="{{ request()->routeIs('admin.subscription.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> Subscription
            </a>
        </li>
    @endrole

    <!-- Analytics (Super & School Admin) -->
    @role('Super Admin|School Admin')
        <li class="sidebar-heading">ANALYTICS</li>
        <li>
            <a href="{{ route('analytics.index') }}" class="{{ request()->routeIs('analytics.index') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Analytics
            </a>
        </li>
    @endrole

    <!-- Academic (Super & School Admin) -->
    @role('Super Admin|School Admin')
        <li class="sidebar-heading">ACADEMIC</li>
        <li>
            <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard"></i> Classes
            </a>
        </li>
        <li>
            <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Subjects
            </a>
        </li>
        <li>
            <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i> Students
            </a>
        </li>
        <li>
            <a href="{{ route('teachers.index') }}" class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i> Teachers
            </a>
        </li>
        <li>
            <a href="{{ route('allocations.index') }}" class="{{ request()->routeIs('allocations.*') ? 'active' : '' }}">
                <i class="fas fa-people-arrows"></i> Teacher Allocations
            </a>
        </li>
        <li>
            <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Student Attendance
            </a>
        </li>
        <li>
            <a href="{{ route('teacher-attendance.index') }}" class="{{ request()->routeIs('teacher-attendance.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-user"></i> Teacher Attendance
            </a>
        </li>
        <li>
            <a href="{{ route('exams.index') }}" class="{{ request()->routeIs('exams.*') ? 'active' : '' }}">
                <i class="fas fa-edit"></i> Exams
            </a>
        </li>
        <li>
            <a href="{{ route('grades.index') }}" class="{{ request()->routeIs('grades.*') ? 'active' : '' }}">
                <i class="fas fa-star"></i> Grades
            </a>
        </li>
        <li>
            <a href="{{ route('marks.index') }}" class="{{ request()->routeIs('marks.*') ? 'active' : '' }}">
                <i class="fas fa-marker"></i> Marks Entry
            </a>
        </li>
        <li>
            <a href="{{ route('marks.report_card') }}" class="{{ request()->routeIs('marks.report_card') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Report Cards
            </a>
        </li>
    @endrole

    <!-- HR & Finance (Super & School Admin) -->
    @role('Super Admin|School Admin')
        <li class="sidebar-heading">HR & FINANCE</li>
        <li>
            <a href="{{ route('hr.staff.index') }}" class="{{ request()->routeIs('hr.staff.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Staff Directory
            </a>
        </li>
        <li>
            <a href="{{ route('hr.leave.index') }}" class="{{ request()->routeIs('hr.leave.*') ? 'active' : '' }}">
                <i class="fas fa-envelope-open-text"></i> Leave Requests
            </a>
        </li>
        <li>
            <a href="{{ route('payroll.salaries.index') }}" class="{{ request()->routeIs('payroll.salaries.*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-usd"></i> Payroll
            </a>
        </li>
        <li>
            <a href="{{ route('fee-structures.index') }}" class="{{ request()->routeIs('fee-structures.*') ? 'active' : '' }}">
                <i class="fas fa-coins"></i> Fee Structures
            </a>
        </li>
        <li>
            <a href="{{ route('fee-invoices.index') }}" class="{{ request()->routeIs('fee-invoices.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> Fee Invoices
            </a>
        </li>
        <li>
            <a href="{{ route('fee-payments.history') }}" class="{{ request()->routeIs('fee-payments.*') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Payment History
            </a>
        </li>
        <li>
            <a href="{{ route('accounting.income.index') }}" class="{{ request()->routeIs('accounting.income.*') ? 'active' : '' }}">
                <i class="fas fa-arrow-up"></i> Income
            </a>
        </li>
        <li>
            <a href="{{ route('accounting.expense.index') }}" class="{{ request()->routeIs('accounting.expense.*') ? 'active' : '' }}">
                <i class="fas fa-arrow-down"></i> Expenses
            </a>
        </li>
    @endrole

    <!-- Modules (Inventory, Library, Transport, Communication) -->
    @role('Super Admin|School Admin')
        <li class="sidebar-heading">MODULES</li>
        <li>
            <a href="{{ route('inventory.items.index') }}" class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i> Inventory
            </a>
        </li>
        <li>
            <a href="{{ route('library.books.index') }}" class="{{ request()->routeIs('library.*') ? 'active' : '' }}">
                <i class="fas fa-book-reader"></i> Library
            </a>
        </li>
        <li>
            <a href="{{ route('transport.routes.index') }}" class="{{ request()->routeIs('transport.*') ? 'active' : '' }}">
                <i class="fas fa-bus"></i> Transport
            </a>
        </li>
        <li>
            <a href="{{ route('communication.notices.index') }}" class="{{ request()->routeIs('communication.notices.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i> Notices
            </a>
        </li>
        <li>
            <a href="{{ route('communication.events.index') }}" class="{{ request()->routeIs('communication.events.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Events
            </a>
        </li>
        <li>
            <a href="{{ route('communication.messages.index') }}" class="{{ request()->routeIs('communication.messages.*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Messages
            </a>
        </li>
        <li>
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Reports
            </a>
        </li>
    @endrole

    <!-- Teacher Role -->
    @role('Teacher')
        <li class="sidebar-heading">TEACHER PORTAL</li>
        <li>
            <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('teacher.my-attendance') }}" class="{{ request()->routeIs('teacher.my-attendance') ? 'active' : '' }}">
                <i class="fas fa-user-check"></i> My Attendance
            </a>
        </li>
        <li>
            <a href="{{ route('hr.leave.my') }}" class="{{ request()->routeIs('hr.leave.my') || request()->routeIs('hr.leave.create') ? 'active' : '' }}">
                <i class="fas fa-calendar-minus"></i> Leave Requests
            </a>
        </li>
        <li>
            <a href="{{ route('library.my') }}" class="{{ request()->routeIs('library.my') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Library Books
            </a>
        </li>
        <li>
            <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Class Attendance
            </a>
        </li>
    @endrole

    <!-- Student Role -->
    @role('Student')
        <li class="sidebar-heading">STUDENT PORTAL</li>
        <li>
            <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('student.my-attendance') }}" class="{{ request()->routeIs('student.my-attendance') ? 'active' : '' }}">
                <i class="fas fa-user-check"></i> My Attendance
            </a>
        </li>
        <li>
            <a href="{{ route('student.invoices') }}" class="{{ request()->routeIs('student.invoices') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> My Invoices
            </a>
        </li>
        <li>
            <a href="{{ route('student.report_card') }}" class="{{ request()->routeIs('student.report_card') ? 'active' : '' }}">
                <i class="fas fa-poll"></i> Report Card
            </a>
        </li>
        <li>
            <a href="{{ route('library.my') }}" class="{{ request()->routeIs('library.my') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Library Books
            </a>
        </li>
    @endrole

    <!-- Parent Role -->
    @role('Parent')
        <li class="sidebar-heading">PARENT PORTAL</li>
        <li>
            <a href="{{ route('parent.dashboard') }}" class="{{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('student.my-attendance') }}" class="{{ request()->routeIs('student.my-attendance') ? 'active' : '' }}">
                <i class="fas fa-user-check"></i> Children Attendance
            </a>
        </li>
        <li>
            <a href="{{ route('student.invoices') }}" class="{{ request()->routeIs('student.invoices') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> Fee Invoices
            </a>
        </li>
        <li>
            <a href="{{ route('student.report_card') }}" class="{{ request()->routeIs('student.report_card') ? 'active' : '' }}">
                <i class="fas fa-poll"></i> Report Cards
            </a>
        </li>
        <li>
            <a href="{{ route('library.my') }}" class="{{ request()->routeIs('library.my') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Library Books
            </a>
        </li>
    @endrole
</ul>