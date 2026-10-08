<x-layouts.admin :title="'Users'">
    <!-- Toolbar -->
    <div class="mb-6">
        <form class="flex items-center gap-2.5">
            <div class="relative">
                <input name="q" value="{{ request('q') }}" class="input h-11 w-72 bg-white pl-9" placeholder="Search users by name or email...">
                <svg class="absolute left-3 top-3 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button class="btn-ghost h-11">Search</button>
        </form>
    </div>

    <!-- Table -->
    <div class="table-wrap">
        <table class="table-base">
            <thead>
                <tr>
                    <th>User Profile</th>
                    <th>System Role</th>
                    <th>Account Status</th>
                    <th>Articles</th>
                    <th>Comments</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="transition hover:bg-slate-50/70">
                        <td>
                            <div class="flex items-center gap-3.5">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover ring-2 ring-slate-100 shadow-xs">
                                <div>
                                    <p class="font-heading font-bold text-slate-900 leading-snug">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500 font-medium">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-800 border border-purple-200/60' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $user->status === 'active' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200/60' : 'bg-rose-50 text-rose-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="font-semibold text-slate-700">{{ $user->posts_count }}</td>
                        <td class="font-semibold text-slate-700">{{ $user->comments_count }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-1.5">
                                <a class="btn-ghost h-9 w-9 justify-center px-0 text-teal-700 hover:bg-teal-50" href="{{ route('admin.users.show', $user) }}" title="Manage User" aria-label="Manage User">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                                    <span class="sr-only">Manage User</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <x-empty-state title="No users found" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $users->links() }}
    </div>
</x-layouts.admin>

