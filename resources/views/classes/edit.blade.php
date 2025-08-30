@extends('layouts.app')

@section('header', 'শ্রেণী সম্পাদনা')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card fade-in-up">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">শ্রেণীর তথ্য সম্পাদনা</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('classes.update', $class) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name" class="form-label">শ্রেণীর নাম *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $class->name) }}" 
                               class="form-input @error('name') border-danger-300 @enderror" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="department_id" class="form-label">বিভাগ *</label>
                        <select id="department_id" name="department_id" class="form-select @error('department_id') border-danger-300 @enderror" required>
                            <option value="">বিভাগ নির্বাচন করুন</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $class->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="class_numeric" class="form-label">ক্লাস নম্বর *</label>
                            <select id="class_numeric" name="class_numeric" class="form-select @error('class_numeric') border-danger-300 @enderror" required>
                                <option value="">ক্লাস নির্বাচন করুন</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('class_numeric', $class->class_numeric) == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('class_numeric')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="section" class="form-label">শাখা</label>
                            <input type="text" id="section" name="section" value="{{ old('section', $class->section) }}" 
                                   class="form-input @error('section') border-danger-300 @enderror">
                            @error('section')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="capacity" class="form-label">ধারণক্ষমতা</label>
                        <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $class->capacity) }}" 
                               class="form-input @error('capacity') border-danger-300 @enderror" min="1">
                        @error('capacity')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">বিবরণ</label>
                        <textarea id="description" name="description" rows="4" 
                                  class="form-textarea @error('description') border-danger-300 @enderror">{{ old('description', $class->description) }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $class->is_active) ? 'checked' : '' }} 
                                   class="rounded border-gray-300 text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">সক্রিয়</label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('classes.index') }}" class="btn btn-outline">বাতিল</a>
                        <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection