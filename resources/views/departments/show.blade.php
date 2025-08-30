@extends('layouts.app')

@section('header', 'বিভাগের বিস্তারিত')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('departments.index') }}" class="btn btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                ফিরে যান
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium">{{ $department->name }}</h3>
                    </div>
                    <div class="card-body">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">বিভাগের কোড</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $department->code }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">অবস্থা</dt>
                                <dd class="mt-1">
                                    @if($department->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                    @endif
                                </dd>
                            </div>
                            @if($department->description)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">বিবরণ</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $department->description }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium">পরিসংখ্যান</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="flex justify-between">
                            <span>শ্রেণী সংখ্যা</span>
                            <span class="font-semibold">{{ $department->classes->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>শিক্ষক সংখ্যা</span>
                            <span class="font-semibold">{{ $department->teachers->count() ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection