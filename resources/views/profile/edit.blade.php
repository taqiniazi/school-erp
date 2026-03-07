<x-app-layout>
    <x-slot name="header">
        {{ __('Profile') }}
    </x-slot>

    <div class="row g-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-12">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</x-app-layout>
