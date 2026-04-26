@extends('layouts.admin')

@section('title', 'Edit Banner')
@section('page_title', 'Edit Carousel Banner')

@section('content')
    <div class="max-w-3xl bg-white border border-slate-200 rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.carousel-banners.update', $banner) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            @include('admin.carousel-banners._form', ['banner' => $banner])
            <div class="flex items-center gap-3 pt-2">
                <button class="bg-indigo-600 text-white rounded-full px-5 py-2.5 text-sm font-semibold hover:bg-indigo-500">Update Banner</button>
                <a href="{{ route('admin.carousel-banners.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-500">Cancel</a>
            </div>
        </form>
    </div>
@endsection
