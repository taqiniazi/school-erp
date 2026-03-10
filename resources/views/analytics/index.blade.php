﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold h4 text-dark  lh-sm">
            {{ __('Analytics Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid px-4">
            <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
                <!-- Student Growth Chart -->
                <div class="col">
                    <div class="card shadow-sm border-0 rounded-3 p-4 h-100">
                        <h3 class="h5 fw-medium text-dark mb-4">Student Growth</h3>
                        <div class="position-relative" style="height: 256px;">
                            <canvas id="studentGrowthChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Fee Collection Chart -->
                <div class="col">
                    <div class="card shadow-sm border-0 rounded-3 p-4 h-100">
                        <h3 class="h5 fw-medium text-dark mb-4">Fee Collection</h3>
                        <div class="position-relative" style="height: 256px;">
                            <canvas id="feeCollectionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 g-4">
                <!-- Attendance Rate Chart -->
                <div class="col">
                    <div class="card shadow-sm border-0 rounded-3 p-4 h-100">
                        <h3 class="h5 fw-medium text-dark mb-4">Attendance Rate (Last 30 Days)</h3>
                        <div class="position-relative" style="height: 256px;">
                            <canvas id="attendanceRateChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Teacher Workload Chart -->
                <div class="col">
                    <div class="card shadow-sm border-0 rounded-3 p-4 h-100">
                        <h3 class="h5 fw-medium text-dark mb-4">Teacher Workload (Top 10)</h3>
                        <div class="position-relative" style="height: 256px;">
                            <canvas id="teacherWorkloadChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Common Chart Options
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: document.documentElement.classList.contains('dark') ? '#e5e7eb' : '#374151'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563' },
                        row: { color: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb' }
                    },
                    y: {
                        ticks: { color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563' },
                        row: { color: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb' }
                    }
                }
            };

            // 1. Student Growth Chart
            const studentGrowthCtx = document.getElementById('studentGrowthChart').getContext('2d');
            const studentGrowthData = @json($studentGrowth);
            new Chart(studentGrowthCtx, {
                type: 'line',
                data: {
                    labels: studentGrowthData.map(item => item.month),
                    datasets: [{
                        label: 'New Students',
                        data: studentGrowthData.map(item => item.count),
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: commonOptions
            });

            // 2. Fee Collection Chart
            const feeCollectionCtx = document.getElementById('feeCollectionChart').getContext('2d');
            const feeCollectionData = @json($feeCollection);
            new Chart(feeCollectionCtx, {
                type: 'bar',
                data: {
                    labels: feeCollectionData.map(item => item.month),
                    datasets: [{
                        label: 'Collected Amount ($)',
                        data: feeCollectionData.map(item => item.total),
                        backgroundColor: '#10b981',
                        borderColor: '#059669',
                        borderWidth: 1
                    }]
                },
                options: commonOptions
            });

            // 3. Attendance Rate Chart
            const attendanceRateCtx = document.getElementById('attendanceRateChart').getContext('2d');
            const attendanceData = @json($attendanceData);
            new Chart(attendanceRateCtx, {
                type: 'line',
                data: {
                    labels: attendanceData.map(item => item.date),
                    datasets: [{
                        label: 'Attendance Rate (%)',
                        data: attendanceData.map(item => item.rate),
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    ...commonOptions,
                    scales: {
                        ...commonOptions.scales,
                        y: {
                            ...commonOptions.scales.y,
                            min: 0,
                            max: 100
                        }
                    }
                }
            });

            // 4. Teacher Workload Chart
            const teacherWorkloadCtx = document.getElementById('teacherWorkloadChart').getContext('2d');
            const teacherWorkloadData = @json($teacherWorkload);
            new Chart(teacherWorkloadCtx, {
                type: 'doughnut',
                data: {
                    labels: teacherWorkloadData.map(item => item.name),
                    datasets: [{
                        label: 'Classes Assigned',
                        data: teacherWorkloadData.map(item => item.count),
                        backgroundColor: [
                            '#ef4444', '#f97316', '#f59e0b', '#84cc16', '#10b981',
                            '#06b6d4', '#3b82f6', '#6366f1', '#8b5cf6', '#d946ef'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? '#e5e7eb' : '#374151'
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>


