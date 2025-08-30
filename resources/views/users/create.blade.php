@extends('layouts.app')

@section('header', 'নতুন ব্যবহারকারী যোগ করুন')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card fade-in-up">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">ব্যবহারকারীর তথ্য</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">পূর্ণ নাম *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               class="form-input @error('name') border-danger-300 @enderror" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">ইমেইল ঠিকানা *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               class="form-input @error('email') border-danger-300 @enderror" required>
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">ফোন নম্বর</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                               class="form-input @error('phone') border-danger-300 @enderror">
                        @error('phone')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">ভূমিকা *</label>
                        <select id="role" name="role" class="form-select @error('role') border-danger-300 @enderror" required>
                            <option value="">ভূমিকা নির্বাচন করুন</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>এডমিন</option>
                            <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>শিক্ষক</option>
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>ছাত্র</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>স্টাফ</option>
                            <option value="guardian" {{ old('role') == 'guardian' ? 'selected' : '' }}>অভিভাবক</option>
                        </select>
                        @error('role')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">পাসওয়ার্ড *</label>
                        <input type="password" id="password" name="password" 
                               class="form-input @error('password') border-danger-300 @enderror" required>
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">পাসওয়ার্ড নিশ্চিতকরণ *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="form-input" required>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('users.index') }}" class="btn btn-outline">বাতিল</a>
                        <button type="submit" class="btn btn-primary">ব্যবহারকারী তৈরি করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection