@extends('layouts.app')

@section('header', 'শ্রেণী ব্যবস্থাপনা')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">শ্রেণী তালিকা</h1>
            <a href="{{ route('classes.create') }}" class="btn btn-primary interactive-lift glow-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                নতুন শ্রেণী যোগ করুন
            </a>
        </div>

        <!-- Classes Table -->
        <div class="card fade-in-up">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">সব শ্রেণী</h3>
            </div>
            <div class="card-body p-0">
                <div class="overflow-hidden">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">নাম</th>
                                <th class="table-header-cell">বিভাগ</th>
                                <th class="table-header-cell">ক্লাস</th>
                                <th class="table-header-cell">শাখা</th>
                                <th class="table-header-cell">ধারণক্ষমতা</th>
                                <th class="table-header-cell">অবস্থা</th>
                                <th class="table-header-cell">কার্যক্রম</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @forelse($classes as $class)
                                <tr class="table-row">
                                    <td class="table-cell">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $class->name }}</div>
                                    </td>
                                    <td class="table-cell">
                                        <span class="text-gray-600 dark:text-gray-400">
                                            {{ $class->department->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="table-cell">
                                        <span class="badge badge-primary">{{ $class->class_numeric }}</span>
                                    </td>
                                    <td class="table-cell">{{ $class->section ?? 'N/A' }}</td>
                                    <td class="table-cell">{{ $class->capacity ?? 'N/A' }}</td>
                                    <td class="table-cell">
                                        @if($class->is_active)
                                            <span class="badge badge-success">সক্রিয়</span>
                                        @else
                                            <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                        @endif
                                    </td>
                                    <td class="table-cell">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-outline interactive-scale" title="দেখুন">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-warning interactive-scale" title="সম্পাদনা">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('classes.destroy', $class) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger interactive-scale" title="ডিলিট" onclick="return confirm('আপনি কি নিশ্চিত?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="table-cell text-center py-8">
                                        <div class="text-gray-500 dark:text-gray-400">
                                            <p class="text-lg">কোনো শ্রেণী পাওয়া যায়নি</p>
                                            <p class="text-sm">নতুন শ্রেণী যোগ করতে উপরের বাটনে ক্লিক করুন</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($classes->hasPages())
            <div class="mt-6">
                {{ $classes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection