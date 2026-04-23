@extends('layouts.admin')

@section('title', 'Users')
@section('page_title', 'Manage Users')

@section('content')
    <form method="GET" class="mb-4 flex gap-2 max-w-md">
        <input name="search" value="{{ $search }}" placeholder="Search by name or email..."
               class="flex-1 rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        <button class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-semibold">Search</button>
    </form>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Name</th>
                    <th class="text-left px-5 py-3">Email</th>
                    <th class="text-left px-5 py-3">Role</th>
                    <th class="text-left px-5 py-3">Joined</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-5 py-3 font-medium">{{ $user->name }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $user->email }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-slate-500">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            <form method="POST" action="{{ route('admin.users.role', $user) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'customer' : 'admin' }}">
                                <button class="text-indigo-600 hover:text-indigo-500 text-sm font-semibold">
                                    {{ $user->role === 'admin' ? 'Demote' : 'Promote to Admin' }}
                                </button>
                            </form>
                            @if ($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-rose-600 hover:text-rose-500 text-sm font-semibold ml-2">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-6 text-center text-slate-500">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
@endsection
