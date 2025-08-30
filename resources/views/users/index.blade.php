@extends('layouts.app')

@section('header', 'ইউজার ম্যানেজমেন্ট')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">ব্যবহারকারী তালিকা</h1>
            <a href="{{ route('users.create') }}" class="btn btn-primary interactive-lift glow-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                নতুন ব্যবহারকারী যোগ করুন
            </a>
        </div>

        <div class="card fade-in-up">
            <div class="card-body p-0">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-header-cell">নাম</th>
                            <th class="table-header-cell">ইমেইল</th>
                            <th class="table-header-cell">ফোন</th>
                            <th class="table-header-cell">ভূমিকা</th>
                            <th class="table-header-cell">অবস্থা</th>
                            <th class="table-header-cell">যোগদানের তারিখ</th>
                            <th class="table-header-cell">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @forelse($users as $user)
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($user->avatar)
                                                <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">{{ $user->email }}</td>
                                <td class="table-cell">{{ $user->phone ?? 'N/A' }}</td>
                                <td class="table-cell">
                                    <span class="badge badge-primary capitalize">{{ $user->role }}</span>
                                </td>
                                <td class="table-cell">
                                    @if($user->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td class="table-cell">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline">দেখুন</a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">সম্পাদনা</a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('আপনি কি নিশ্চিত?')">ডিলিট</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="table-cell text-center py-8">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <p class="text-lg">কোনো ব্যবহারকারী পাওয়া যায়নি</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection