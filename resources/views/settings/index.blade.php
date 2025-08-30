@extends('layouts.app')

@section('header', 'সেটিংস')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">অ্যাপ্লিকেশন সেটিংস</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">মাদ্রাসার সাধারণ তথ্য ও সেটিংস পরিবর্তন করুন</p>
        </div>

        <!-- Settings Form -->
        <div class="card fade-in-up">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">সাধারণ সেটিংস</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- App Name -->
                    <div class="form-group">
                        <label for="app_name" class="form-label">মাদ্রাসার নাম *</label>
                        <input type="text" id="app_name" name="app_name" value="{{ old('app_name', $settings['app_name'] ?? 'দারুল আবরার মডেল কামিল মাদ্রাসা') }}" 
                               class="form-input @error('app_name') border-danger-300 @enderror" required>
                        @error('app_name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Academic Session -->
                    <div class="form-group">
                        <label for="academic_session" class="form-label">শিক্ষাবর্ষ</label>
                        <input type="text" id="academic_session" name="academic_session" value="{{ old('academic_session', $settings['academic_session'] ?? '২০২৪-২০২৫') }}" 
                               class="form-input @error('academic_session') border-danger-300 @enderror" 
                               placeholder="উদাহরণ: ২০২৪-২০২৫">
                        @error('academic_session')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address" class="form-label">ঠিকানা</label>
                        <textarea id="address" name="address" rows="4" 
                                  class="form-textarea @error('address') border-danger-300 @enderror" 
                                  placeholder="মাদ্রাসার সম্পূর্ণ ঠিকানা লিখুন">{{ old('address', $settings['address'] ?? '') }}</textarea>
                        @error('address')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- App Logo -->
                    <div class="form-group">
                        <label for="app_logo" class="form-label">মাদ্রাসার লোগো</label>
                        <div class="mt-2 flex items-center space-x-4">
                            @if(!empty($settings['app_logo']))
                                <img src="{{ asset('storage/' . $settings['app_logo']) }}" alt="Current Logo" class="h-16 w-16 rounded-md object-cover bg-gray-100 dark:bg-gray-700">
                            @else
                                <div class="h-16 w-16 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 18"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <input id="app_logo" name="app_logo" type="file" accept="image/*" 
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600"/>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">বর্তমান লোগো রাখতে চাইলে খালি রাখুন। সর্বোচ্চ ফাইল সাইজ: ২ MB</p>
                            </div>
                        </div>
                        @error('app_logo')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="btn btn-primary interactive-lift glow-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            সেটিংস সংরক্ষণ করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // File input preview
    const logoInput = document.getElementById('app_logo');
    logoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector('img[alt="Current Logo"]');
                if (preview) {
                    preview.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Form submission enhancement
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.innerHTML = `
                <div class="spinner mr-2"></div>
                সংরক্ষণ করা হচ্ছে...
            `;
            submitButton.disabled = true;
        }
    });
});
</script>
@endpush
@endsection
