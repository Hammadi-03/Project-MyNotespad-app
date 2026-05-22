
    // ── Toast System ──
    function showToast(message, type = 'success') {
        const icons = { 
            success: '<i class="fa-solid fa-check"></i>', 
            error: '<i class="fa-solid fa-xmark"></i>', 
            info: '<i class="fa-solid fa-info"></i>',
            deleted: '<i class="fa-solid fa-trash"></i>'
        };
        const titles = {
            success: 'Success',
            error: 'Error',
            info: 'Information',
            deleted: 'Note Trashed'
        };
        
        let title = titles[type] || 'Notification';
        let displayMessage = message;
        if (type === 'deleted') {
            displayMessage = 'Note moved to trash.';
        }

        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        let undoBtn = type === 'deleted' ? `<button class="toast-undo" onclick="dismissToast(this.closest('.toast'))">Undo</button>` : '';
        
        toast.innerHTML = `
            <div class="toast-icon-wrap">
                ${icons[type] || '<i class="fa-solid fa-bell"></i>'}
            </div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${displayMessage}</div>
            </div>
            ${undoBtn}
        `;
        
        container.appendChild(toast);
        setTimeout(() => dismissToast(toast), 4000);
    }
    function dismissToast(el) {
        if (!el) return;
        el.style.animation = 'fadeOutUp .3s cubic-bezier(0.16, 1, 0.3, 1) forwards';
        setTimeout(() => el.remove(), 300);
    }

    // ── Delete Modal ──
    function confirmDelete(noteId, noteTitle, deleteUrl) {
        document.getElementById('deleteNoteTitle').textContent = '"' + noteTitle + '"';
        document.getElementById('deleteForm').action = deleteUrl;
        document.getElementById('deleteModal').classList.add('active');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });


    // ── Reusable Modal Helpers ──
    function openSettingsModal() {
        document.getElementById('settingsModal').classList.add('active');
    }
    function closeSettingsModal() {
        document.getElementById('settingsModal').classList.remove('active');
    }
    function openFeedbackModal() {
        document.getElementById('feedbackModal').classList.add('active');
    }
    function closeFeedbackModal() {
        document.getElementById('feedbackModal').classList.remove('active');
    }
    function openEditLabelsModal() {
        document.getElementById('editLabelsModal').classList.add('active');
    }
    function closeEditLabelsModal() {
        document.getElementById('editLabelsModal').classList.remove('active');
    }
    
    // Close on clicking backdrop
    document.querySelectorAll('.keep-modal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });

    // ── Label Actions ──
    function submitCreateLabel() {
        const name = document.getElementById('newLabelInput').value.trim();
        if (!name) return;
        fetch("${window.AppConfig.routeLabelsStore}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.AppConfig.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: name })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Label created', 'success');
                location.reload();
            }
        });
    }

    function showSaveLabelIcon(id) {
        document.getElementById(`label-save-${id}`).style.display = 'inline-block';
    }

    // Live theme switcher checkbox behavior
    const themeCheckbox = document.getElementById('darkThemeCheckbox');
    if (themeCheckbox) {
        themeCheckbox.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('dark-theme');
            } else {
                document.body.classList.remove('dark-theme');
            }
        });
    }

    function submitUpdateLabel(id) {
        const name = document.getElementById(`label-input-${id}`).value.trim();
        if (!name) return;
        fetch(`${window.AppConfig.urlLabels}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.AppConfig.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: name })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Label updated', 'success');
                document.getElementById(`label-save-${id}`).style.display = 'none';
            }
        });
    }

    function toggleNoteLabel(noteId, labelId, isChecked) {
        fetch(`${window.AppConfig.urlNotes}/${noteId}/labels`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.AppConfig.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ label_id: labelId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.attached ? 'Label added' : 'Label removed', 'success');
                location.reload();
            }
        });
    }

    function submitDeleteLabel(id) {
        if (!confirm('Are you sure you want to delete this label?')) return;
        fetch(`${window.AppConfig.urlLabels}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': window.AppConfig.csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Label deleted', 'success');
                document.getElementById(`label-row-${id}`).remove();
                location.reload();
            }
        });
    }

    // ── Auto-show session flash toasts ──
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showToast(@json(session('success')), 'success');
        @endif
        @if(session('error'))
            showToast(@json(session('error')), 'error');
        @endif
        @if(session('info'))
            showToast(@json(session('info')), 'info');
        @endif
        @if(session('deleted'))
            showToast('Note trashed', 'deleted');
        @endif
    });
    

function expandQuickNote() {
    const card = document.getElementById('quickNoteCard');
    const content = document.getElementById('qnContent');
    if (!card.classList.contains('expanded')) {
        card.classList.add('expanded');
        content.rows = 3;
    }
}

function closeQuickNote() {
    const card = document.getElementById('quickNoteCard');
    const content = document.getElementById('qnContent');
    if(card) {
        card.classList.remove('expanded');
        content.rows = 1;
        card.classList.remove('color-blue', 'color-green', 'color-yellow', 'color-red', 'color-purple');
        document.getElementById('quickNoteColor').value = 'default';
        removeQuickNoteImage();
        document.getElementById('quickNoteForm').reset();
    }
}

// Click outside Quick Note Form -> collapse/submit
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('quickNoteWrapper');
    const colorMenu = document.getElementById('quickNoteColorMenu');
    if (wrapper && !wrapper.contains(e.target)) {
        if (colorMenu && colorMenu.contains(e.target)) return;
        
        const title = document.getElementById('quickNoteTitle').value.trim();
        const content = document.getElementById('qnContent').value.trim();
        const image = document.getElementById('quickNoteImageInput').value;
        const color = document.getElementById('quickNoteColor').value;
        
        if (title !== '' || content !== '' || image !== '' || color !== 'default') {
            document.getElementById('quickNoteForm').submit();
        } else {
            closeQuickNote();
        }
    }
});

// Quick Note Color Picker functions
function toggleQuickNoteColorMenu(event) {
    event.stopPropagation();
    const menu = document.getElementById('quickNoteColorMenu');
    menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
}

function selectQuickNoteColor(color) {
    document.getElementById('quickNoteColor').value = color;
    const card = document.getElementById('quickNoteCard');
    card.classList.remove('color-blue', 'color-green', 'color-yellow', 'color-red', 'color-purple');
    if (color !== 'default') {
        card.classList.add(`color-${color}`);
    }
    document.getElementById('quickNoteColorMenu').style.display = 'none';
}

// Quick Note Image Preview functions
function previewQuickNoteImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('quickNoteImagePreview');
            preview.querySelector('img').src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeQuickNoteImage() {
    document.getElementById('quickNoteImageInput').value = '';
    const preview = document.getElementById('quickNoteImagePreview');
    preview.style.display = 'none';
    preview.querySelector('img').src = '';
}

// Note Card Color menu toggles
function toggleColorMenu(event, noteId) {
    event.stopPropagation();
    const menu = document.getElementById(`color-menu-${noteId}`);
    document.querySelectorAll('.color-menu').forEach(m => {
        if (m.id !== `color-menu-${noteId}`) m.style.display = 'none';
    });
    menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
}

function toggleCardMoreMenu(event, noteId) {
    event.stopPropagation();
    const menu = document.getElementById(`card-more-menu-${noteId}`);
    document.querySelectorAll('.card-more-menu').forEach(m => {
        if (m.id !== `card-more-menu-${noteId}`) m.style.display = 'none';
    });
    menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
}

// Close color & dropdown menus when clicking outside
document.addEventListener('click', () => {
    document.querySelectorAll('.color-menu').forEach(m => m.style.display = 'none');
    document.querySelectorAll('.card-more-menu').forEach(m => m.style.display = 'none');
    const qnMenu = document.getElementById('quickNoteColorMenu');
    if (qnMenu) qnMenu.style.display = 'none';
    
    const editColorMenu = document.getElementById('editModalColorMenu');
    if (editColorMenu) editColorMenu.style.display = 'none';
    const editMoreMenu = document.getElementById('editModalMoreMenu');
    if (editMoreMenu) editMoreMenu.style.display = 'none';
});

// AJAX note color update
function changeNoteColor(event, noteId, color) {
    event.stopPropagation();
    
    fetch(`${window.AppConfig.urlNotes}/${noteId}/color`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.AppConfig.csrfToken
        },
        body: JSON.stringify({ color: color })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const card = document.getElementById(`note-card-${noteId}`);
            card.classList.remove('color-blue', 'color-green', 'color-yellow', 'color-red', 'color-purple');
            if (color !== 'default') {
                card.classList.add(`color-${color}`);
            }
            document.getElementById(`color-menu-${noteId}`).style.display = 'none';
        }
    })
    .catch(err => console.error(err));
}

// Card image uploads
function triggerCardImageUpload(noteId) {
    document.getElementById(`card-image-input-${noteId}`).click();
}

function uploadCardImage(event, noteId) {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('image', file);

    fetch(`${window.AppConfig.urlNotes}/${noteId}/image`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.AppConfig.csrfToken
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const card = document.getElementById(`note-card-${noteId}`);
            let imgWrap = card.querySelector('.note-card-image-wrap');
            if (!imgWrap) {
                imgWrap = document.createElement('div');
                imgWrap.className = 'note-card-image-wrap';
                imgWrap.style.cssText = "margin: -16px -16px 12px; overflow: hidden; border-radius: 8px 8px 0 0; max-height: 240px; border-bottom: 1px solid var(--gray-100);";
                const img = document.createElement('img');
                img.style.cssText = "width: 100%; height: auto; display: block; object-fit: cover;";
                imgWrap.appendChild(img);
                card.insertBefore(imgWrap, card.firstChild);
            }
            imgWrap.querySelector('img').src = data.image_url;
        }
    })
    .catch(err => console.error(err));
}

// Edit Note Modal Javascript logic
let currentModalImageFile = null;

function openEditModal(noteId, title, content, color, imageUrl, isPinned) {
    document.getElementById('editModalNoteId').value = noteId;
    document.getElementById('editModalTitle').value = title;
    document.getElementById('editModalContent').value = content;
    document.getElementById('editModalColor').value = color;
    document.getElementById('editModalIsPinned').value = isPinned ? '1' : '0';
    
    // Update Modal Pin Button Icon color/class
    const pinBtn = document.getElementById('editModalPinBtn');
    if (isPinned) {
        pinBtn.style.color = '#202124';
        pinBtn.querySelector('i').className = 'fa-solid fa-thumbtack';
    } else {
        pinBtn.style.color = '#5f6368';
        pinBtn.querySelector('i').className = 'fa-regular fa-thumbtack';
    }

    // Set color class on Modal Card
    const card = document.getElementById('editModalCard');
    card.className = 'edit-modal-card';
    if (color && color !== 'default') {
        card.classList.add(`color-${color}`);
    }

    // Handle Image wrap
    const imgWrap = document.getElementById('editModalImageWrap');
    const img = document.getElementById('editModalImg');
    if (imageUrl && imageUrl !== '') {
        img.src = imageUrl;
        imgWrap.style.display = 'block';
    } else {
        img.src = '';
        imgWrap.style.display = 'none';
    }

    // Open backdrop
    document.getElementById('editNoteModal').classList.add('active');
    
    // Reset file input
    document.getElementById('editModalImageInput').value = '';
    currentModalImageFile = null;
}

function closeEditModalOutside(event) {
    const card = document.getElementById('editModalCard');
    const colorMenu = document.getElementById('editModalColorMenu');
    const moreMenu = document.getElementById('editModalMoreMenu');
    if (!card.contains(event.target)) {
        if (colorMenu && colorMenu.contains(event.target)) return;
        if (moreMenu && moreMenu.contains(event.target)) return;
        saveEditModal();
    }
}

function saveEditModal() {
    const noteId = document.getElementById('editModalNoteId').value;
    if (!noteId) return;

    const title = document.getElementById('editModalTitle').value.trim();
    const content = document.getElementById('editModalContent').value.trim();
    const color = document.getElementById('editModalColor').value;

    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('title', title);
    formData.append('content', content);
    formData.append('color', color);
    
    if (currentModalImageFile) {
        formData.append('image', currentModalImageFile);
    }

    const imgWrap = document.getElementById('editModalImageWrap');
    const isImageRemoved = (imgWrap.style.display === 'none');
    if (isImageRemoved) {
        formData.append('remove_image', '1');
    }

    fetch(`${window.AppConfig.urlNotes}/${noteId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.AppConfig.csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(err => {
        console.error(err);
        window.location.reload();
    });

    document.getElementById('editNoteModal').classList.remove('active');
}

function toggleEditModalColorMenu(event) {
    event.stopPropagation();
    const menu = document.getElementById('editModalColorMenu');
    menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
}

function changeEditModalColor(color) {
    document.getElementById('editModalColor').value = color;
    const card = document.getElementById('editModalCard');
    card.className = 'edit-modal-card';
    if (color !== 'default') {
        card.classList.add(`color-${color}`);
    }
    document.getElementById('editModalColorMenu').style.display = 'none';
}

function previewEditModalImage(input) {
    if (input.files && input.files[0]) {
        currentModalImageFile = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('editModalImageWrap');
            document.getElementById('editModalImg').src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeEditModalImage() {
    currentModalImageFile = null;
    document.getElementById('editModalImageInput').value = '';
    const preview = document.getElementById('editModalImageWrap');
    preview.style.display = 'none';
    document.getElementById('editModalImg').src = '';
}

function toggleEditModalMoreMenu(event) {
    event.stopPropagation();
    const menu = document.getElementById('editModalMoreMenu');
    menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
}

function deleteModalNote() {
    const noteId = document.getElementById('editModalNoteId').value;
    if (!noteId) return;

    if (confirm('Move this note to trash?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `${window.AppConfig.urlNotes}/${noteId}`;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = window.AppConfig.csrfToken;
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }
}

function duplicateModalNote() {
    const noteId = document.getElementById('editModalNoteId').value;
    if (!noteId) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `${window.AppConfig.urlNotes}/${noteId}/copy`;
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = window.AppConfig.csrfToken;
    form.appendChild(csrfInput);

    document.body.appendChild(form);
    form.submit();
}

function toggleEditModalPin() {
    const pinVal = document.getElementById('editModalIsPinned');
    const isPinned = pinVal.value === '1';
    pinVal.value = isPinned ? '0' : '1';
    
    const pinBtn = document.getElementById('editModalPinBtn');
    if (!isPinned) {
        pinBtn.style.color = '#202124';
        pinBtn.querySelector('i').className = 'fa-solid fa-thumbtack';
    } else {
        pinBtn.style.color = '#5f6368';
        pinBtn.querySelector('i').className = 'fa-regular fa-thumbtack';
    }
    
    const noteId = document.getElementById('editModalNoteId').value;
    if (noteId) {
        fetch(`${window.AppConfig.urlNotes}/${noteId}/pin`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.AppConfig.csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Updated pin state successfully
        })
        .catch(err => console.error(err));
    }
}

function archiveQuickNote() {
    document.getElementById('quickNoteIsArchived').value = '1';
    document.getElementById('quickNoteForm').submit();
}

function toggleViewMode() {
    const grids = document.querySelectorAll('.notes-grid');
    let isList = false;
    grids.forEach(grid => {
        isList = grid.classList.toggle('list-view');
    });
    localStorage.setItem('viewMode', isList ? 'list' : 'grid');
    updateViewModeIcon();
}

function updateViewModeIcon() {
    const grid = document.querySelector('.notes-grid');
    const btn = document.getElementById('viewModeToggleBtn');
    if (!grid || !btn) return;
    const isList = grid.classList.contains('list-view');
    btn.innerHTML = isList 
        ? `<svg focusable="false" viewBox="0 0 24 24" style="width:24px;height:24px;fill:currentColor;"><path d="M4 11h5V5H4v6zm0 7h5v-6H4v6zm6 0h5v-6h-5v6zm6 0h5v-6h-5v6zm-6-7h5V5h-5v6zm6-6v6h5V5h-5z"></path></svg>`
        : `<svg focusable="false" viewBox="0 0 24 24" style="width:24px;height:24px;fill:currentColor;"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"></path></svg>`;
    btn.title = isList ? 'Grid view' : 'List view';
}

function toggleSettingsDropdown(event) {
    if (event) event.stopPropagation();
    const dropdown = document.getElementById('settingsDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

// Initialize Drag and Drop (SortableJS) and View Mode
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.notes-grid').forEach(grid => {
        new Sortable(grid, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function (evt) {
                // Dragging visually shifts items instantly
            }
        });
    });

    // Restore View Mode from localStorage
    const savedViewMode = localStorage.getItem('viewMode');
    if (savedViewMode === 'list') {
        document.querySelectorAll('.notes-grid').forEach(grid => {
            grid.classList.add('list-view');
        });
    }
    updateViewModeIcon();
});

function toggleSidebar(event) {
    if (event) event.stopPropagation();
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    sidebar.classList.toggle('closed');
    mainContent.classList.toggle('expanded');
}

function toggleUserMenu(event) {
    if (event) event.stopPropagation();
    document.getElementById('userMenu').classList.toggle('open');
}

document.addEventListener('click', function(e) {
    const menu = document.getElementById('userMenu');
    if (menu && !menu.contains(e.target)) menu.classList.remove('open');
    
    const dropdown = document.getElementById('settingsDropdown');
    if (dropdown && !dropdown.contains(e.target)) dropdown.style.display = 'none';
});

// Close sidebar on overlay click (mobile)
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.querySelector('.hamburger');
    if (window.innerWidth <= 768 && sidebar && !sidebar.classList.contains('closed')) {
        if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
            sidebar.classList.add('closed');
            document.querySelector('.main-content').classList.add('expanded');
        }
    }
});

// Initialize mobile state
if (window.innerWidth <= 768) {
    document.getElementById('sidebar').classList.add('closed');
    document.querySelector('.main-content').classList.add('expanded');
}


function toggleSidebar(event) {
    if (event) event.stopPropagation();
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    sidebar.classList.toggle('closed');
    mainContent.classList.toggle('expanded');
}

function toggleUserMenu() {
    document.getElementById('userMenu').classList.toggle('open');
}
document.addEventListener('click', function(e) {
    const menu = document.getElementById('userMenu');
    if (menu && !menu.contains(e.target)) menu.classList.remove('open');
});

// Initialize mobile state
if (window.innerWidth <= 768) {
    document.getElementById('sidebar').classList.add('closed');
    document.querySelector('.main-content').classList.add('expanded');
}

