<x-layouts.app :title="__('Edit Task')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <flux:heading size="xl">{{ __('Edit Task') }}</flux:heading>

        <div
            class="max-w-lg rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <form action="{{ route('tasks.update', $task) }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @method('PUT')

                <!-- <flux:field>
                    <flux:label>{{ __('ID') }}</flux:label>
                    <flux:input type="text" name="id" value="{{ old('id', $task->id) }}" required />
                    @error('id')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field> -->

                <flux:field>
                    <flux:label>{{ __('Name') }}</flux:label>
                    <flux:input type="text" name="name" value="{{ old('name', $task->name) }}" required />
                    @error('name')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <!-- <flux:field>
                    <flux:label>{{ __('User') }}</flux:label>
                    <flux:input type="text" name="user" value="{{ old('user', $task->user?->name) }}" required />
                    @error('user')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror -->
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Due Date') }}</flux:label>
                    <flux:input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}" />
                    @error('due_date')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <div class="flex items-center gap-3">
                    <flux:button type="submit" variant="primary">{{ __('Update') }}</flux:button>
                    <flux:button href="{{ route('tasks.index') }}" wire:navigate>{{ __('Cancel') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>