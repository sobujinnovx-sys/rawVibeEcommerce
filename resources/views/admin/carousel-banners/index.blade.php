@extends('layouts.admin')

@section('title', 'Carousel Banners')
@section('page_title', 'Manage Carousel Banners')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Carousel Banners</h2>
        <a href="{{ route('admin.carousel-banners.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-indigo-500">+ New Banner</a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Banner</th>
                    <th class="text-left px-5 py-3">Sort</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($banners as $banner)
                    <tr>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-20 bg-slate-100 rounded overflow-hidden">
                                    @if ($banner->image_url)
                                        <img src="{{ $banner->image_url }}" class="h-full w-full object-cover" alt="{{ $banner->title }}">
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900">{{ $banner->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $banner->subtitle }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $banner->sort_order }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs {{ $banner->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.carousel-banners.edit', $banner) }}" class="text-indigo-600 hover:text-indigo-500 text-sm font-semibold">Edit</a>
                            <form method="POST" action="{{ route('admin.carousel-banners.destroy', $banner) }}" class="inline" onsubmit="return confirm('Delete this banner?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600 hover:text-rose-500 text-sm font-semibold ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-6 text-center text-slate-500">No carousel banners yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $banners->links() }}</div>
@endsection
