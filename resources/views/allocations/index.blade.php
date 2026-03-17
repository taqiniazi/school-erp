﻿﻿﻿﻿﻿<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Teacher Allocations</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAllocationModal">
                Assign Teacher
            </button>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover w-100 mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Teacher</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Class</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Section</th>
                                <th class="p-3 text-start small fw-medium text-secondary text-uppercase">Subject</th>
                                <th class="p-3 text-end small fw-medium text-secondary text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allocations as $allocation)
                            <tr>
                                <td class="p-3 text-nowrap">{{ $allocation->teacher->user->name ?? 'N/A' }}</td>
                                <td class="p-3 text-nowrap">{{ $allocation->schoolClass->name ?? 'N/A' }}</td>
                                <td class="p-3 text-nowrap">{{ $allocation->section->name ?? 'All' }}</td>
                                <td class="p-3 text-nowrap">{{ $allocation->subject->name ?? 'N/A' }} ({{ $allocation->subject->code ?? '' }})</td>
                                <td class="p-3 text-nowrap text-end">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editAllocationModal"
                                        data-allocation-id="{{ $allocation->id }}"
                                        data-teacher-id="{{ $allocation->teacher_id }}"
                                        data-school-class-id="{{ $allocation->school_class_id }}"
                                        data-section-id="{{ $allocation->section_id }}"
                                        data-subject-id="{{ $allocation->subject_id }}"
                                    >Edit</button>
                                    <form action="{{ route('allocations.destroy', $allocation) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this allocation?')">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-secondary">No allocations found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!-- Create Modal -->
    <div class="modal fade" id="createAllocationModal" tabindex="-1" aria-labelledby="createAllocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('allocations.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAllocationModalLabel">Assign Teacher to Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="teacher_id" class="form-label">Teacher</label>
                            <select name="teacher_id" id="teacher_id" class="form-select" required>
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->user->name ?? 'Unknown' }} ({{ $teacher->employee_id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="school_class_ids" class="form-label">Class</label>
                            <select name="school_class_ids[]" id="school_class_ids" class="form-select" multiple required>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="section_ids" class="form-label">Section</label>
                            <select name="section_ids[]" id="section_ids" class="form-select" multiple required>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }} (Class: {{ $section->schoolClass->name ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="subject_ids" class="form-label">Subject</label>
                            <select name="subject_ids[]" id="subject_ids" class="form-select" multiple required>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editAllocationModal" tabindex="-1" aria-labelledby="editAllocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAllocationModalLabel">Edit Allocation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_teacher_id" class="form-label">Teacher</label>
                            <select name="teacher_id" id="edit_teacher_id" class="form-select" required>
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->user->name ?? 'Unknown' }} ({{ $teacher->employee_id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_school_class_id" class="form-label">Class</label>
                            <select name="school_class_id" id="edit_school_class_id" class="form-select" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_section_id" class="form-label">Section</label>
                            <select name="section_id" id="edit_section_id" class="form-select" required>
                                <option value="">Select Section</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }} (Class: {{ $section->schoolClass->name ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_subject_id" class="form-label">Subject</label>
                            <select name="subject_id" id="edit_subject_id" class="form-select" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('vendor/multiple-select/multiple-select.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('vendor/multiple-select/multiple-select.min.js') }}"></script>
        <script>
            (function () {
                function initMultiSelect() {
                    if (!window.jQuery || !jQuery.fn || !jQuery.fn.multipleSelect) return;

                    var $ = jQuery;

                    function ensure(selector, placeholder) {
                        var $el = $(selector);
                        if (!$el.length) return;
                        if ($el.data('multipleSelect')) return;

                        $el.multipleSelect({
                            filter: true,
                            selectAll: true,
                            width: '100%',
                            placeholder: placeholder,
                        });
                    }

                    ensure('#school_class_ids', 'Select Class');
                    ensure('#section_ids', 'Select Section');
                    ensure('#subject_ids', 'Select Subject');
                }

                function refreshMultiSelect() {
                    if (!window.jQuery || !jQuery.fn || !jQuery.fn.multipleSelect) return;
                    jQuery('#school_class_ids, #section_ids, #subject_ids').multipleSelect('refresh');
                }

                function boot() {
                    initMultiSelect();

                    var createModal = document.getElementById('createAllocationModal');
                    if (createModal) {
                        createModal.addEventListener('shown.bs.modal', function () {
                            initMultiSelect();
                            refreshMultiSelect();
                        });
                    }

                    var modal = document.getElementById('editAllocationModal');
                    if (!modal) return;

                    modal.addEventListener('show.bs.modal', function (event) {
                        var trigger = event.relatedTarget;
                        if (!trigger) return;

                        var allocationId = trigger.getAttribute('data-allocation-id');
                        var teacherId = trigger.getAttribute('data-teacher-id');
                        var classId = trigger.getAttribute('data-school-class-id');
                        var sectionId = trigger.getAttribute('data-section-id');
                        var subjectId = trigger.getAttribute('data-subject-id');

                        var form = modal.querySelector('form');
                        form.action = `{{ url('allocations') }}/${allocationId}`;

                        var teacherSelect = modal.querySelector('#edit_teacher_id');
                        var classSelect = modal.querySelector('#edit_school_class_id');
                        var sectionSelect = modal.querySelector('#edit_section_id');
                        var subjectSelect = modal.querySelector('#edit_subject_id');

                        if (teacherSelect) teacherSelect.value = teacherId || '';
                        if (classSelect) classSelect.value = classId || '';
                        if (sectionSelect) sectionSelect.value = sectionId || '';
                        if (subjectSelect) subjectSelect.value = subjectId || '';
                    });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', boot);
                } else {
                    boot();
                }
            })();
        </script>
    @endpush
</x-app-layout>
