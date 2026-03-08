<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark lh-sm">
            {{ __('Reports & Analytics') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
                <!-- Academic Reports -->
                <div class="col">
                    <div class="card shadow-sm border-0 rounded-3 p-4 h-100">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-pill bg-primary-subtle text-primary">
                                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div class="ms-4">
                                <h3 class="h6 fw-semibold text-dark mb-1">Academic Reports</h3>
                                <p class="small text-secondary mb-0">Student lists, Exam results</p>
                            </div>
                        </div>
                        <div class="mt-4 d-flex flex-column gap-2">
                            <a href="{{ route('reports.academic') }}" class="text-decoration-none text-primary fw-medium small">Student List &rarr;</a>
                            <a href="{{ route('marks.report_card') }}" class="text-decoration-none text-primary fw-medium small">Report Cards &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Financial Reports -->
                <div class="col">
                    <div class="card shadow-sm border-0 rounded-3 p-4 h-100">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-pill bg-success-subtle text-success">
                                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="ms-4">
                                <h3 class="h6 fw-semibold text-dark mb-1">Financial Reports</h3>
                                <p class="small text-secondary mb-0">Fee collection, Outstanding</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('reports.financial') }}" class="text-decoration-none text-success fw-medium small">View Reports &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Attendance Reports -->
                <div class="col">
                    <div class="card shadow-sm border-0 rounded-3 p-4 h-100">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-pill bg-warning-subtle text-warning">
                                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="ms-4">
                                <h3 class="h6 fw-semibold text-dark mb-1">Attendance Reports</h3>
                                <p class="small text-secondary mb-0">Monthly attendance, Staff</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('reports.attendance') }}" class="text-decoration-none text-warning fw-medium small">View Reports &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- HR Reports -->
                <div class="col">
                    <div class="card shadow-sm border-0 rounded-3 p-4 h-100">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-pill bg-info-subtle text-info">
                                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div class="ms-4">
                                <h3 class="h6 fw-semibold text-dark mb-1">HR Reports</h3>
                                <p class="small text-secondary mb-0">Staff list, Leave summary</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('reports.hr') }}" class="text-decoration-none text-info fw-medium small">View Reports &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



