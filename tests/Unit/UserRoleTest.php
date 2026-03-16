<?php

namespace Tests\Unit;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    public function test_super_admin_column_has_role_access()
    {
        $user = new User;
        $user->role = 'super_admin';

        // Check string
        $this->assertTrue($user->hasRole('Super Admin'));

        // Check array
        $this->assertTrue($user->hasRole(['Super Admin']));

        // Check pipe string
        $this->assertTrue($user->hasRole('Super Admin|School Admin'));

        // Check unrelated role
        // Since we are not using database here (or mock), traitHasRole might fail if we don't mock it or set up environment.
        // But since we are testing the override logic which returns early, it should pass.

        // However, if we test something that falls through to traitHasRole, we need DB.
        // Let's stick to testing the override logic.
    }

    public function test_school_admin_column_has_role_access()
    {
        $user = new User;
        $user->role = 'school_admin';

        $this->assertTrue($user->hasRole('School Admin'));
        $this->assertTrue($user->hasRole(['School Admin']));
        $this->assertTrue($user->hasRole('Super Admin|School Admin'));
    }

    public function test_super_admin_does_not_have_teacher_role_implicitly()
    {
        $user = new User;
        $user->role = 'super_admin';
        $user->setRelation('roles', collect());

        // 'Teacher' is not in the allowed list for super_admin column logic
        // It will fall through to traitHasRole.
        // Since user is not saved and has no roles, traitHasRole should return false.

        // However, traitHasRole needs database connection usually to check model_has_roles.
        // User is new instance, so relations are empty.
        // Spatie might try to load relations.

        $this->assertFalse($user->hasRole('Teacher'));
    }
}
