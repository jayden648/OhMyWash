// resources/js/app.js
import './bootstrap';
import 'bootstrap';

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert.classList.contains('show')) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }
        }, 5000);
    });

    // Initialize all interactive components
    initializeOrderCalculator();
    initializeStatusTracking();
    initializeDatePickers();
    initializeConfirmationDialogs();
    initializeImagePreview();
    initializeSearchFilters();
    initializeInfiniteScroll();
    initializeNotifications();
});

// Order Calculator for Customer Order Create
function initializeOrderCalculator() {
    const quantityInput = document.getElementById('quantity');
    const totalPriceElement = document.getElementById('total-price');
    const totalQuantityElement = document.getElementById('total-quantity');
    const unitPriceElement = document.getElementById('unit-price');
    
    if (quantityInput && totalPriceElement) {
        const unitPrice = parseFloat(unitPriceElement.textContent.replace(/[^0-9]/g, ''));
        
        function updateTotal() {
            const quantity = parseInt(quantityInput.value) || 1;
            const total = unitPrice * quantity;
            
            totalQuantityElement.textContent = quantity;
            totalPriceElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
            
            // Update form validation
            validateOrderForm();
        }
        
        quantityInput.addEventListener('input', updateTotal);
        quantityInput.addEventListener('change', updateTotal);
        
        // Initialize on page load
        updateTotal();
    }
}

// Status Tracking Animation
function initializeStatusTracking() {
    const timelineItems = document.querySelectorAll('.timeline-item');
    
    timelineItems.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            item.style.transition = 'all 0.5s ease';
            
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 100);
        }, index * 200);
    });
}

// Date Picker Initialization
function initializeDatePickers() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    
    dateInputs.forEach(input => {
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        input.min = today;
        
        // Set maximum date to 30 days from today
        const maxDate = new Date();
        maxDate.setDate(maxDate.getDate() + 30);
        input.max = maxDate.toISOString().split('T')[0];
        
        // Add validation
        input.addEventListener('change', function() {
            validateDateInput(this);
        });
    });
}

// Confirmation Dialogs
function initializeConfirmationDialogs() {
    // Cancel Order Confirmation
    const cancelButtons = document.querySelectorAll('button[onclick*="cancel"]');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');
            if (form) {
                showConfirmationModal(
                    'Batalkan Pesanan',
                    'Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.',
                    'Batalkan',
                    'btn-danger',
                    () => form.submit()
                );
            }
        });
    });
    
    // Status Update Confirmation
    const statusButtons = document.querySelectorAll('button[onclick*="status"]');
    statusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');
            const status = form.querySelector('input[name="status"]').value;
            const statusText = getStatusText(status);
            
            if (form) {
                showConfirmationModal(
                    'Update Status',
                    `Apakah Anda yakin ingin mengubah status pesanan menjadi "${statusText}"?`,
                    'Update',
                    'btn-primary',
                    () => form.submit()
                );
            }
        });
    });
}

// Image Preview for Service Images
function initializeImagePreview() {
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });
}

// Search and Filter Functionality
function initializeSearchFilters() {
    const searchInput = document.getElementById('search');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const statusFilters = document.querySelectorAll('.status-filter');
    
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterResults();
            }, 300);
        });
    }
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            applyFilter(filter);
            
            // Update active state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    statusFilters.forEach(filter => {
        filter.addEventListener('change', function() {
            filterByStatus(this.value);
        });
    });
}

// Infinite Scroll for Orders/Services
function initializeInfiniteScroll() {
    const loadMoreButton = document.getElementById('load-more');
    const container = document.getElementById('content-container');
    
    if (loadMoreButton && container) {
        loadMoreButton.addEventListener('click', function() {
            const currentPage = parseInt(this.dataset.page) || 1;
            const nextPage = currentPage + 1;
            
            loadMoreContent(nextPage);
        });
        
        // Auto-load on scroll
        window.addEventListener('scroll', function() {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 1000) {
                const loadMoreButton = document.getElementById('load-more');
                if (loadMoreButton && loadMoreButton.style.display !== 'none') {
                    loadMoreButton.click();
                }
            }
        });
    }
}

// Notification System
function initializeNotifications() {
    // Check for new notifications every 30 seconds
    setInterval(checkNotifications, 30000);
    
    // Handle notification clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.notification-item')) {
            const notification = e.target.closest('.notification-item');
            markNotificationAsRead(notification.dataset.id);
        }
    });
}

// Utility Functions
function validateOrderForm() {
    const form = document.getElementById('order-form');
    if (!form) return;
    
    const quantity = document.getElementById('quantity').value;
    const pickupDate = document.getElementById('pickup_date').value;
    const pickupAddress = document.getElementById('pickup_address').value;
    const submitButton = form.querySelector('button[type="submit"]');
    
    const isValid = quantity > 0 && pickupDate && pickupAddress.trim();
    
    if (submitButton) {
        submitButton.disabled = !isValid;
        submitButton.classList.toggle('btn-secondary', !isValid);
        submitButton.classList.toggle('btn-primary', isValid);
    }
}

function validateDateInput(input) {
    const selectedDate = new Date(input.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (selectedDate < today) {
        showAlert('Tanggal pickup tidak boleh kurang dari hari ini!', 'danger');
        input.value = '';
        return false;
    }
    
    return true;
}

function showConfirmationModal(title, message, confirmText, confirmClass, onConfirm) {
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">${title}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>${message}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn ${confirmClass}" id="confirm-action">${confirmText}</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
    
    document.getElementById('confirm-action').addEventListener('click', function() {
        bootstrapModal.hide();
        onConfirm();
    });
    
    modal.addEventListener('hidden.bs.modal', function() {
        document.body.removeChild(modal);
    });
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alert-container') || document.body;
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    alertContainer.insertBefore(alert, alertContainer.firstChild);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 150);
        }
    }, 5000);
}

function getStatusText(status) {
    const statusMap = {
        'pending': 'Menunggu',
        'confirmed': 'Dikonfirmasi',
        'in_progress': 'Sedang Diproses',
        'completed': 'Selesai',
        'cancelled': 'Dibatalkan'
    };
    return statusMap[status] || status;
}

function filterResults() {
    const searchTerm = document.getElementById('search').value.toLowerCase();
    const items = document.querySelectorAll('.filterable-item');
    
    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        const shouldShow = text.includes(searchTerm);
        
        item.style.display = shouldShow ? 'block' : 'none';
        
        // Add fade animation
        if (shouldShow) {
            item.style.animation = 'fadeIn 0.3s ease';
        }
    });
}

function applyFilter(filter) {
    const items = document.querySelectorAll('.filterable-item');
    
    items.forEach(item => {
        const shouldShow = filter === 'all' || item.classList.contains(filter);
        item.style.display = shouldShow ? 'block' : 'none';
        
        if (shouldShow) {
            item.style.animation = 'fadeIn 0.3s ease';
        }
    });
}

function filterByStatus(status) {
    const items = document.querySelectorAll('.status-filterable');
    
    items.forEach(item => {
        const itemStatus = item.dataset.status;
        const shouldShow = !status || itemStatus === status;
        
        item.style.display = shouldShow ? 'block' : 'none';
        
        if (shouldShow) {
            item.style.animation = 'fadeIn 0.3s ease';
        }
    });
}

function loadMoreContent(page) {
    const loadMoreButton = document.getElementById('load-more');
    const container = document.getElementById('content-container');
    
    if (loadMoreButton) {
        loadMoreButton.disabled = true;
        loadMoreButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
    }
    
    const url = new URL(window.location);
    url.searchParams.set('page', page);
    
    fetch(url)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newItems = doc.querySelectorAll('.loadable-item');
            
            newItems.forEach(item => {
                container.appendChild(item);
                item.style.animation = 'fadeInUp 0.5s ease';
            });
            
            // Update page number
            if (loadMoreButton) {
                loadMoreButton.dataset.page = page;
                loadMoreButton.disabled = false;
                loadMoreButton.innerHTML = 'Muat Lebih Banyak';
                
                // Hide if no more items
                if (newItems.length === 0) {
                    loadMoreButton.style.display = 'none';
                }
            }
        })
        .catch(error => {
            console.error('Error loading more content:', error);
            showAlert('Gagal memuat konten. Silakan coba lagi.', 'danger');
            
            if (loadMoreButton) {
                loadMoreButton.disabled = false;
                loadMoreButton.innerHTML = 'Muat Lebih Banyak';
            }
        });
}

function checkNotifications() {
    fetch('/api/notifications')
        .then(response => response.json())
        .then(data => {
            if (data.notifications && data.notifications.length > 0) {
                updateNotificationBadge(data.notifications.length);
                displayNotifications(data.notifications);
            }
        })
        .catch(error => {
            console.error('Error checking notifications:', error);
        });
}

function updateNotificationBadge(count) {
    const badge = document.getElementById('notification-badge');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'inline' : 'none';
    }
}

function displayNotifications(notifications) {
    const container = document.getElementById('notification-container');
    if (!container) return;
    
    container.innerHTML = '';
    
    notifications.forEach(notification => {
        const item = document.createElement('div');
        item.className = 'notification-item';
        item.dataset.id = notification.id;
        item.innerHTML = `
            <div class="notification-icon">
                <i class="fas fa-${notification.icon}"></i>
            </div>
            <div class="notification-content">
                <h6>${notification.title}</h6>
                <p>${notification.message}</p>
                <small class="text-muted">${notification.created_at}</small>
            </div>
        `;
        
        container.appendChild(item);
    });
}

function markNotificationAsRead(notificationId) {
    fetch(`/api/notifications/${notificationId}/read`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = document.querySelector(`[data-id="${notificationId}"]`);
            if (notification) {
                notification.classList.add('read');
            }
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

// Real-time Updates using WebSockets (if available)
function initializeWebSocketConnection() {
    if (typeof window.Echo !== 'undefined') {
        window.Echo.channel('orders')
            .listen('OrderStatusUpdated', (e) => {
                showAlert(`Status pesanan ${e.order.order_number} telah diperbarui menjadi ${getStatusText(e.order.status)}`, 'info');
                
                // Update UI if on orders page
                const orderCard = document.querySelector(`[data-order-id="${e.order.id}"]`);
                if (orderCard) {
                    const statusBadge = orderCard.querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.className = `status-badge status-${e.order.status}`;
                        statusBadge.textContent = getStatusText(e.order.status);
                    }
                }
            });
    }
}

// Initialize WebSocket connection if available
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.Echo !== 'undefined') {
        initializeWebSocketConnection();
    }
});

// Export functions for use in Blade templates
window.CuciSepatuApp = {
    showAlert,
    showConfirmationModal,
    validateOrderForm,
    validateDateInput,
    updateNotificationBadge,
    markNotificationAsRead
};

// CSS Animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .notification-item {
        padding: 12px;
        border-bottom: 1px solid #e9ecef;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .notification-item:hover {
        background-color: #f8f9fa;
    }
    
    .notification-item.read {
        opacity: 0.6;
    }
    
    .notification-icon {
        width: 40px;
        height: 40px;
        background: #007bff;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        float: left;
        margin-right: 12px;
    }
    
    .notification-content h6 {
        margin: 0 0 4px 0;
        font-size: 0.9rem;
    }
    
    .notification-content p {
        margin: 0 0 4px 0;
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-pending { background: #fff3cd; color: #856404; }
    .status-confirmed { background: #d4edda; color: #155724; }
    .status-in_progress { background: #cce5ff; color: #004085; }
    .status-completed { background: #d1ecf1; color: #0c5460; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
`;
document.head.appendChild(style);