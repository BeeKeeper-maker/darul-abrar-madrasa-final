@extends('layouts.app')

@section('header', 'নতুন বিভাগ যোগ করুন')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card fade-in-up">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">বিভাগের তথ্য</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('departments.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">বিভাগের নাম *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               class="form-input @error('name') border-danger-300 @enderror" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="code" class="form-label">বিভাগের কোড *</label>
                        <input type="text" id="code" name="code" value="{{ old('code') }}" 
                               class="form-input @error('code') border-danger-300 @enderror" required>
                        @error('code')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">বিবরণ</label>
                        <textarea id="description" name="description" rows="4" 
                                  class="form-textarea @error('description') border-danger-300 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('departments.index') }}" class="btn btn-outline">বাতিল</a>
                        <button type="submit" class="btn btn-primary">বিভাগ তৈরি করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection