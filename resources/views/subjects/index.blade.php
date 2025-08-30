@extends('layouts.app')

@section('header', 'বিষয় ব্যবস্থাপনা')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">বিষয় তালিকা</h1>
            <a href="{{ route('subjects.create') }}" class="btn btn-primary interactive-lift glow-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                নতুন বিষয় যোগ করুন
            </a>
        </div>

        <div class="card fade-in-up">
            <div class="card-body p-0">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-header-cell">বিষয়ের নাম</th>
                            <th class="table-header-cell">কোড</th>
                            <th class="table-header-cell">শ্রেণী</th>
                            <th class="table-header-cell">শিক্ষক</th>
                            <th class="table-header-cell">পূর্ণ নম্বর</th>
                            <th class="table-header-cell">পাস নম্বর</th>
                            <th class="table-header-cell">অবস্থা</th>
                            <th class="table-header-cell">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @forelse($subjects as $subject)
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $subject->name }}</div>
                                </td>
                                <td class="table-cell">
                                    <span class="badge badge-primary">{{ $subject->code }}</span>
                                </td>
                                <td class="table-cell">{{ $subject->class->name ?? 'N/A' }}</td>
                                <td class="table-cell">{{ $subject->teacher->user->name ?? 'N/A' }}</td>
                                <td class="table-cell">
                                    <span class="badge badge-success">{{ $subject->full_mark }}</span>
                                </td>
                                <td class="table-cell">
                                    <span class="badge badge-warning">{{ $subject->pass_mark }}</span>
                                </td>
                                <td class="table-cell">
                                    @if($subject->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('subjects.show', $subject) }}" class="btn btn-sm btn-outline">দেখুন</a>
                                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-warning">সম্পাদনা</a>
                                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('আপনি কি নিশ্চিত?')">ডিলিট</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="table-cell text-center py-8">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <p class="text-lg">কোনো বিষয় পাওয়া যায়নি</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($subjects->hasPages())
            <div class="mt-6">
                {{ $subjects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection