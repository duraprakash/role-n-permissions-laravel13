<?php

use App\Models\User;
use App\Models\Task;
// use function Pest\Laravel\actingAs;

//-------------------------
// INDEX / VIEW TASKS
//--------------------------
it('allows user to access their tasks page', function () {
    $user = User::factory()->create();

    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user)
        ->get(route('tasks.index'))
        ->assertOk();
});

it('allows administrator to access the admin tasks page', function () {
    $adminUser = User::factory()->create([
        'is_admin' => true,
    ]);
    $adminTask = Task::factory()->create([
        'user_id' => $adminUser->id,
    ]);

    $this->actingAs($adminUser)
        ->get(route('tasks.index'))
        ->assertOk();
});

it('shows only the users own tasks', function () {
    $user = User::factory()->create();
    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $otherUser = User::factory()->create();
    $otherUserTask = Task::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $this->actingAs($user)
        ->get(route('tasks.index'))
        ->assertOk()
        ->assertSee($userTask->name)
        ->assertDontSee($otherUserTask->name);
});

it('allows administrator to see all tasks', function () {
    $adminUser = User::factory()->create([
        'is_admin' => true,
    ]);
    $adminUserTask = Task::factory()->create([
        'user_id' => $adminUser->id,
    ]);

    $user = User::factory()->create();
    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $otherUser = User::factory()->create();
    $otherUserTask = Task::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $this->actingAs($adminUser)
        ->get(route('tasks.index'))
        ->assertOk()
        ->assertSee($adminUserTask->name)
        ->assertSee($userTask->name)
        ->assertSee($otherUserTask->name);
});

//-----------------------------------
// SHOW TASK
//-----------------------------------
it('allows a user to view their own task', function () {
    $user = User::factory()->create();
    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user)
        ->get(route('tasks.show', $userTask))
        ->assertOk();
});

it('does not allow a user to view another users task', function () {
    $user = User::factory()->create();

    $otherUser = User::factory()->create();
    $otherUserTask = Task::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $this->actingAs($user)
        ->get(route('tasks.show', $otherUserTask))
        ->assertForbidden();
});

it('allows an administrator to view any task', function () {
    $adminUser = User::factory()->create([
        'is_admin' => true,
    ]);

    $user = User::factory()->create();
    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($adminUser)
        ->get(route('tasks.show', $userTask))
        ->assertOk();
});

//-----------------------------------
// CREATE TASK
//-----------------------------------
it('allows a user to access the create task page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('tasks.create'))
        ->assertOk();
});

it('allows an administrator to access the create task page', function () {
    $adminUser = User::factory()->create([
        'is_admin' => true
    ]);

    $this->actingAs($adminUser)
        ->get(route('tasks.create'))
        ->assertOk();
});

it('allows a user to create a task', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('tasks.store'), [
            'name' => 'My new task',
            'due_date' => now()->addDay()->format('Y-m-d'),
        ])
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'name' => 'My new task',
        'user_id' => $user->id,
    ]);
});

//-----------------------------------
// UPDATE TASK
//-----------------------------------
it('allows a user to access the udpate page for their own task', function () {
    $user = User::factory()->create();
    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user)
        ->get(route('tasks.edit', $userTask))
        ->assertOk();
});

it('does not allow a user to access the update page for another users task', function () {
    $user = User::factory()->create();

    $otherUser = User::factory()->create();
    $otherUserTask = Task::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $this->actingAs($user)
        ->get(route('tasks.edit', $otherUserTask))
        ->assertForbidden();
});

it('allows a user to udpate their own task', function () {
    $user = User::factory()->create();
    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user)
        ->put(route('tasks.update', $userTask), [
            'name' => 'Updated task name',
        ])
        ->assertRedirect(route('tasks.index'));

    expect($userTask->refresh()->name)
        ->toBe("Updated task name");
});

it('does not allow a user to update another users task', function () {
    $user = User::factory()->create();

    $otherUser = User::factory()->create();
    $otherUserTask = Task::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $this->actingAs($user)
        ->put(route('tasks.update', $otherUserTask), [
            'name' => 'Updated task name',
        ])
        ->assertForbidden();

    expect($otherUserTask->refresh()->name)
        ->not()->toBe('Updated task name');
});


it('allows an administrator to access the update page for any task', function () {
    $adminUser = User::factory()->create([
        'is_admin' => true
    ]);

    $user = User::factory()->create();
    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($adminUser)
        ->get(route('tasks.edit', $userTask))
        ->assertOk();
});

it('allows an administrator to update any task', function () {
    $admin = User::factory()->create([
        'is_admin' => true,
    ]);

    $user = User::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($admin)
        ->put(route('tasks.update', $task), [
            'name' => 'Updated by administrator',
        ])
        ->assertRedirect(route('tasks.index'));

    expect($task->refresh()->name)
        ->toBe('Updated by administrator');
});

//-----------------------------------
// DELETE TASK
//-----------------------------------
it('allows a user to delete their own task', function () {
    $user = User::factory()->create();

    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user)
        ->delete(route('tasks.destroy', $userTask))
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseMissing('tasks', [
        'id' => $userTask->id,
    ]);
});

it('does not allow a user to delete another users task', function () {
    $user = User::factory()->create();

    $otherUser = User::factory()->create();

    $otherUserTask = Task::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $this->actingAs($user)
        ->delete(route('tasks.destroy', $otherUserTask))
        ->assertForbidden();

    $this->assertDatabaseHas('tasks', [
        'id' => $otherUserTask->id,
    ]);
});

it('allows administrator to delete any task', function () {
    $admin = User::factory()->create([
        'is_admin' => true,
    ]);

    $user = User::factory()->create();

    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($admin)
        ->delete(route('tasks.destroy', $userTask))
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseMissing('tasks', [
        'id' => $userTask->id,
    ]);
});

// ---------------------------------------------------------
// GUEST ACCESS
// ---------------------------------------------------------
it('does not allow guests to access the tasks page', function () {
    $this->get(route('tasks.index'))
        ->assertRedirect(route('login'));
});

it('does not allow guests to access the create tasks page', function () {
    $this->get(route('tasks.create'))
        ->assertRedirect(route('login'));
});

it('does not allow guests to create tasks', function () {
    $this->post(route('tasks.store'), [
        'name' => 'Unauthorised task',
        'due_date' => now()->addDay()->format('Y-m-d'),
    ])->assertRedirect(route('login'));

    $this->assertDatabaseMissing('tasks', [
        'name' => 'Unauthorised task',
    ]);
});

it('does not allow guests to view tasks', function () {
    $user = User::factory()->create();

    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->get(route('tasks.show', $userTask))
        ->assertRedirect(route('login'));
});

it('does not allow guests to update tasks', function () {
    $user = User::factory()->create();
    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->get(route('tasks.edit', $userTask))
        ->assertRedirect(route('login'));
});

it('does not allow guests to delete tasks', function () {
    $user = User::factory()->create();
    $userTask = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->delete(route('tasks.destroy', $userTask))
        ->assertRedirect(route('login'));
});