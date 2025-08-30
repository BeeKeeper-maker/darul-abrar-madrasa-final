@extends('layouts.app')

@section('header', 'নোটিশ বোর্ড')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">নোটিশ বোর্ড</h1>
            <a href="{{ route('notices.create') }}" class="btn btn-primary interactive-lift glow-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                নতুন নোটিশ যোগ করুন
            </a>
        </div>

        <div class="card fade-in-up">
            <div class="card-body p-0">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-header-cell">শিরোনাম</th>
                            <th class="table-header-cell">ধরন</th>
                            <th class="table-header-cell">অগ্রাধিকার</th>
                            <th class="table-header-cell">প্রকাশকারী</th>
                            <th class="table-header-cell">প্রকাশের তারিখ</th>
                            <th class="table-header-cell">মেয়াদ শেষ</th>
                            <th class="table-header-cell">অবস্থা</th>
                            <th class="table-header-cell">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @forelse($notices as $notice)
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $notice->title }}</div>
                                </td>
                                <td class="table-cell">
                                    <span class="badge badge-primary">{{ $notice->type }}</span>
                                </td>
                                <td class="table-cell">
                                    @if($notice->priority === 'high')
                                        <span class="badge badge-danger">উচ্চ</span>
                                    @elseif($notice->priority === 'medium')
                                        <span class="badge badge-warning">মধ্যম</span>
                                    @else
                                        <span class="badge badge-success">কম</span>
                                    @endif
                                </td>
                                <td class="table-cell">{{ $notice->user->name }}</td>
                                <td class="table-cell">{{ $notice->published_at ? $notice->published_at->format('d/m/Y') : 'N/A' }}</td>
                                <td class="table-cell">{{ $notice->expires_at ? $notice->expires_at->format('d/m/Y') : 'N/A' }}</td>
                                <td class="table-cell">
                                    @if($notice->is_published)
                                        <span class="badge badge-success">প্রকাশিত</span>
                                    @else
                                        <span class="badge badge-danger">অপ্রকাশিত</span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('notices.show', $notice) }}" class="btn btn-sm btn-outline">দেখুন</a>
                                        <a href="{{ route('notices.edit', $notice) }}" class="btn btn-sm btn-warning">সম্পাদনা</a>
                                        <form action="{{ route('notices.destroy', $notice) }}" method="POST" class="inline-block">
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
                                        <p class="text-lg">কোনো নোটিশ পাওয়া যায়নি</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($notices->hasPages())
            <div class="mt-6">
                {{ $notices->links() }}
            </div>
        @endif
    </div>
</div>
@endsection