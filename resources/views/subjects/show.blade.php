@extends('layouts.app')

@section('header', 'বিষয়ের বিস্তারিত')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('subjects.index') }}" class="btn btn-outline">
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
                        <h3 class="text-lg font-medium">{{ $subject->name }}</h3>
                    </div>
                    <div class="card-body">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">বিষয়ের কোড</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $subject->code }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">শ্রেণী</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $subject->class->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">শিক্ষক</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $subject->teacher->user->name ?? 'অনির্ধারিত' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">পূর্ণ নম্বর</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $subject->full_mark }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">পাস নম্বর</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $subject->pass_mark }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">অবস্থা</dt>
                                <dd class="mt-1">
                                    @if($subject->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                    @endif
                                </dd>
                            </div>
                            @if($subject->description)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">বিবরণ</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $subject->description }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium">দ্রুত কার্যক্রম</h3>
                    </div>
                    <div class="card-body space-y-3">
                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning w-full">
                            সম্পাদনা করুন
                        </a>
                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST">
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