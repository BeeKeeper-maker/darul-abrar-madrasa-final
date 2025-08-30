@extends('layouts.app')

@section('header', 'বিভাগ ব্যবস্থাপনা')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">বিভাগ তালিকা</h1>
            <a href="{{ route('departments.create') }}" class="btn btn-primary interactive-lift glow-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                নতুন বিভাগ যোগ করুন
            </a>
        </div>

        <div class="card fade-in-up">
            <div class="card-body p-0">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-header-cell">নাম</th>
                            <th class="table-header-cell">কোড</th>
                            <th class="table-header-cell">শ্রেণী সংখ্যা</th>
                            <th class="table-header-cell">শিক্ষক সংখ্যা</th>
                            <th class="table-header-cell">অবস্থা</th>
                            <th class="table-header-cell">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @forelse($departments as $department)
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $department->name }}</div>
                                </td>
                                <td class="table-cell">
                                    <span class="badge badge-primary">{{ $department->code }}</span>
                                </td>
                                <td class="table-cell">
                                    <span class="badge badge-success">{{ $department->classes_count ?? 0 }}</span>
                                </td>
                                <td class="table-cell">
                                    <span class="badge badge-success">{{ $department->teachers_count ?? 0 }}</span>
                                </td>
                                <td class="table-cell">
                                    @if($department->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-outline">দেখুন</a>
                                        <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-warning">সম্পাদনা</a>
                                        <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('আপনি কি নিশ্চিত?')">ডিলিট</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="table-cell text-center py-8">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <p class="text-lg">কোনো বিভাগ পাওয়া যায়নি</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($departments->hasPages())
            <div class="mt-6">
                {{ $departments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection