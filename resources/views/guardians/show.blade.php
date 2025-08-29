<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Guardian Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('guardians.edit', $guardian) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('guardians.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Guardian Profile -->
                        <div class="col-span-1 bg-white p-6 rounded-lg shadow">
                            <div class="flex flex-col items-center">
                                @if ($guardian->profile_photo)
                                    <img src="{{ Storage::url($guardian->profile_photo) }}" alt="{{ $guardian->name }}" class="h-32 w-32 object-cover rounded-full mb-4">
                                @else
                                    <div class="h-32 w-32 rounded-full bg-gray-300 flex items-center justify-center mb-4">
                                        <span class="text-4xl text-gray-600">{{ substr($guardian->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <h3 class="text-xl font-semibold text-gray-800">{{ $guardian->name }}</h3>
                                <p class="text-gray-600">{{ $guardian->relation }}</p>
                                @if ($guardian->is_emergency_contact)
                                    <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Emergency Contact
                                    </span>
                                @endif
                            </div>

                            <div class="mt-6 border-t border-gray-200 pt-4">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Email</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $guardian->email }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $guardian->phone }}</p>
                                    </div>
                                    @if ($guardian->alternate_phone)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Alternate Phone</h4>
                                            <p class="mt-1 text-sm text-gray-900">{{ $guardian->alternate_phone }}</p>
                                        </div>
                                    @endif
                                    @if ($guardian->occupation)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Occupation</h4>
                                            <p class="mt-1 text-sm text-gray-900">{{ $guardian->occupation }}</p>
                                        </div>
                                    @endif
                                    @if ($guardian->address)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Address</h4>
                                            <p class="mt-1 text-sm text-gray-900">{{ $guardian->address }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Children Information -->
                        <div class="col-span-1 md:col-span-2 bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Children</h3>
                            
                            @if ($guardian->students->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($guardian->students as $student)
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                                    <span class="text-indigo-600">{{ substr($student->user->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $student->user->name }}</h4>
                                                    <p class="text-xs text-gray-500">{{ $student->admission_number }}</p>
                                                </div>
                                            </div>
                                            <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
                                                <div>
                                                    <span class="font-medium text-gray-500">Class:</span>
                                                    <span class="text-gray-900">{{ $student->class->name }}</span>
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-500">Roll:</span>
                                                    <span class="text-gray-900">{{ $student->roll_number }}</span>
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-500">Gender:</span>
                                                    <span class="text-gray-900">{{ $student->gender }}</span>
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-500">Status:</span>
                                                    <span class="text-gray-900">{{ $student->is_active ? 'Active' : 'Inactive' }}</span>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <a href="{{ route('students.show', $student) }}" class="text-xs text-indigo-600 hover:text-indigo-900">View Student Details</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No children linked to this guardian.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>