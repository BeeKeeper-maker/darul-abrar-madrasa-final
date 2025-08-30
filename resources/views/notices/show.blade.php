@extends('layouts.app')

@section('header', 'নোটিশের বিস্তারিত')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('notices.index') }}" class="btn btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                ফিরে যান
            </a>
        </div>

        <div class="card fade-in-up">
            <div class="card-header">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $notice->title }}</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            প্রকাশকারী: {{ $notice->publishedBy->name ?? 'N/A' }} | 
                            {{ $notice->publish_date ? $notice->publish_date->format('d F Y') : 'N/A' }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($notice->is_active)
                            <span class="badge badge-success">সক্রিয়</span>
                        @else
                            <span class="badge badge-danger">নিষ্ক্রিয়</span>
                        @endif
                        <span class="badge badge-primary">{{ ucfirst($notice->notice_for) }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="prose max-w-none dark:prose-invert">
                    {!! nl2br(e($notice->description)) !!}
                </div>

                @if($notice->expiry_date)
                    <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <span class="text-sm text-yellow-800 dark:text-yellow-200">
                                এই নোটিশটি {{ $notice->expiry_date->format('d F Y') }} তারিখে মেয়াদ শেষ হবে
                            </span>
                        </div>
                    </div>
                @endif

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('notices.edit', $notice) }}" class="btn btn-warning">সম্পাদনা করুন</a>
                    <form action="{{ route('notices.destroy', $notice) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('আপনি কি নিশ্চিত?')">
                            ডিলিট করুন
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection