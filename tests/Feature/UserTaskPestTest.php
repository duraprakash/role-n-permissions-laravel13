<?php

use App\Models\User;

it('allows users to access user tasks page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('user.tasks.index'))
        ->assertOk();
});

it('does not allow users to access admin task page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.tasks.index'))
        ->assertForbidden();
});

it('allows administrator to access admin tasks page', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user)
        ->get(route('admin.tasks.index'))
        ->assertOk();
});

it('does not allows administrator to access user tasks page', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user)
        ->get(route('user.tasks.index'))
        ->assertOk();
});
