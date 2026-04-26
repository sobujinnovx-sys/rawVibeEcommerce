@extends('layouts.admin')

@section('title', 'New Coupon')
@section('page_title', 'Create Coupon')

@section('content')
    <div class="max-w-3xl bg-white border border-slate-200 rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-4">
            @csrf
            @include('admin.coupons._form', ['coupon' => null])
            <div class="flex justify-end gap-3 pt-3">
                <a href="{{ route('admin.coupons.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Cancel</a>
                <button class="bg-indigo-600 text-white px-5 py-2 rounded-full font-semibold text-sm hover:bg-indigo-500">Create Coupon</button>
            </div>
        </form>
    </div>
@endsection