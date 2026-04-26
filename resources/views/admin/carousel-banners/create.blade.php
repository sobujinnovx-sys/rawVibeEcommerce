@extends('layouts.admin')

@section('title', 'Create Banner')
@section('page_title', 'Create Carousel Banner')

@section('content')
    <div class="max-w-3xl bg-white border border-slate-200 rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.carousel-banners.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @include('admin.carousel-banners._form')
            <div class="flex items-center gap-3 pt-2">
                <button class="bg-indigo-600 text-white rounded-full px-5 py-2.5 text-sm font-semibold hover:bg-indigo-500">Create Banner</button>
                <a href="{{ route('admin.carousel-banners.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-500">Cancel</a>
            </div>
        </form>
    </div>
@endsection
