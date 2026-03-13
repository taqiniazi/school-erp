<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold">Create Designation</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('designations.store') }}" method="POST">
                            @csrf
                            @php
                                $designationsOld = old('designations');
                                if (!is_array($designationsOld) || count($designationsOld) === 0) {
                                    $designationsOld = [[
                                        'name' => old('name'),
                                        'description' => old('description'),
                                        'is_active' => old('is_active', true),
                                    ]];
                                }
                            @endphp

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-semibold">Designations</div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add_designation_row">
                                    <i class="fas fa-plus"></i> Add More
                                </button>
                            </div>

                            <div id="designations_container">
                                @foreach($designationsOld as $index => $row)
                                    <div class="designation-item border rounded p-3 mb-3">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-12 col-md-4">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="designations[{{ $index }}][name]" class="form-control" value="{{ data_get($row, 'name') }}" required>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <label class="form-label">Description</label>
                                                <input type="text" name="designations[{{ $index }}][description]" class="form-control" value="{{ data_get($row, 'description') }}">
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="designations_active_{{ $index }}" name="designations[{{ $index }}][is_active]" {{ data_get($row, 'is_active', true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="designations_active_{{ $index }}">Active</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-1 text-md-end">
                                                <button type="button" class="btn btn-outline-danger w-100 remove-designation-item">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('designations.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('designations_container');
        const addBtn = document.getElementById('add_designation_row');

        function renumberItems() {
            const items = container.querySelectorAll('.designation-item');
            items.forEach((item, idx) => {
                item.querySelectorAll('input[name]').forEach((input) => {
                    input.name = input.name.replace(/designations\[\d+\]/, `designations[${idx}]`);
                });
                const checkbox = item.querySelector('input[type="checkbox"][id^="designations_active_"]');
                const label = item.querySelector('label[for^="designations_active_"]');
                if (checkbox) checkbox.id = `designations_active_${idx}`;
                if (label) label.setAttribute('for', `designations_active_${idx}`);
            });
        }

        function addItem() {
            const idx = container.querySelectorAll('.designation-item').length;
            const div = document.createElement('div');
            div.className = 'designation-item border rounded p-3 mb-3';
            div.innerHTML = `
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="designations[${idx}][name]" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-5">
                        <label class="form-label">Description</label>
                        <input type="text" name="designations[${idx}][description]" class="form-control">
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="designations_active_${idx}" name="designations[${idx}][is_active]" checked>
                            <label class="form-check-label" for="designations_active_${idx}">Active</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-1 text-md-end">
                        <button type="button" class="btn btn-outline-danger w-100 remove-designation-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }

        addBtn.addEventListener('click', addItem);

        container.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-designation-item');
            if (!btn) return;
            const items = container.querySelectorAll('.designation-item');
            const item = btn.closest('.designation-item');
            if (items.length <= 1) {
                item.querySelectorAll('input[type="text"]').forEach((input) => (input.value = ''));
                item.querySelectorAll('input[type="checkbox"]').forEach((input) => (input.checked = true));
                return;
            }
            item.remove();
            renumberItems();
        });
    });
</script>
@endpush
