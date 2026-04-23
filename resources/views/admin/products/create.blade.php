@extends('layouts.admin')

@section('title', 'New Product')
@section('page_title', 'Create Product')

@section('content')
    <div class="max-w-3xl bg-white border border-slate-200 rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @include('admin.products._form', ['product' => null, 'categories' => $categories])
            <div class="flex justify-end gap-3 pt-3">
                <a href="{{ route('admin.products.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Cancel</a>
                <button class="bg-indigo-600 text-white px-5 py-2 rounded-full font-semibold text-sm hover:bg-indigo-500">Create Product</button>
            </div>
        </form>
    </div>
@endsection
