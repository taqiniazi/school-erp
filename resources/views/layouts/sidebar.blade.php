<div class="sidebar-header">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <i class="fas fa-graduation-cap fa-lg"></i>
        <span>School ERP</span>
    </a>
</div>

<ul class="list-unstyled components" id="sidebarAccordion">
    <!-- Dashboard -->
    <li>
        @if(auth()->check() && auth()->user()->hasRole('Super Admin'))
            <a href="{{ route('super-admin.dashboard') }}" class="{{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        @elseif(auth()->check() && auth()->user()->hasRole('School Admin'))
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        @endif
    </li>

    @if(auth()->check() && auth()->user()->hasAnyRole(['Super Admin', 'School Admin']))
    
    <!-- School Management -->
    <li>
        <a href="#schoolSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('super-admin.schools.*') || request()->routeIs('campuses.*') || request()->routeIs('departments.*') || request()->routeIs('designations.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('super-admin.schools.*') || request()->routeIs('campuses.*') || request()->routeIs('departments.*') || request()->routeIs('designations.*') ? 'active' : '' }} {{ request()->routeIs('super-admin.schools.*') || request()->routeIs('campuses.*') || request()->routeIs('departments.*') || request()->routeIs('designations.*') ? '' : 'collapsed' }}">
            <i class="fas fa-university"></i> School Management
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('super-admin.schools.*') || request()->routeIs('campuses.*') || request()->routeIs('departments.*') || request()->routeIs('designations.*') ? 'show' : '' }}" id="schoolSubmenu" data-bs-parent="#sidebarAccordion">
            @if(auth()->check() && auth()->user()->hasRole('Super Admin'))
            <li>
                <a href="{{ route('super-admin.schools.index') }}" class="{{ request()->routeIs('super-admin.schools.*') ? 'active' : '' }}">Schools</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('School Admin'))
            <li>
                <a href="{{ route('campuses.index') }}" class="{{ request()->routeIs('campuses.*') ? 'active' : '' }}">Campuses</a>
            </li>
            @endif
            <li>
                <a href="{{ route('departments.index') }}" class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">Departments</a>
            </li>
            <li>
                <a href="{{ route('designations.index') }}" class="{{ request()->routeIs('designations.*') ? 'active' : '' }}">Designations</a>
            </li>
        </ul>
    </li>

    <!-- User Management -->
    <li>
        <a href="#userSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('super-admin.admin-users.*') || request()->routeIs('super-admin.roles.*') || request()->routeIs('permissions.*') || request()->routeIs('admin.audit-logs.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('super-admin.admin-users.*') || request()->routeIs('super-admin.roles.*') || request()->routeIs('permissions.*') || request()->routeIs('admin.audit-logs.*') ? 'active' : '' }} {{ request()->routeIs('super-admin.admin-users.*') || request()->routeIs('super-admin.roles.*') || request()->routeIs('permissions.*') || request()->routeIs('admin.audit-logs.*') ? '' : 'collapsed' }}">
            <i class="fas fa-users-cog"></i> User Management
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('super-admin.admin-users.*') || request()->routeIs('super-admin.roles.*') || request()->routeIs('permissions.*') || request()->routeIs('admin.audit-logs.*') ? 'show' : '' }}" id="userSubmenu" data-bs-parent="#sidebarAccordion">
            @if(auth()->check() && auth()->user()->hasRole('Super Admin'))
            <li>
                <a href="{{ route('super-admin.admin-users.index') }}" class="{{ request()->routeIs('super-admin.admin-users.*') ? 'active' : '' }}">Users</a>
            </li>
            <li>
                <a href="{{ route('super-admin.roles.index') }}" class="{{ request()->routeIs('super-admin.roles.*') ? 'active' : '' }}">Roles</a>
            </li>
            @endif
            <li>
                <a href="{{ route('permissions.index') }}" class="{{ request()->routeIs('permissions.*') ? 'active' : '' }}">Permissions</a>
            </li>
            <li>
                <a href="{{ route('admin.audit-logs.index') }}" class="{{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">Activity Logs</a>
            </li>
        </ul>
    </li>

    <!-- Student Management -->
    <li>
        <a href="#studentSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('students.*') || request()->routeIs('admissions.*') || request()->routeIs('guardians.*') || request()->routeIs('student-promotions.*') || request()->routeIs('student-documents.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('students.*') || request()->routeIs('admissions.*') || request()->routeIs('guardians.*') || request()->routeIs('student-promotions.*') || request()->routeIs('student-documents.*') ? 'active' : '' }} {{ request()->routeIs('students.*') || request()->routeIs('admissions.*') || request()->routeIs('guardians.*') || request()->routeIs('student-promotions.*') || request()->routeIs('student-documents.*') ? '' : 'collapsed' }}">
            <i class="fas fa-user-graduate"></i> Student Management
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('students.*') || request()->routeIs('admissions.*') || request()->routeIs('guardians.*') || request()->routeIs('student-promotions.*') || request()->routeIs('student-documents.*') ? 'show' : '' }}" id="studentSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Students</a>
            </li>
            <li>
                <a href="{{ route('admissions.index') }}" class="{{ request()->routeIs('admissions.*') ? 'active' : '' }}">Admissions</a>
            </li>
            <li>
                <a href="{{ route('guardians.index') }}" class="{{ request()->routeIs('guardians.*') ? 'active' : '' }}">Guardians</a>
            </li>
            <li>
                <a href="{{ route('student-promotions.index') }}" class="{{ request()->routeIs('student-promotions.*') ? 'active' : '' }}">Student Promotion</a>
            </li>
            <li>
                <a href="{{ route('student-documents.index') }}" class="{{ request()->routeIs('student-documents.*') ? 'active' : '' }}">Student Documents</a>
            </li>
        </ul>
    </li>

    <!-- Teacher Management -->
    <li>
        <a href="#teacherSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('teachers.*') || request()->routeIs('allocations.*') || request()->routeIs('teacher-attendance.index') || request()->routeIs('hr.leave.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('teachers.*') || request()->routeIs('allocations.*') || request()->routeIs('teacher-attendance.index') || request()->routeIs('hr.leave.*') ? 'active' : '' }} {{ request()->routeIs('teachers.*') || request()->routeIs('allocations.*') || request()->routeIs('teacher-attendance.index') || request()->routeIs('hr.leave.*') ? '' : 'collapsed' }}">
            <i class="fas fa-chalkboard-teacher"></i> Teacher Management
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('teachers.*') || request()->routeIs('allocations.*') || request()->routeIs('teacher-attendance.index') || request()->routeIs('hr.leave.*') ? 'show' : '' }}" id="teacherSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('teachers.index') }}" class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}">Teachers</a>
            </li>
            <li>
                <a href="{{ route('allocations.index') }}" class="{{ request()->routeIs('allocations.*') ? 'active' : '' }}">Subject Assignments</a>
            </li>
            <li>
                <a href="{{ route('teacher-attendance.index') }}" class="{{ request()->routeIs('teacher-attendance.index') ? 'active' : '' }}">Teacher Attendance</a>
            </li>
            <li>
                 <a href="{{ route('hr.leave.index') }}" class="{{ request()->routeIs('hr.leave.*') ? 'active' : '' }}">Teacher Leaves</a>
            </li>
        </ul>
    </li>

    <!-- Academic Management -->
    <li>
        <a href="#academicSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('classes.*') || request()->routeIs('subjects.*') || request()->routeIs('sections.*') || request()->routeIs('timetable.*') || request()->routeIs('lesson-plans.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('classes.*') || request()->routeIs('subjects.*') || request()->routeIs('sections.*') || request()->routeIs('timetable.*') || request()->routeIs('lesson-plans.*') ? 'active' : '' }} {{ request()->routeIs('classes.*') || request()->routeIs('subjects.*') || request()->routeIs('sections.*') || request()->routeIs('timetable.*') || request()->routeIs('lesson-plans.*') ? '' : 'collapsed' }}">
            <i class="fas fa-book-open"></i> Academic Management
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('classes.*') || request()->routeIs('subjects.*') || request()->routeIs('sections.*') || request()->routeIs('timetable.*') || request()->routeIs('lesson-plans.*') ? 'show' : '' }}" id="academicSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.*') ? 'active' : '' }}">Classes</a>
            </li>
            <li>
                <a href="{{ route('sections.index') }}" class="{{ request()->routeIs('sections.*') ? 'active' : '' }}">Sections</a>
            </li>
            <li>
                <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}">Subjects</a>
            </li>
            <li>
                <a href="{{ route('timetable.index') }}" class="{{ request()->routeIs('timetable.*') ? 'active' : '' }}">Timetable</a>
            </li>
            <li>
                <a href="{{ route('lesson-plans.index') }}" class="{{ request()->routeIs('lesson-plans.*') ? 'active' : '' }}">Lesson Plans</a>
            </li>
        </ul>
    </li>

    <!-- Attendance -->
    <li>
        <a href="#attendanceSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('attendance.*') || request()->routeIs('reports.attendance') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('attendance.*') || request()->routeIs('reports.attendance') ? 'active' : '' }} {{ request()->routeIs('attendance.*') || request()->routeIs('reports.attendance') ? '' : 'collapsed' }}">
            <i class="fas fa-calendar-check"></i> Attendance
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('attendance.*') || request()->routeIs('reports.attendance') ? 'show' : '' }}" id="attendanceSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">Student Attendance</a>
            </li>
             <li>
                <a href="{{ route('teacher-attendance.index') }}" class="{{ request()->routeIs('teacher-attendance.index') ? 'active' : '' }}">Teacher Attendance</a>
            </li>
            @if(auth()->check() && auth()->user()->hasAnyRole(['Super Admin', 'School Admin', 'Teacher']))
                <li>
                    <a href="{{ route('student-leaves.index') }}" class="{{ request()->routeIs('student-leaves.*') ? 'active' : '' }}">Student Leave Approvals</a>
                </li>
            @endif
            <li>
                <a href="{{ route('reports.attendance') }}" class="{{ request()->routeIs('reports.attendance') ? 'active' : '' }}">Attendance Reports</a>
            </li>
        </ul>
    </li>

    <!-- Examinations -->
    <li>
        <a href="#examSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('exam-types.*') || request()->routeIs('exams.*') || request()->routeIs('grades.*') || request()->routeIs('marks.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('exam-types.*') || request()->routeIs('exams.*') || request()->routeIs('grades.*') || request()->routeIs('marks.*') ? 'active' : '' }} {{ request()->routeIs('exam-types.*') || request()->routeIs('exams.*') || request()->routeIs('grades.*') || request()->routeIs('marks.*') ? '' : 'collapsed' }}">
            <i class="fas fa-edit"></i> Examinations
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('exam-types.*') || request()->routeIs('exams.*') || request()->routeIs('grades.*') || request()->routeIs('marks.*') ? 'show' : '' }}" id="examSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('exam-types.index') }}" class="{{ request()->routeIs('exam-types.*') ? 'active' : '' }}">Exam Types</a>
            </li>
            <li>
                <a href="{{ route('exams.index') }}" class="{{ request()->routeIs('exams.*') ? 'active' : '' }}">Exams</a>
            </li>
            <li>
                <a href="{{ route('marks.index') }}" class="{{ request()->routeIs('marks.*') ? 'active' : '' }}">Marks Entry</a>
            </li>
            <li>
                <a href="{{ route('grades.index') }}" class="{{ request()->routeIs('grades.*') ? 'active' : '' }}">Results</a>
            </li>
            <li>
                <a href="{{ route('marks.report_card') }}" class="{{ request()->routeIs('marks.report_card') ? 'active' : '' }}">Report Cards</a>
            </li>
        </ul>
    </li>

    <!-- Fee Management -->
    <li>
        <a href="#feeSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('fee-structures.*') || request()->routeIs('fee-invoices.*') || request()->routeIs('fee-payments.*') || request()->routeIs('fee-types.*') || request()->routeIs('discounts.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('fee-structures.*') || request()->routeIs('fee-invoices.*') || request()->routeIs('fee-payments.*') || request()->routeIs('fee-types.*') || request()->routeIs('discounts.*') ? 'active' : '' }} {{ request()->routeIs('fee-structures.*') || request()->routeIs('fee-invoices.*') || request()->routeIs('fee-payments.*') || request()->routeIs('fee-types.*') || request()->routeIs('discounts.*') ? '' : 'collapsed' }}">
            <i class="fas fa-money-check-alt"></i> Fee Management
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('fee-structures.*') || request()->routeIs('fee-invoices.*') || request()->routeIs('fee-payments.*') || request()->routeIs('fee-types.*') || request()->routeIs('discounts.*') ? 'show' : '' }}" id="feeSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('fee-types.index') }}" class="{{ request()->routeIs('fee-types.*') ? 'active' : '' }}">Fee Types</a>
            </li>
            <li>
                <a href="{{ route('fee-structures.index') }}" class="{{ request()->routeIs('fee-structures.*') ? 'active' : '' }}">Fee Structure</a>
            </li>
            <li>
                <a href="{{ route('fee-invoices.index') }}" class="{{ request()->routeIs('fee-invoices.*') ? 'active' : '' }}">Invoices</a>
            </li>
            <li>
                <a href="{{ route('fee-payments.history') }}" class="{{ request()->routeIs('fee-payments.*') ? 'active' : '' }}">Payments</a>
            </li>
            <li>
                <a href="{{ route('discounts.index') }}" class="{{ request()->routeIs('discounts.*') ? 'active' : '' }}">Discounts</a>
            </li>
            <li>
                <a href="{{ route('reports.financial') }}" class="{{ request()->routeIs('reports.financial') ? 'active' : '' }}">Fee Reports</a>
            </li>
        </ul>
    </li>

    <!-- HR & Payroll -->
    <li>
        <a href="#hrSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('hr.staff.*') || request()->routeIs('payroll.*') || request()->routeIs('departments.*') || request()->routeIs('payslips.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('hr.staff.*') || request()->routeIs('payroll.*') || request()->routeIs('departments.*') || request()->routeIs('payslips.*') ? 'active' : '' }} {{ request()->routeIs('hr.staff.*') || request()->routeIs('payroll.*') || request()->routeIs('departments.*') || request()->routeIs('payslips.*') ? '' : 'collapsed' }}">
            <i class="fas fa-user-tie"></i> HR & Payroll
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('hr.staff.*') || request()->routeIs('payroll.*') || request()->routeIs('departments.*') || request()->routeIs('payslips.*') ? 'show' : '' }}" id="hrSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('hr.staff.index') }}" class="{{ request()->routeIs('hr.staff.*') ? 'active' : '' }}">Employees</a>
            </li>
            <li>
                <a href="{{ route('departments.index') }}" class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">Departments</a>
            </li>
            <li>
                <a href="{{ route('hr.leave.index') }}" class="{{ request()->routeIs('hr.leave.*') ? 'active' : '' }}">Leave Management</a>
            </li>
            <li>
                <a href="{{ route('payroll.salaries.index') }}" class="{{ request()->routeIs('payroll.salaries.*') ? 'active' : '' }}">Payroll</a>
            </li>
            <li>
                <a href="{{ route('payslips.index') }}" class="{{ request()->routeIs('payslips.*') ? 'active' : '' }}">Payslips</a>
            </li>
        </ul>
    </li>

    <!-- Library -->
    <li>
        <a href="#librarySubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('library.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('library.*') ? 'active' : '' }} {{ request()->routeIs('library.*') ? '' : 'collapsed' }}">
            <i class="fas fa-book-reader"></i> Library
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('library.*') ? 'show' : '' }}" id="librarySubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('library.books.index') }}" class="{{ request()->routeIs('library.books.*') ? 'active' : '' }}">Books</a>
            </li>
            <li>
                <a href="{{ route('library.categories.index') }}" class="{{ request()->routeIs('library.categories.*') ? 'active' : '' }}">Categories</a>
            </li>
            <li>
                <a href="{{ route('library.loans.create') }}" class="{{ request()->routeIs('library.loans.create') ? 'active' : '' }}">Issue Books</a>
            </li>
            <li>
                <a href="{{ route('library.loans.index') }}" class="{{ request()->routeIs('library.loans.index') ? 'active' : '' }}">Return Books</a>
            </li>
            <li>
                <a href="{{ route('library.reports.index') }}" class="{{ request()->routeIs('library.reports.*') ? 'active' : '' }}">Library Reports</a>
            </li>
        </ul>
    </li>

    <!-- Transport -->
    <li>
        <a href="#transportSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('transport.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('transport.*') ? 'active' : '' }} {{ request()->routeIs('transport.*') ? '' : 'collapsed' }}">
            <i class="fas fa-bus"></i> Transport
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('transport.*') ? 'show' : '' }}" id="transportSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('transport.vehicles.index') }}" class="{{ request()->routeIs('transport.vehicles.*') ? 'active' : '' }}">Vehicles</a>
            </li>
            <li>
                <a href="{{ route('transport.routes.index') }}" class="{{ request()->routeIs('transport.routes.*') ? 'active' : '' }}">Routes</a>
            </li>
            <li>
                <a href="{{ route('transport.drivers.index') }}" class="{{ request()->routeIs('transport.drivers.*') ? 'active' : '' }}">Drivers</a>
            </li>
            <li>
                <a href="{{ route('transport.student-transport.index') }}" class="{{ request()->routeIs('transport.student-transport.*') ? 'active' : '' }}">Student Transport</a>
            </li>
        </ul>
    </li>

    <!-- Inventory -->
    <li>
        <a href="#inventorySubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('inventory.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('inventory.*') ? 'active' : '' }} {{ request()->routeIs('inventory.*') ? '' : 'collapsed' }}">
            <i class="fas fa-boxes"></i> Inventory
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('inventory.*') ? 'show' : '' }}" id="inventorySubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('inventory.items.index') }}" class="{{ request()->routeIs('inventory.items.*') ? 'active' : '' }}">Inventory Items</a>
            </li>
            <li>
                <a href="{{ route('inventory.purchases.index') }}" class="{{ request()->routeIs('inventory.purchases.*') ? 'active' : '' }}">Purchases</a>
            </li>
            <li>
                <a href="{{ route('inventory.suppliers.index') }}" class="{{ request()->routeIs('inventory.suppliers.*') ? 'active' : '' }}">Suppliers</a>
            </li>
            <li>
                <a href="{{ route('inventory.alerts.low_stock') }}" class="{{ request()->routeIs('inventory.alerts.*') ? 'active' : '' }}">Stock Reports</a>
            </li>
        </ul>
    </li>

    <!-- Communication -->
    <li>
        <a href="#communicationSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('communication.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('communication.*') ? 'active' : '' }} {{ request()->routeIs('communication.*') ? '' : 'collapsed' }}">
            <i class="fas fa-bullhorn"></i> Communication
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('communication.*') ? 'show' : '' }}" id="communicationSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('communication.notices.index') }}" class="{{ request()->routeIs('communication.notices.*') ? 'active' : '' }}">Announcements</a>
            </li>
            <li>
                <a href="{{ route('communication.messages.index') }}" class="{{ request()->routeIs('communication.messages.*') ? 'active' : '' }}">Messaging</a>
            </li>
            <li>
                <a href="{{ route('communication.notifications.index') }}" class="{{ request()->routeIs('communication.notifications.*') ? 'active' : '' }}">Notifications</a>
            </li>
            <li>
                <a href="{{ route('communication.email-sms.index') }}" class="{{ request()->routeIs('communication.email-sms.*') ? 'active' : '' }}">Email / SMS</a>
            </li>
        </ul>
    </li>

    <!-- Subscription -->
    <li>
        <a href="#subscriptionSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('super-admin.plans.*') || request()->routeIs('super-admin.subscriptions.*') || request()->routeIs('admin.subscription.*') || request()->routeIs('super-admin.payments.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('super-admin.plans.*') || request()->routeIs('super-admin.subscriptions.*') || request()->routeIs('admin.subscription.*') || request()->routeIs('super-admin.payments.*') ? 'active' : '' }} {{ request()->routeIs('super-admin.plans.*') || request()->routeIs('super-admin.subscriptions.*') || request()->routeIs('admin.subscription.*') || request()->routeIs('super-admin.payments.*') ? '' : 'collapsed' }}">
            <i class="fas fa-crown"></i> Subscription
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('super-admin.plans.*') || request()->routeIs('super-admin.subscriptions.*') || request()->routeIs('admin.subscription.*') || request()->routeIs('super-admin.payments.*') ? 'show' : '' }}" id="subscriptionSubmenu" data-bs-parent="#sidebarAccordion">
            @if(auth()->check() && auth()->user()->hasRole('Super Admin'))
            <li>
                <a href="{{ route('super-admin.plans.index') }}" class="{{ request()->routeIs('super-admin.plans.*') ? 'active' : '' }}">Packages</a>
            </li>
            <li>
                <a href="{{ route('super-admin.subscriptions.index') }}" class="{{ request()->routeIs('super-admin.subscriptions.*') ? 'active' : '' }}">Subscriptions</a>
            </li>
            <li>
                <a href="{{ route('super-admin.payment-methods.index') }}" class="{{ request()->routeIs('super-admin.payment-methods.*') ? 'active' : '' }}">Payment Methods</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('School Admin'))
            <li>
                <a href="{{ route('admin.subscription.index') }}" class="{{ request()->routeIs('admin.subscription.*') ? 'active' : '' }}">My Subscription</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('School Admin'))
            <li>
                <a href="{{ route('billing.payment.history') }}" class="{{ request()->routeIs('billing.*') ? 'active' : '' }}">Billing</a>
            </li>
            @elseif(auth()->check() && auth()->user()->hasRole('Super Admin'))
            <li>
                <a href="{{ route('super-admin.payments.index') }}" class="{{ request()->routeIs('super-admin.payments.*') ? 'active' : '' }}">Billing</a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('Super Admin'))
            <li>
                <a href="{{ route('super-admin.payments.index') }}" class="{{ request()->routeIs('super-admin.payments.*') ? 'active' : '' }}">Payment History</a>
            </li>
            @endif
        </ul>
    </li>

    <!-- Reports -->
    <li>
        <a href="#reportsSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('reports.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('reports.*') ? 'active' : '' }} {{ request()->routeIs('reports.*') ? '' : 'collapsed' }}">
            <i class="fas fa-chart-line"></i> Reports
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('reports.*') ? 'show' : '' }}" id="reportsSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('reports.academic') }}" class="{{ request()->routeIs('reports.academic') ? 'active' : '' }}">Academic Reports</a>
            </li>
            <li>
                <a href="{{ route('reports.financial') }}" class="{{ request()->routeIs('reports.financial') ? 'active' : '' }}">Financial Reports</a>
            </li>
            <li>
                <a href="{{ route('reports.attendance') }}" class="{{ request()->routeIs('reports.attendance') ? 'active' : '' }}">Attendance Reports</a>
            </li>
            <li>
                <a href="{{ route('reports.hr') }}" class="{{ request()->routeIs('reports.hr') ? 'active' : '' }}">HR Reports</a>
            </li>
            <li>
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">All Reports</a>
            </li>
        </ul>
    </li>

    <!-- System Settings -->
    <li>
        <a href="#settingsSubmenu" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('settings.*') || request()->routeIs('super-admin.payment-methods.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ request()->routeIs('settings.*') || request()->routeIs('super-admin.payment-methods.*') ? 'active' : '' }} {{ request()->routeIs('settings.*') || request()->routeIs('super-admin.payment-methods.*') ? '' : 'collapsed' }}">
            <i class="fas fa-cogs"></i> System Settings
        </a>
        <ul class="collapse list-unstyled {{ request()->routeIs('settings.*') || request()->routeIs('super-admin.payment-methods.*') ? 'show' : '' }}" id="settingsSubmenu" data-bs-parent="#sidebarAccordion">
            <li>
                <a href="{{ route('settings.general') }}" class="{{ request()->routeIs('settings.general') ? 'active' : '' }}">General Settings</a>
            </li>
            @if(auth()->check() && auth()->user()->hasRole('Super Admin'))
            <li>
                <a href="{{ route('super-admin.payment-methods.index') }}" class="{{ request()->routeIs('super-admin.payment-methods.*') ? 'active' : '' }}">Payment Methods</a>
            </li>
            @endif
            <li>
                <a href="{{ route('settings.email') }}" class="{{ request()->routeIs('settings.email') ? 'active' : '' }}">Email Settings</a>
            </li>
            <li>
                <a href="{{ route('settings.backup') }}" class="{{ request()->routeIs('settings.backup') ? 'active' : '' }}">Backup</a>
            </li>
        </ul>
    </li>

    @endif

    <!-- Teacher Role -->
    @if(auth()->check() && auth()->user()->hasRole('Teacher'))
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
            <a href="{{ route('hr.leave.my') }}" class="{{ request()->routeIs('hr.leave.my') || request()->routeIs('hr.leave.request.*') ? 'active' : '' }}">
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
    @endif

    <!-- Student Role -->
    @if(auth()->check() && auth()->user()->hasRole('Student'))
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
            <a href="{{ route('student.report_card') }}" class="{{ request()->routeIs('student.report_card') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Report Card
            </a>
        </li>
        <li>
            <a href="{{ route('student.invoices') }}" class="{{ request()->routeIs('student.invoices') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> Invoices
            </a>
        </li>
        <li>
            <a href="{{ route('library.my') }}" class="{{ request()->routeIs('library.my') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Library Books
            </a>
        </li>
    @endif

    <!-- Parent Role -->
    @if(auth()->check() && auth()->user()->hasRole('Parent'))
        <li class="sidebar-heading">PARENT PORTAL</li>
        <li>
            <a href="{{ route('parent.dashboard') }}" class="{{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('student.my-attendance') }}" class="{{ request()->routeIs('student.my-attendance') ? 'active' : '' }}">
                <i class="fas fa-user-check"></i> Attendance
            </a>
        </li>
        <li>
            <a href="{{ route('parent.leaves.index') }}" class="{{ request()->routeIs('parent.leaves.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-minus"></i> Leave Requests
            </a>
        </li>
    @endif
</ul>
