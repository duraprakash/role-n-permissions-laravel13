<?php

use App\Models\User;

//-------------------------
//  INDEX
//--------------------------
it('allows users to access their tasks page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('tasks.index'))
        ->assertOk();
});

it('allows an administrator to access the tasks page', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $this->actingAs($user)
        ->get(route('tasks.index'))
        ->assertOk();
});
