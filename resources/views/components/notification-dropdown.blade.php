<div x-data="{ open: false, notifications: [], unreadCount: 0 }" @click.away="open = false" class="relative">
    <!-- Notification Bell Icon -->
    <button @click="
        open = !open; 
        if (open) {
            fetch('{{ route('notifications.recent') }}')
                .then(response => response.json())
                .then(data => {
                    notifications = data.notifications;
                });
        }
    " class="relative p-1 rounded-full text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        
        <!-- Notification Badge -->
        <span 
            x-init="
                fetch('{{ route('notifications.unread-count') }}')
                    .then(response => response.json())
                    .then(data => {
                        unreadCount = data.count;
                    });
                
                // Refresh unread count every 60 seconds
                setInterval(() => {
                    fetch('{{ route('notifications.unread-count') }}')
                        .then(response => response.json())
                        .then(data => {
                            unreadCount = data.count;
                        });
                }, 60000);
            "
            x-show="unreadCount > 0"
            x-text="unreadCount"
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"
        ></span>
    </button>

    <!-- Notification Dropdown -->
    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50">
        <div class="py-1">
            <div class="px-4 py-2 flex justify-between items-center">
                <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                <a href="{{ route('notifications.index') }}" class="text-xs text-indigo-600 hover:text-indigo-900">View All</a>
            </div>
        </div>
        
        <div class="max-h-60 overflow-y-auto">
            <template x-if="notifications.length > 0">
                <div>
                    <template x-for="notification in notifications" :key="notification.id">
                        <div class="px-4 py-3 hover:bg-gray-50">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-900" x-text="notification.title"></p>
                                <span class="text-xs text-gray-500" x-text="new Date(notification.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1" x-text="notification.message"></p>
                            <div class="mt-2 flex justify-between items-center">
                                <span x-show="notification.type === 'info'" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    Info
                                </span>
                                <span x-show="notification.type === 'success'" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    Success
                                </span>
                                <span x-show="notification.type === 'warning'" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Warning
                                </span>
                                <span x-show="notification.type === 'danger'" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                    Alert
                                </span>
                                
                                <div class="flex space-x-2">
                                    <form :action="`/notifications/${notification.id}/mark-as-read`" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-900">
                                            Mark as Read
                                        </button>
                                    </form>
                                    
                                    <template x-if="notification.link">
                                        <a :href="notification.link" class="text-xs text-indigo-600 hover:text-indigo-900">
                                            View
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
            
            <template x-if="notifications.length === 0">
                <div class="px-4 py-6 text-center">
                    <p class="text-sm text-gray-500">No new notifications</p>
                </div>
            </template>
        </div>
        
        <div class="py-1">
            <form action="{{ route('notifications.mark-all-as-read') }}" method="POST">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-indigo-600 hover:bg-gray-100">
                    Mark all as read
                </button>
            </form>
        </div>
    </div>
</div>