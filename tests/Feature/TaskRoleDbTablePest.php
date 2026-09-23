<?php

use App\Enums\Role;
use App\Models\Role as RoleModel;
use App\Models\User;
use App\Models\Task;

use Database\Factories\UserFactory;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

it('allows administrator to access create task page', function () {
    $user = User::factory()->administrator()->create();

    $this->actingAs($user)
        ->get(route('tasks.create'))
        ->assertOk();
});

it('does not allow other users to access create task page', function (User $user) {
    $this->actingAs($user)
        ->get(route('tasks.create'))
        ->assertForbidden();
})->with([
            fn() => User::factory()->user()->create(),
            fn() => User::factory()->manager()->create(),
        ]);

it('allows administrator and manager to enter update page for any task', function (User $user) {
    $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->actingAs($user)
        ->get(route('tasks.edit', $task))
        ->assertOk();
})->with([
            fn() => User::factory()->administrator()->create(),
            fn() => User::factory()->manager()->create(),
        ]);

it('allows administrator and manager to update any task', function (User $user) {
    $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->actingAs($user)
        ->put(route('tasks.update', $task), ['name' => 'updated task name', 'due_date' => '2026-10-21 20:12:35'])
        ->assertRedirect();

    expect($task->refresh()->name)->toBe('updated task name');
    expect($task->refresh()->due_date)->toBe('2026-10-21 20:12:35');
})->with([
            fn() => User::factory()->administrator()->create(),
            fn() => User::factory()->manager()->create(),
        ]);

it('allows user to update their own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->put(route('tasks.update', $task), ['name' => 'updated task name', 'due_date' => '2026-10-21 20:12:35']);

    expect($task->refresh()->name)->toBe('updated task name');
    expect($task->refresh()->due_date)->toBe('2026-10-21 20:12:35');
});

it('does not allow user to update other users task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->actingAs($user)
        ->put(route('tasks.update', $task), ['name' => 'updated task name', 'due_date' => '2026-10-21 20:12:35'])
        ->assertForbidden();
});

it('allows administrator to delete task', function () {
    $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);
    $user = User::factory()->administrator()->create();

    $this->actingAs($user)
        ->delete(route('tasks.destroy', $task))
        ->assertRedirect();

    expect(Task::count())->toBe(0);
});

it('does not allow other users to delete tasks', function (User $user) {
    $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->actingAs($user)
        ->delete(route('tasks.destroy', $task))
        ->assertForbidden();
})->with([
            fn() => User::factory()->user()->create(),
            fn() => User::factory()->manager()->create(),
        ]);