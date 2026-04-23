@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page_title', 'Edit Product')

@section('content')
    <div class="max-w-3xl bg-white border border-slate-200 rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            @include('admin.products._form', ['product' => $product, 'categories' => $categories])
            <div class="flex justify-end gap-3 pt-3">
                <a href="{{ route('admin.products.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Cancel</a>
                <button class="bg-indigo-600 text-white px-5 py-2 rounded-full font-semibold text-sm hover:bg-indigo-500">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
