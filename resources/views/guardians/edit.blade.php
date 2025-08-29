<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Guardian') }}
            </h2>
            <a href="{{ route('guardians.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Guardians') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('guardians.update', $guardian) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="col-span-1 md:col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $guardian->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $guardian->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password (leave blank to keep current)</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <!-- Contact Information -->
                            <div class="col-span-1 md:col-span-2 mt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                            </div>

                            <!-- Relation -->
                            <div>
                                <label for="relation" class="block text-sm font-medium text-gray-700">Relation</label>
                                <select name="relation" id="relation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="">Select Relation</option>
                                    <option value="Father" {{ old('relation', $guardian->relation) == 'Father' ? 'selected' : '' }}>Father</option>
                                    <option value="Mother" {{ old('relation', $guardian->relation) == 'Mother' ? 'selected' : '' }}>Mother</option>
                                    <option value="Guardian" {{ old('relation', $guardian->relation) == 'Guardian' ? 'selected' : '' }}>Guardian</option>
                                    <option value="Sibling" {{ old('relation', $guardian->relation) == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                    <option value="Other" {{ old('relation', $guardian->relation) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('relation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $guardian->phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alternate Phone -->
                            <div>
                                <label for="alternate_phone" class="block text-sm font-medium text-gray-700">Alternate Phone</label>
                                <input type="text" name="alternate_phone" id="alternate_phone" value="{{ old('alternate_phone', $guardian->alternate_phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('alternate_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Occupation -->
                            <div>
                                <label for="occupation" class="block text-sm font-medium text-gray-700">Occupation</label>
                                <input type="text" name="occupation" id="occupation" value="{{ old('occupation', $guardian->occupation) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('occupation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('address', $guardian->address) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Current Profile Photo -->
                            @if ($guardian->profile_photo)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current Profile Photo</label>
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($guardian->profile_photo) }}" alt="{{ $guardian->name }}" class="h-32 w-32 object-cover rounded-md">
                                    </div>
                                </div>
                            @endif

                            <!-- Profile Photo -->
                            <div>
                                <label for="profile_photo" class="block text-sm font-medium text-gray-700">
                                    {{ $guardian->profile_photo ? 'Change Profile Photo' : 'Profile Photo' }}
                                </label>
                                <input type="file" name="profile_photo" id="profile_photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('profile_photo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Is Emergency Contact -->
                            <div>
                                <div class="flex items-center mt-4">
                                    <input type="checkbox" name="is_emergency_contact" id="is_emergency_contact" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('is_emergency_contact', $guardian->is_emergency_contact) ? 'checked' : '' }}>
                                    <label for="is_emergency_contact" class="ml-2 block text-sm text-gray-700">Emergency Contact</label>
                                </div>
                                @error('is_emergency_contact')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Student Selection -->
                            <div class="col-span-1 md:col-span-2 mt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Link Students</h3>
                                <p class="text-sm text-gray-500 mb-4">Select the students associated with this guardian.</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach ($students as $student)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="student_ids[]" id="student_{{ $student->id }}" value="{{ $student->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ in_array($student->id, old('student_ids', $selectedStudents)) ? 'checked' : '' }}>
                                            <label for="student_{{ $student->id }}" class="ml-2 block text-sm text-gray-700">
                                                {{ $student->user->name }} ({{ $student->admission_number }})
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('student_ids')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update Guardian') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>