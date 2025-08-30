@extends('layouts.app')

@section('header', 'ব্যবহারকারীর বিস্তারিত')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('users.index') }}" class="btn btn-outline">
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
                        <div class="flex items-center">
                            @if($user->avatar)
                                <img class="h-12 w-12 rounded-full mr-4" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                            @else
                                <div class="h-12 w-12 rounded-full bg-primary-600 flex items-center justify-center mr-4">
                                    <span class="text-lg font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <h3 class="text-lg font-medium">{{ $user->name }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ইমেইল</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ফোন</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ভূমিকা</dt>
                                <dd class="mt-1">
                                    <span class="badge badge-primary capitalize">{{ $user->role }}</span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">অবস্থা</dt>
                                <dd class="mt-1">
                                    @if($user->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">যোগদানের তারিখ</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">শেষ আপডেট</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d/m/Y') }}</dd>
                            </div>
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
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning w-full">
                            সম্পাদনা করুন
                        </a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-full" onclick="return confirm('আপনি কি নিশ্চিত?')">
                                    ডিলিট করুন
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection