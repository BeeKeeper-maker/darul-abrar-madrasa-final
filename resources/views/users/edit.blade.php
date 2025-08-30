@extends('layouts.app')

@section('header', 'ব্যবহারকারী সম্পাদনা')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card fade-in-up">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">ব্যবহারকারীর তথ্য সম্পাদনা</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name" class="form-label">পূর্ণ নাম *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                               class="form-input @error('name') border-danger-300 @enderror" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">ইমেইল ঠিকানা *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="form-input @error('email') border-danger-300 @enderror" required>
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">ফোন নম্বর</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                               class="form-input @error('phone') border-danger-300 @enderror">
                        @error('phone')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">ভূমিকা *</label>
                        <select id="role" name="role" class="form-select @error('role') border-danger-300 @enderror" required>
                            <option value="">ভূমিকা নির্বাচন করুন</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>এডমিন</option>
                            <option value="teacher" {{ old('role', $user->role) == 'teacher' ? 'selected' : '' }}>শিক্ষক</option>
                            <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>ছাত্র</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>স্টাফ</option>
                            <option value="guardian" {{ old('role', $user->role) == 'guardian' ? 'selected' : '' }}>অভিভাবক</option>
                        </select>
                        @error('role')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">নতুন পাসওয়ার্ড (ঐচ্ছিক)</label>
                        <input type="password" id="password" name="password" 
                               class="form-input @error('password') border-danger-300 @enderror">
                        <p class="text-sm text-gray-500 mt-1">পাসওয়ার্ড পরিবর্তন করতে চাইলে নতুন পাসওয়ার্ড দিন</p>
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">পাসওয়ার্ড নিশ্চিতকরণ</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="form-input">
                    </div>

                    <div class="form-group">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }} 
                                   class="rounded border-gray-300 text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">সক্রিয়</label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('users.index') }}" class="btn btn-outline">বাতিল</a>
                        <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection