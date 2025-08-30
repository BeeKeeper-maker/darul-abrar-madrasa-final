@props(['show' => false, 'message' => 'Loading...'])

<div 
    x-data="{ show: @js($show) }" 
    x-show="show" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-gray-900 bg-opacity-80 dark:bg-opacity-80"
    style="display: none"
    id="page-loader"
>
    <div class="flex flex-col items-center space-y-4">
        <!-- Enhanced Loading Animation -->
        <div class="relative">
            <!-- Outer Ring -->
            <div class="w-16 h-16 border-4 border-gray-200 dark:border-gray-700 rounded-full animate-spin border-t-primary-600 dark:border-t-primary-500"></div>
            
            <!-- Inner Ring -->
            <div class="absolute inset-2 w-10 h-10 border-4 border-gray-200 dark:border-gray-700 rounded-full animate-spin border-t-secondary-600 dark:border-t-secondary-500" style="animation-direction: reverse; animation-duration: 0.8s;"></div>
            
            <!-- Center Dot -->
            <div class="absolute inset-6 w-4 h-4 bg-primary-600 dark:bg-primary-500 rounded-full animate-pulse"></div>
        </div>
        
        <!-- Loading Message -->
        <div class="text-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $message }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                <span class="loading-dots">Please wait</span>
            </p>
        </div>
        
        <!-- Progress Bar -->
        <div class="w-64 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full animate-pulse"></div>
        </div>
    </div>
</div>

<!-- Progress Bar at Top of Page -->
<div id="page-progress-bar" class="fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-500 via-purple-500 to-secondary-500 transform -translate-x-full transition-transform duration-300 ease-out z-50" style="display: none"></div>

<style>
    .loading-dots::after {
        content: '';
        animation: dots 1.5s steps(4, end) infinite;
    }
    
    @keyframes dots {
        0%, 20% { content: ''; }
        40% { content: '.'; }
        60% { content: '..'; }
        80%, 100% { content: '...'; }
    }
</style>

<script>
    // Global functions to control page loader
    window.showPageLoader = function(message = 'Loading...') {
        const loader = document.getElementById('page-loader');
        const progressBar = document.getElementById('page-progress-bar');
        
        if (loader) {
            // Update message if provided
            const messageElement = loader.querySelector('h3');
            if (messageElement && message) {
                messageElement.textContent = message;
            }
            
            loader.style.display = 'flex';
            loader.__x.$data.show = true;
        }
        
        if (progressBar) {
            progressBar.style.display = 'block';
            setTimeout(() => {
                progressBar.style.transform = 'translateX(0)';
            }, 10);
        }
    };
    
    window.hidePageLoader = function() {
        const loader = document.getElementById('page-loader');
        const progressBar = document.getElementById('page-progress-bar');
        
        if (loader && loader.__x) {
            loader.__x.$data.show = false;
            setTimeout(() => {
                loader.style.display = 'none';
            }, 200);
        }
        
        if (progressBar) {
            progressBar.style.transform = 'translateX(100%)';
            setTimeout(() => {
                progressBar.style.display = 'none';
                progressBar.style.transform = 'translateX(-100%)';
            }, 300);
        }
    };
    
    // Auto-hide after 10 seconds to prevent infinite loading
    window.showPageLoader = function(message = 'Loading...') {
        const loader = document.getElementById('page-loader');
        const progressBar = document.getElementById('page-progress-bar');
        
        if (loader) {
            const messageElement = loader.querySelector('h3');
            if (messageElement && message) {
                messageElement.textContent = message;
            }
            
            loader.style.display = 'flex';
            if (loader.__x) loader.__x.$data.show = true;
        }
        
        if (progressBar) {
            progressBar.style.display = 'block';
            setTimeout(() => {
                progressBar.style.transform = 'translateX(0)';
            }, 10);
        }
        
        // Auto-hide after 10 seconds
        setTimeout(() => {
            window.hidePageLoader();
        }, 10000);
    };
</script>