@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page_title', 'Edit Category')

@section('content')
    <div class="max-w-2xl bg-white border border-slate-200 rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-4">
            @csrf
            @method('PUT')
            @include('admin.categories._form', ['category' => $category])
            <div class="flex justify-end gap-3 pt-3">
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Cancel</a>
                <button class="bg-indigo-600 text-white px-5 py-2 rounded-full font-semibold text-sm hover:bg-indigo-500">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
