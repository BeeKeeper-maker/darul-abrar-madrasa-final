/**
 * Enhanced UI/UX JavaScript for Darul Abrar Madrasa Management System
 * Handles animations, loading states, and interactive features
 */

class EnhancedUI {
    constructor() {
        this.initializeComponents();
        this.setupEventListeners();
        this.initializeAnimations();
    }

    /**
     * Initialize all UI components
     */
    initializeComponents() {
        this.initializeLoadingStates();
        this.initializeTooltips();
        this.initializeModals();
        this.initializeFormValidation();
        this.initializeProgressBars();
    }

    /**
     * Setup event listeners for interactive elements
     */
    setupEventListeners() {
        // Enhanced button interactions
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', this.handleButtonClick.bind(this));
        });

        // Form enhancements
        document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(input => {
            input.addEventListener('focus', this.handleInputFocus.bind(this));
            input.addEventListener('blur', this.handleInputBlur.bind(this));
            input.addEventListener('input', this.handleInputChange.bind(this));
        });

        // Card hover effects
        document.querySelectorAll('.card-interactive').forEach(card => {
            card.addEventListener('mouseenter', this.handleCardHover.bind(this));
            card.addEventListener('mouseleave', this.handleCardLeave.bind(this));
        });

        // Navigation enhancements
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', this.handleNavigation.bind(this));
        });

        // Table row interactions
        document.querySelectorAll('.table-row').forEach(row => {
            row.addEventListener('click', this.handleTableRowClick.bind(this));
        });
    }

    /**
     * Initialize page animations
     */
    initializeAnimations() {
        // Stagger animations for cards
        this.staggerAnimations('.card', 'fade-in-up', 100);
        
        // Animate sidebar links
        this.staggerAnimations('.sidebar-link', 'slide-in-left', 50);
        
        // Animate form groups
        this.staggerAnimations('.form-group', 'fade-in', 75);
    }

    /**
     * Handle button click with loading state
     */
    handleButtonClick(event) {
        const button = event.target.closest('.btn');
        if (!button || button.disabled) return;

        // Don't add loading state to buttons with specific classes
        if (button.classList.contains('btn-no-loading')) return;

        this.showButtonLoading(button);
        
        // Auto-remove loading state after reasonable time if not manually removed
        setTimeout(() => {
            this.hideButtonLoading(button);
        }, 3000);
    }

    /**
     * Show loading state on button
     */
    showButtonLoading(button) {
        button.classList.add('btn-loading');
        button.disabled = true;
        button.dataset.originalText = button.textContent;
    }

    /**
     * Hide loading state on button
     */
    hideButtonLoading(button) {
        button.classList.remove('btn-loading');
        button.disabled = false;
        if (button.dataset.originalText) {
            button.textContent = button.dataset.originalText;
        }
    }

    /**
     * Handle input focus with animations
     */
    handleInputFocus(event) {
        const input = event.target;
        const label = input.parentElement.querySelector('.form-label');
        const group = input.closest('.form-group');

        if (label) {
            label.classList.add('form-label-focused');
        }
        
        if (group) {
            group.classList.add('form-group-focused');
        }

        // Add subtle scale animation
        input.style.transform = 'scale(1.01)';
    }

    /**
     * Handle input blur
     */
    handleInputBlur(event) {
        const input = event.target;
        const label = input.parentElement.querySelector('.form-label');
        const group = input.closest('.form-group');

        if (label) {
            label.classList.remove('form-label-focused');
        }
        
        if (group) {
            group.classList.remove('form-group-focused');
        }

        // Remove scale animation
        input.style.transform = '';
    }

    /**
     * Handle input change for real-time validation
     */
    handleInputChange(event) {
        const input = event.target;
        this.validateInput(input);
    }

    /**
     * Simple input validation with visual feedback
     */
    validateInput(input) {
        const value = input.value.trim();
        const type = input.type;
        let isValid = true;

        // Basic validation rules
        if (input.hasAttribute('required') && !value) {
            isValid = false;
        } else if (type === 'email' && value && !this.isValidEmail(value)) {
            isValid = false;
        } else if (input.hasAttribute('minlength') && value.length < parseInt(input.getAttribute('minlength'))) {
            isValid = false;
        }

        // Update visual state
        if (isValid) {
            input.classList.remove('border-danger-300');
            input.classList.add('border-success-300');
        } else {
            input.classList.remove('border-success-300');
            input.classList.add('border-danger-300');
        }
    }

    /**
     * Email validation helper
     */
    isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    /**
     * Handle card hover effects
     */
    handleCardHover(event) {
        const card = event.target.closest('.card-interactive');
        card.style.transform = 'translateY(-4px) scale(1.01)';
        card.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
    }

    /**
     * Handle card leave effects
     */
    handleCardLeave(event) {
        const card = event.target.closest('.card-interactive');
        card.style.transform = '';
        card.style.boxShadow = '';
    }

    /**
     * Handle navigation with loading indication
     */
    handleNavigation(event) {
        const link = event.target.closest('.sidebar-link');
        if (!link || link.classList.contains('sidebar-link-active')) return;

        // Show navigation loading
        this.showPageLoading();
    }

    /**
     * Handle table row clicks
     */
     handleTableRowClick(event) {
        const row = event.target.closest('.table-row');
        if (!row || !row.hasAttribute('data-href')) return;

        // Add click animation
        row.style.transform = 'scale(0.98)';
        setTimeout(() => {
            row.style.transform = '';
        }, 150);
    }

    /**
     * Show page loading indicator
     */
    showPageLoading() {
        let progressBar = document.querySelector('.progress-bar');
        if (!progressBar) {
            progressBar = document.createElement('div');
            progressBar.className = 'progress-bar';
            document.body.appendChild(progressBar);
        }
        
        progressBar.classList.add('loading');
        
        // Hide after navigation
        setTimeout(() => {
            this.hidePageLoading();
        }, 1000);
    }

    /**
     * Hide page loading indicator
     */
    hidePageLoading() {
        const progressBar = document.querySelector('.progress-bar');
        if (progressBar) {
            progressBar.classList.remove('loading');
        }
    }

    /**
     * Initialize loading states for various elements
     */
    initializeLoadingStates() {
        // Add loading states to existing elements that might need them
        document.querySelectorAll('[data-loading]').forEach(element => {
            this.showElementLoading(element);
        });
    }

    /**
     * Show loading state for any element
     */
    showElementLoading(element) {
        element.classList.add('loading-pulse');
        element.style.pointerEvents = 'none';
    }

    /**
     * Hide loading state for any element
     */
    hideElementLoading(element) {
        element.classList.remove('loading-pulse');
        element.style.pointerEvents = '';
    }

    /**
     * Initialize tooltips (simple implementation)
     */
    initializeTooltips() {
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', this.showTooltip.bind(this));
            element.addEventListener('mouseleave', this.hideTooltip.bind(this));
        });
    }

    /**
     * Show tooltip
     */
    showTooltip(event) {
        const element = event.target;
        const text = element.dataset.tooltip;
        
        const tooltip = document.createElement('div');
        tooltip.className = 'absolute z-50 px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg tooltip';
        tooltip.textContent = text;
        tooltip.style.top = '-2rem';
        tooltip.style.left = '50%';
        tooltip.style.transform = 'translateX(-50%)';
        
        element.style.position = 'relative';
        element.appendChild(tooltip);
        
        // Animate in
        setTimeout(() => {
            tooltip.style.opacity = '1';
        }, 10);
    }

    /**
     * Hide tooltip
     */
    hideTooltip(event) {
        const tooltip = event.target.querySelector('.tooltip');
        if (tooltip) {
            tooltip.remove();
        }
    }

    /**
     * Initialize modal functionality
     */
    initializeModals() {
        document.querySelectorAll('[data-modal]').forEach(trigger => {
            trigger.addEventListener('click', this.openModal.bind(this));
        });
        
        document.querySelectorAll('.modal-backdrop, [data-modal-close]').forEach(closer => {
            closer.addEventListener('click', this.closeModal.bind(this));
        });
    }

    /**
     * Open modal with animation
     */
    openModal(event) {
        event.preventDefault();
        const modalId = event.target.dataset.modal;
        const modal = document.getElementById(modalId);
        
        if (!modal) return;
        
        modal.classList.remove('hidden');
        modal.classList.add('modal-enter');
        
        setTimeout(() => {
            modal.classList.remove('modal-enter');
            modal.classList.add('modal-enter-active');
        }, 10);
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    /**
     * Close modal with animation
     */
    closeModal(event) {
        const modal = event.target.closest('.modal-container') || 
                     document.querySelector('.modal-container:not(.hidden)');
        
        if (!modal) return;
        
        modal.classList.add('modal-exit');
        modal.classList.remove('modal-enter-active');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('modal-exit');
            document.body.style.overflow = '';
        }, 300);
    }

    /**
     * Initialize form validation
     */
    initializeFormValidation() {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', this.handleFormSubmit.bind(this));
        });
    }

    /**
     * Handle form submission with validation
     */
    handleFormSubmit(event) {
        const form = event.target;
        const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
        
        // Show loading on submit button
        if (submitButton) {
            this.showButtonLoading(submitButton);
        }
    }

    /**
     * Initialize progress bars
     */
    initializeProgressBars() {
        document.querySelectorAll('.progress-bar[data-value]').forEach(bar => {
            const value = parseInt(bar.dataset.value);
            const fill = bar.querySelector('.progress-fill');
            
            if (fill) {
                setTimeout(() => {
                    fill.style.width = `${value}%`;
                }, 100);
            }
        });
    }

    /**
     * Stagger animations for multiple elements
     */
    staggerAnimations(selector, animationClass, delay = 100) {
        const elements = document.querySelectorAll(selector);
        
        elements.forEach((element, index) => {
            setTimeout(() => {
                element.classList.add(animationClass);
            }, index * delay);
        });
    }

    /**
     * Show toast notification
     */
    showToast(message, type = 'info', duration = 5000) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type} scale-in`;
        toast.innerHTML = `
            <div class="flex items-center p-4">
                <div class="flex-1">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <button class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove
        setTimeout(() => {
            toast.classList.add('fade-out');
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 300);
        }, duration);
    }
}

// Global functions for external use
globalThis.showToast = function(message, type, duration) {
    if (globalThis.enhancedUI) {
        globalThis.enhancedUI.showToast(message, type, duration);
    }
};

globalThis.showPageLoading = function() {
    if (globalThis.enhancedUI) {
        globalThis.enhancedUI.showPageLoading();
    }
};

globalThis.hidePageLoading = function() {
    if (globalThis.enhancedUI) {
        globalThis.enhancedUI.hidePageLoading();
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    globalThis.enhancedUI = new EnhancedUI();
    console.log('Enhanced UI initialized successfully');
});

// Initialize for Livewire compatibility
document.addEventListener('livewire:load', function() {
    if (!globalThis.enhancedUI) {
        globalThis.enhancedUI = new EnhancedUI();
    }
});

// Reinitialize after Livewire updates
document.addEventListener('livewire:update', function() {
    if (globalThis.enhancedUI) {
        globalThis.enhancedUI.initializeComponents();
    }
});

export default EnhancedUI;