@extends('layouts.app')

@section('header', 'বিভাগ সম্পাদনা')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card fade-in-up">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">বিভাগের তথ্য সম্পাদনা</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('departments.update', $department) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name" class="form-label">বিভাগের নাম *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $department->name) }}" 
                               class="form-input @error('name') border-danger-300 @enderror" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="code" class="form-label">বিভাগের কোড *</label>
                        <input type="text" id="code" name="code" value="{{ old('code', $department->code) }}" 
                               class="form-input @error('code') border-danger-300 @enderror" required>
                        @error('code')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">বিবরণ</label>
                        <textarea id="description" name="description" rows="4" 
                                  class="form-textarea @error('description') border-danger-300 @enderror">{{ old('description', $department->description) }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $department->is_active) ? 'checked' : '' }} 
                                   class="rounded border-gray-300 text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">সক্রিয়</label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('departments.index') }}" class="btn btn-outline">বাতিল</a>
                        <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection