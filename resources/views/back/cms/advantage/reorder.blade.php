@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Atur Urutan Keunggulan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms.advantage.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Petunjuk:</strong> Seret dan lepas item untuk mengubah urutan. Perubahan akan tersimpan otomatis.
                    </div>

                    <div id="sortable-container">
                        @if($advantages && $advantages->count() > 0)
                            @foreach($advantages as $advantage)
                                <div class="sortable-item card mb-3" data-id="{{ $advantage->id }}" data-order="{{ $advantage->order_number }}">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="drag-handle" title="Seret untuk mengubah urutan">
                                                    <i class="fas fa-grip-vertical text-muted fa-lg"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="order-number badge badge-primary fs-6">
                                                    {{ $advantage->order_number }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                @if($advantage->icon)
                                                    <img src="{{ $advantage->icon_url }}" alt="{{ $advantage->title }}" 
                                                         class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px; border-radius: 4px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <h5 class="mb-1">{{ $advantage->title }}</h5>
                                                <p class="mb-0 text-muted">{{ Str::limit($advantage->description, 100) }}</p>
                                            </div>
                                            <div class="col-auto">
                                                @if($advantage->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Nonaktif</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data keunggulan untuk diurutkan.</p>
                                <a href="{{ route('admin.cms.advantage.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Keunggulan
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($advantages && $advantages->count() > 0)
                        <div class="mt-4 pt-3 border-top">
                            <button type="button" id="save-order-btn" class="btn btn-success" disabled>
                                <i class="fas fa-save"></i> Simpan Urutan
                            </button>
                            <span id="save-status" class="text-muted ms-2"></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.sortable-item {
    transition: all 0.3s ease;
    cursor: grab;
}

.sortable-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.sortable-item.sortable-chosen {
    cursor: grabbing;
    opacity: 0.8;
    transform: rotate(5deg);
}

.sortable-item.sortable-ghost {
    opacity: 0.4;
    background: #f8f9fa;
}

.drag-handle {
    cursor: grab;
    padding: 10px;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.drag-handle:hover {
    background-color: #e9ecef;
}

.order-number {
    font-size: 14px;
    font-weight: bold;
    padding: 8px 12px;
    min-width: 40px;
    text-align: center;
}

.sortable-item .card-body {
    padding: 1rem;
}

/* Animation untuk perubahan order number */
.order-number {
    transition: all 0.3s ease;
}

.order-updated {
    animation: orderPulse 0.6s ease-in-out;
}

@keyframes orderPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); background-color: #28a745; color: white; }
    100% { transform: scale(1); }
}

/* Loading state */
.saving {
    opacity: 0.7;
    pointer-events: none;
}

.saving .drag-handle {
    cursor: not-allowed;
}
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('sortable-container');
    const saveBtn = document.getElementById('save-order-btn');
    const saveStatus = document.getElementById('save-status');
    let hasChanges = false;
    let originalOrder = [];

    if (!container) return;

    // Store original order
    document.querySelectorAll('.sortable-item').forEach((item, index) => {
        originalOrder.push({
            id: parseInt(item.dataset.id),
            order: index + 1
        });
    });

    // Initialize SortableJS
    const sortable = new Sortable(container, {
        animation: 200,
        easing: "cubic-bezier(0.4, 0, 0.2, 1)",
        handle: '.drag-handle',
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        
        onStart: function(evt) {
            container.classList.add('sorting');
        },
        
        onEnd: function(evt) {
            container.classList.remove('sorting');
            updateOrderNumbers();
            checkForChanges();
        }
    });

    function updateOrderNumbers() {
        const items = container.querySelectorAll('.sortable-item');
        items.forEach((item, index) => {
            const orderBadge = item.querySelector('.order-number');
            const newOrder = index + 1;
            const oldOrder = parseInt(orderBadge.textContent);
            
            if (oldOrder !== newOrder) {
                orderBadge.textContent = newOrder;
                orderBadge.classList.add('order-updated');
                
                setTimeout(() => {
                    orderBadge.classList.remove('order-updated');
                }, 600);
            }
            
            item.dataset.order = newOrder;
        });
    }

    function checkForChanges() {
        const currentOrder = [];
        document.querySelectorAll('.sortable-item').forEach((item, index) => {
            currentOrder.push({
                id: parseInt(item.dataset.id),
                order: index + 1
            });
        });

        // Compare with original order
        hasChanges = JSON.stringify(originalOrder) !== JSON.stringify(currentOrder);
        
        if (hasChanges) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Urutan';
            saveStatus.textContent = 'Ada perubahan yang belum disimpan';
            saveStatus.className = 'text-warning ms-2';
        } else {
            saveBtn.disabled = true;
            saveStatus.textContent = '';
        }
    }

    // Save order functionality
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            if (!hasChanges) return;

            const orderData = [];
            document.querySelectorAll('.sortable-item').forEach((item, index) => {
                orderData.push({
                    id: parseInt(item.dataset.id),
                    order: index + 1
                });
            });

            // Show loading state
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            saveStatus.textContent = 'Menyimpan perubahan...';
            saveStatus.className = 'text-info ms-2';
            container.classList.add('saving');

            fetch('{{ route("admin.cms.advantage.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    order: orderData
                })
            })
            .then(response => response.json())
            .then(data => {
                container.classList.remove('saving');
                
                if (data.success) {
                    // Update original order
                    originalOrder = [...orderData];
                    hasChanges = false;
                    
                    saveBtn.disabled = true;
                    saveBtn.innerHTML = '<i class="fas fa-check"></i> Tersimpan';
                    saveStatus.textContent = 'Urutan berhasil disimpan';
                    saveStatus.className = 'text-success ms-2';
                    
                    // Show success notification
                    showNotification('success', data.message);
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        saveBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Urutan';
                        saveStatus.textContent = '';
                    }, 2000);
                } else {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Urutan';
                    saveStatus.textContent = 'Gagal menyimpan';
                    saveStatus.className = 'text-danger ms-2';
                    
                    showNotification('error', data.message || 'Gagal menyimpan urutan');
                }
            })
            .catch(error => {
                container.classList.remove('saving');
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Urutan';
                saveStatus.textContent = 'Error!';
                saveStatus.className = 'text-danger ms-2';
                
                showNotification('error', 'Terjadi kesalahan sistem');
            });
        });
    }

    function showNotification(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('.card-body').prepend(notification);
        
        setTimeout(() => {
            notification.fadeOut();
        }, 3000);
    }
});
</script>
@endpush
