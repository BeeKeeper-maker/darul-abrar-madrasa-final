@extends('layouts.app')

@section('header', 'শ্রেণীর বিস্তারিত')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('classes.index') }}" class="btn btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                ফিরে যান
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Class Details -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium">{{ $class->name }}</h3>
                    </div>
                    <div class="card-body">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">বিভাগ</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $class->department->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ক্লাস নম্বর</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $class->class_numeric }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">শাখা</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $class->section ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ধারণক্ষমতা</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $class->capacity ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">অবস্থা</dt>
                                <dd class="mt-1">
                                    @if($class->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">তৈরির তারিখ</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $class->created_at->format('d/m/Y') }}</dd>
                            </div>
                            @if($class->description)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">বিবরণ</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $class->description }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="space-y-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium">পরিসংখ্যান</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="flex justify-between">
                            <span>ছাত্র-ছাত্রী</span>
                            <span class="font-semibold">{{ $class->students->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>বিষয় সংখ্যা</span>
                            <span class="font-semibold">{{ $class->subjects->count() ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium">দ্রুত কার্যক্রম</h3>
                    </div>
                    <div class="card-body space-y-3">
                        <a href="{{ route('classes.edit', $class) }}" class="btn btn-warning w-full">
                            সম্পাদনা করুন
                        </a>
                        <form action="{{ route('classes.destroy', $class) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-full" onclick="return confirm('আপনি কি নিশ্চিত?')">
                                ডিলিট করুন
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection