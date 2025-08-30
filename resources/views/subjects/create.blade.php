@extends('layouts.app')

@section('header', 'নতুন বিষয় যোগ করুন')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card fade-in-up">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">বিষয়ের তথ্য</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('subjects.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">বিষয়ের নাম *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               class="form-input @error('name') border-danger-300 @enderror" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="code" class="form-label">বিষয়ের কোড *</label>
                        <input type="text" id="code" name="code" value="{{ old('code') }}" 
                               class="form-input @error('code') border-danger-300 @enderror" required>
                        @error('code')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="class_id" class="form-label">শ্রেণী *</label>
                        <select id="class_id" name="class_id" class="form-select @error('class_id') border-danger-300 @enderror" required>
                            <option value="">শ্রেণী নির্বাচন করুন</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="teacher_id" class="form-label">শিক্ষক</label>
                        <select id="teacher_id" name="teacher_id" class="form-select @error('teacher_id') border-danger-300 @enderror">
                            <option value="">শিক্ষক নির্বাচন করুন (ঐচ্ছিক)</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="full_mark" class="form-label">পূর্ণ নম্বর *</label>
                            <input type="number" id="full_mark" name="full_mark" value="{{ old('full_mark') }}" 
                                   class="form-input @error('full_mark') border-danger-300 @enderror" min="1" required>
                            @error('full_mark')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="pass_mark" class="form-label">পাস নম্বর *</label>
                            <input type="number" id="pass_mark" name="pass_mark" value="{{ old('pass_mark') }}" 
                                   class="form-input @error('pass_mark') border-danger-300 @enderror" min="1" required>
                            @error('pass_mark')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
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
                        <a href="{{ route('subjects.index') }}" class="btn btn-outline">বাতিল</a>
                        <button type="submit" class="btn btn-primary">বিষয় তৈরি করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection