@extends('layouts.app')

@section('header', 'নোটিশ সম্পাদনা')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card fade-in-up">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">নোটিশের তথ্য সম্পাদনা</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('notices.update', $notice) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="title" class="form-label">নোটিশের শিরোনাম *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $notice->title) }}" 
                               class="form-input @error('title') border-danger-300 @enderror" required>
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">নোটিশের বিস্তারিত *</label>
                        <textarea id="description" name="description" rows="6" 
                                  class="form-textarea @error('description') border-danger-300 @enderror" required>{{ old('description', $notice->description) }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="publish_date" class="form-label">প্রকাশের তারিখ *</label>
                            <input type="date" id="publish_date" name="publish_date" value="{{ old('publish_date', $notice->publish_date?->format('Y-m-d')) }}" 
                                   class="form-input @error('publish_date') border-danger-300 @enderror" required>
                            @error('publish_date')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="expiry_date" class="form-label">মেয়াদ শেষের তারিখ</label>
                            <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $notice->expiry_date?->format('Y-m-d')) }}" 
                                   class="form-input @error('expiry_date') border-danger-300 @enderror">
                            @error('expiry_date')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notice_for" class="form-label">নোটিশটি কার জন্য *</label>
                        <select id="notice_for" name="notice_for" class="form-select @error('notice_for') border-danger-300 @enderror" required>
                            <option value="">নির্বাচন করুন</option>
                            <option value="all" {{ old('notice_for', $notice->notice_for) == 'all' ? 'selected' : '' }}>সবার জন্য</option>
                            <option value="students" {{ old('notice_for', $notice->notice_for) == 'students' ? 'selected' : '' }}>ছাত্র-ছাত্রীদের জন্য</option>
                            <option value="teachers" {{ old('notice_for', $notice->notice_for) == 'teachers' ? 'selected' : '' }}>শিক্ষকদের জন্য</option>
                            <option value="staff" {{ old('notice_for', $notice->notice_for) == 'staff' ? 'selected' : '' }}>স্টাফদের জন্য</option>
                            <option value="guardians" {{ old('notice_for', $notice->notice_for) == 'guardians' ? 'selected' : '' }}>অভিভাবকদের জন্য</option>
                        </select>
                        @error('notice_for')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $notice->is_active) ? 'checked' : '' }} 
                                   class="rounded border-gray-300 text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">সক্রিয়</label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('notices.index') }}" class="btn btn-outline">বাতিল</a>
                        <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection