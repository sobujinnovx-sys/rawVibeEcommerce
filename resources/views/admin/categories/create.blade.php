@extends('layouts.admin')

@section('title', 'New Category')
@section('page_title', 'Create Category')

@section('content')
    <div class="max-w-2xl bg-white border border-slate-200 rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf
            @include('admin.categories._form', ['category' => null])
            <div class="flex justify-end gap-3 pt-3">
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Cancel</a>
                <button class="bg-indigo-600 text-white px-5 py-2 rounded-full font-semibold text-sm hover:bg-indigo-500">Create Category</button>
            </div>
        </form>
    </div>
@endsection
