<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h1 class="h3 fw-bold text-dark mb-0">Edit Role</h1>
            <a href="{{ route('super-admin.roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Roles
            </a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('super-admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Permissions</label>
                    <div class="row">
                        @foreach($permissions as $module => $modulePermissions)
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header bg-light py-2">
                                        <div class="form-check">
                                            <input class="form-check-input module-checkbox" type="checkbox" id="module_{{ $module }}" data-module="{{ $module }}">
                                            <label class="form-check-label fw-bold text-uppercase" for="module_{{ $module }}">
                                                {{ ucfirst($module) }} Module
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        <div class="row">
                                            @foreach($modulePermissions as $permission)
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input permission-checkbox module-{{ $module }}" 
                                                               type="checkbox" 
                                                               name="permissions[]" 
                                                               value="{{ $permission->id }}" 
                                                               id="perm_{{ $permission->id }}"
                                                               {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                            {{ explode('.', $permission->name)[1] ?? $permission->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Role</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle "Select All" for each module
        const moduleCheckboxes = document.querySelectorAll('.module-checkbox');
        
        moduleCheckboxes.forEach(checkbox => {
            // Initial check state based on children
            const moduleName = checkbox.dataset.module;
            const permissionCheckboxes = document.querySelectorAll(`.module-${moduleName}`);
            const allChecked = Array.from(permissionCheckboxes).every(pc => pc.checked);
            const someChecked = Array.from(permissionCheckboxes).some(pc => pc.checked);
            
            checkbox.checked = allChecked;
            checkbox.indeterminate = !allChecked && someChecked;

            // Change listener
            checkbox.addEventListener('change', function() {
                const moduleName = this.dataset.module;
                const permissionCheckboxes = document.querySelectorAll(`.module-${moduleName}`);
                
                permissionCheckboxes.forEach(permCheckbox => {
                    permCheckbox.checked = this.checked;
                });
            });
        });

        // Update module checkbox state if individual permissions are changed
        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
        permissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Find the module this permission belongs to
                let moduleClass = Array.from(this.classList).find(cls => cls.startsWith('module-'));
                if (moduleClass) {
                    let moduleName = moduleClass.replace('module-', '');
                    let moduleCheckbox = document.getElementById(`module_${moduleName}`);
                    
                    // Check if all permissions in this module are checked
                    let allChecked = true;
                    let someChecked = false;
                    document.querySelectorAll(`.${moduleClass}`).forEach(pc => {
                        if (!pc.checked) allChecked = false;
                        if (pc.checked) someChecked = true;
                    });
                    
                    moduleCheckbox.checked = allChecked;
                    moduleCheckbox.indeterminate = !allChecked && someChecked;
                }
            });
        });
    });
</script>
@endpush
</x-app-layout>

