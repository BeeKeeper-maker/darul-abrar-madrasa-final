@extends('layouts.app')

@section('title', 'My Profile - দারুল আবরার মাদ্রাসা')

@push('styles')
<style>
.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.profile-card {
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}
.stat-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 15px;
    padding: 1.5rem;
    color: white;
    text-align: center;
    transition: transform 0.3s ease;
}
.stat-card:hover {
    transform: scale(1.05);
}
.badge-role {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: capitalize;
}
.badge-admin { background: linear-gradient(135deg, #667eea, #764ba2); }
.badge-teacher { background: linear-gradient(135deg, #f093fb, #f5576c); }
.badge-student { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.badge-guardian { background: linear-gradient(135deg, #43e97b, #38f9d7); }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <!-- Profile Header -->
    <div class="profile-header text-white py-12 mb-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="mb-6 md:mb-0 md:mr-8">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="profile-avatar object-cover">
                    @else
                        <div class="profile-avatar bg-white bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-user text-4xl text-white"></i>
                        </div>
                    @endif
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $user->name }}</h1>
                    <p class="text-lg opacity-90 mb-3">{{ $user->email }}</p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2">
                        @foreach($user->roles as $role)
                            <span class="badge-role badge-{{ $role->name }} text-white">
                                {{ $role->name === 'admin' ? 'প্রশাসক' : 
                                   ($role->name === 'teacher' ? 'শিক্ষক' : 
                                   ($role->name === 'student' ? 'ছাত্র' : 'অভিভাবক')) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @php
                $stats = app('App\Http\Controllers\Auth\ProfileController')->getDashboardStats();
            @endphp
            
            @if($user->hasRole('student'))
                <div class="stat-card">
                    <i class="fas fa-book text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">{{ $stats['total_subjects'] ?? 0 }}</h3>
                    <p class="text-sm opacity-90">মোট বিষয়</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-chart-line text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">{{ $stats['attendance_percentage'] ?? 0 }}%</h3>
                    <p class="text-sm opacity-90">উপস্থিতির হার</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="fas fa-money-bill text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">৳{{ number_format($stats['pending_fees'] ?? 0) }}</h3>
                    <p class="text-sm opacity-90">বকেয়া ফি</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333;">
                    <i class="fas fa-trophy text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">{{ $stats['total_results'] ?? 0 }}</h3>
                    <p class="text-sm opacity-75">মোট ফলাফল</p>
                </div>
            @elseif($user->hasRole('teacher'))
                <div class="stat-card">
                    <i class="fas fa-users text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">{{ $stats['total_students'] ?? 0 }}</h3>
                    <p class="text-sm opacity-90">মোট ছাত্র</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-chalkboard text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">{{ $stats['total_classes'] ?? 0 }}</h3>
                    <p class="text-sm opacity-90">মোট ক্লাস</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="fas fa-book text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">{{ $stats['total_subjects'] ?? 0 }}</h3>
                    <p class="text-sm opacity-90">মোট বিষয়</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333;">
                    <i class="fas fa-tasks text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">{{ $stats['pending_results'] ?? 0 }}</h3>
                    <p class="text-sm opacity-75">বাকি ফলাফল</p>
                </div>
            @elseif($user->hasRole('guardian'))
                <div class="stat-card">
                    <i class="fas fa-child text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">{{ $stats['total_children'] ?? 0 }}</h3>
                    <p class="text-sm opacity-90">মোট সন্তান</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-money-bill text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">৳{{ number_format($stats['total_pending_fees'] ?? 0) }}</h3>
                    <p class="text-sm opacity-90">মোট বকেয়া ফি</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="fas fa-chart-line text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">{{ $stats['average_attendance'] ?? 0 }}%</h3>
                    <p class="text-sm opacity-90">গড় উপস্থিতি</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333;">
                    <i class="fas fa-bell text-3xl mb-3"></i>
                    <h3 class="text-2xl font-bold">{{ $stats['total_notifications'] ?? 0 }}</h3>
                    <p class="text-sm opacity-75">নতুন বিজ্ঞপ্তি</p>
                </div>
            @endif
        </div>

        <!-- Profile Information & Settings -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Profile Information -->
            <div class="profile-card bg-white p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-user-circle text-blue-500 mr-3"></i>
                    ব্যক্তিগত তথ্য
                </h2>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Upload -->
                    <div class="text-center mb-6">
                        <div class="relative inline-block">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-blue-200">
                            @else
                                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center border-4 border-blue-200">
                                    <i class="fas fa-user text-2xl text-gray-400"></i>
                                </div>
                            @endif
                            <label for="avatar" class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-2 cursor-pointer hover:bg-blue-600 transition">
                                <i class="fas fa-camera text-sm"></i>
                            </label>
                            <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden">
                        </div>
                        @if($user->avatar)
                            <button type="button" onclick="deleteAvatar()" class="mt-2 text-red-500 text-sm hover:text-red-700">
                                <i class="fas fa-trash mr-1"></i>ছবি মুছুন
                            </button>
                        @endif
                    </div>

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">নাম *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">ইমেইল *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">ফোন নম্বর</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">জন্ম তারিখ</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('date_of_birth')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">লিঙ্গ</label>
                            <select id="gender" name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">নির্বাচন করুন</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>পুরুষ</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>মহিলা</option>
                            </select>
                            @error('gender')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">ঠিকানা</label>
                        <textarea id="address" name="address" rows="3" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role-specific fields -->
                    @if($user->hasRole('student') && $user->student)
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">ছাত্র তথ্য</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="father_name" class="block text-sm font-medium text-gray-700 mb-2">পিতার নাম</label>
                                    <input type="text" id="father_name" name="father_name" value="{{ old('father_name', $user->student->father_name) }}" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="mother_name" class="block text-sm font-medium text-gray-700 mb-2">মাতার নাম</label>
                                    <input type="text" id="mother_name" name="mother_name" value="{{ old('mother_name', $user->student->mother_name) }}" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-2">রক্তের গ্রুপ</label>
                                    <select id="blood_group" name="blood_group" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                            <option value="{{ $group }}" {{ old('blood_group', $user->student->blood_group) == $group ? 'selected' : '' }}>{{ $group }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            আপডেট করুন
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Change -->
            <div class="profile-card bg-white p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-lock text-red-500 mr-3"></i>
                    পাসওয়ার্ড পরিবর্তন
                </h2>

                <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">বর্তমান পাসওয়ার্ড *</label>
                        <input type="password" id="current_password" name="current_password" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" required>
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">নতুন পাসওয়ার্ড *</label>
                        <input type="password" id="password" name="password" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">কমপক্ষে ৮ অক্ষর হতে হবে</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">পাসওয়ার্ড নিশ্চিত করুন *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition flex items-center">
                            <i class="fas fa-key mr-2"></i>
                            পাসওয়ার্ড পরিবর্তন করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteAvatar() {
    if (confirm('আপনি কি নিশ্চিত যে প্রোফাইল ছবি মুছে ফেলতে চান?')) {
        fetch('{{ route("profile.delete-avatar") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

// Preview avatar before upload
document.getElementById('avatar').addEventListener('change', function(e) {
    if (e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.profile-avatar img');
            if (preview) {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endpush