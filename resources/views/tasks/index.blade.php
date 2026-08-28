<x-layouts.app :title="__('Tasks')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">{{ __('All Tasks') }}</flux:heading>
            @can('create', \App\Models\Task::class)
                <flux:button href="{{ route('tasks.create') }}" variant="primary" wire:navigate>
                    {{ __('Add new task') }}
                </flux:button>
            @endcan
        </div>

        <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            {{ __('Task Id') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            {{ __('Name') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            {{ __('User') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            {{ __('Due Date') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            {{ __('Own This') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-zinc-900">
                    @foreach ($tasks as $task)
                        <tr>
                            <td class="px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                                {{ $task->id }}
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                                {{ $task->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                                {{ $task->user->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                                {{ $task->due_date }}
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                                @if ($task->user_id === auth()->id())
                                    <span>&#9989;</span>
                                @else
                                    <span>&#10060;</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    @can('update', $task)
                                        <flux:button href="{{ route('tasks.edit', $task) }}" size="sm" wire:navigate>
                                            {{ __('Edit') }}
                                        </flux:button>
                                    @endcan
                                    @can('delete', $task)
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @method('DELETE')
                                            @csrf
                                            <flux:button type="submit" size="sm" variant="danger">
                                                {{ __('Delete') }}
                                            </flux:button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>