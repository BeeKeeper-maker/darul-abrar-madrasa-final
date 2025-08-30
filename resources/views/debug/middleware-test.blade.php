@extends('layouts.app')

@section('header', 'Middleware Debug Test')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Middleware Debug Information</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- User Information -->
            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-3">Current User</h3>
                @auth
                    <div class="space-y-2 text-blue-700 dark:text-blue-300">
                        <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Role:</strong> <span class="bg-blue-200 dark:bg-blue-700 px-2 py-1 rounded">{{ Auth::user()->role }}</span></p>
                        <p><strong>Active:</strong> {{ Auth::user()->is_active ? 'Yes' : 'No' }}</p>
                    </div>
                @else
                    <p class="text-blue-700 dark:text-blue-300">Not authenticated</p>
                @endauth
            </div>
            
            <!-- Middleware Status -->
            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-3">Middleware Status</h3>
                <div class="space-y-2 text-green-700 dark:text-green-300">
                    <p><strong>Auth Middleware:</strong> ✅ Working</p>
                    <p><strong>Role Middleware:</strong> ✅ Registered</p>
                    <p><strong>Laravel Version:</strong> 12.x</p>
                    <p><strong>Bootstrap Config:</strong> ✅ Updated</p>
                </div>
            </div>
        </div>
        
        <!-- Test Links -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Test Navigation Links</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @auth
                    <!-- Basic auth test -->
                    <a href="{{ route('test.role') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-center transition-colors">
                        Test Role Middleware
                    </a>
                    
                    @if(Auth::user()->role === 'admin')
                        <!-- Admin specific tests -->
                        <a href="{{ route('test.admin') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-center transition-colors">
                            Test Admin Role
                        </a>
                        <a href="{{ route('students.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-center transition-colors">
                            Students (Admin)
                        </a>
                        <a href="{{ route('teachers.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-center transition-colors">
                            Teachers (Admin)
                        </a>
                        <a href="{{ route('fees.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-center transition-colors">
                            Fees (Admin)
                        </a>
                        <a href="{{ route('settings.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-center transition-colors">
                            Settings (Admin)
                        </a>
                    @endif
                    
                    @if(Auth::user()->role === 'teacher')
                        <!-- Teacher specific tests -->
                        <a href="{{ route('test.teacher') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-center transition-colors">
                            Test Teacher Role
                        </a>
                        <a href="{{ route('attendances.index') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-center transition-colors">
                            Attendance (Teacher)
                        </a>
                        <a href="{{ route('results.index') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-center transition-colors">
                            Results (Teacher)
                        </a>
                    @endif
                @else
                    <p class="text-gray-500 dark:text-gray-400 col-span-full text-center">Please login to test middleware</p>
                @endauth
            </div>
        </div>
        
        <!-- Current Route Info -->
        <div class="mt-8 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Current Route Information</h3>
            <div class="text-gray-700 dark:text-gray-300 space-y-1">
                <p><strong>Route Name:</strong> {{ Route::currentRouteName() ?? 'N/A' }}</p>
                <p><strong>Route URI:</strong> {{ request()->path() }}</p>
                <p><strong>Method:</strong> {{ request()->method() }}</p>
                <p><strong>Middleware:</strong> {{ json_encode(Route::current() ? Route::current()->middleware() : []) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click handlers for test links
    const testLinks = document.querySelectorAll('a[href*="test-"]');
    testLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            fetch(this.href)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ Test Passed: ' + data.success);
                    } else {
                        alert('❌ Test Failed: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Test error:', error);
                    alert('❌ Network error during test');
                });
        });
    });
});
</script>
@endpush