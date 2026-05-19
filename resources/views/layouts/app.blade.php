<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MyNotepad - Your thoughts, organized beautifully. A modern note-taking app for productivity.">
    <title>MyNotepad - Your thoughts, organized beautifully</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Design Tokens ── */
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338CA;
            --primary-light: #EEF2FF;
            --secondary: #06B6D4;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --danger-hover: #DC2626;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
            --sidebar-w: 260px;
            --topbar-h: 64px;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow: 0 4px 12px rgba(0,0,0,.08);
            --shadow-lg: 0 10px 40px rgba(0,0,0,.12);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--gray-800);
            background: var(--gray-50);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 20px; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 600;
            border: none; cursor: pointer;
            transition: all .2s ease;
            text-decoration: none; line-height: 1;
            white-space: nowrap;
        }
        .btn-primary {
            background: var(--primary); color: #fff;
        }
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79,70,229,.35);
        }
        .btn-secondary {
            background: #fff; color: var(--primary);
            border: 1.5px solid var(--primary);
        }
        .btn-secondary:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
        }
        .btn-ghost {
            background: transparent; color: var(--gray-600);
            border: 1.5px solid var(--gray-200);
        }
        .btn-ghost:hover { background: var(--gray-100); color: var(--gray-800); }
        .btn-danger {
            background: var(--danger); color: #fff;
        }
        .btn-danger:hover {
            background: var(--danger-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239,68,68,.3);
        }
        .btn-sm { padding: 7px 14px; font-size: 13px; }
        .btn-lg { padding: 14px 28px; font-size: 16px; border-radius: var(--radius); }
        .btn-icon { padding: 8px; border-radius: var(--radius-sm); }

        /* ── Inputs ── */
        .input-field {
            width: 100%; padding: 12px 16px;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 14px; font-family: inherit; color: var(--gray-800);
            background: #fff; transition: all .2s ease;
            outline: none;
        }
        .input-field:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
        }
        .input-field::placeholder { color: var(--gray-400); }

        /* ── Cards ── */
        .card {
            background: #fff; border: 1px solid var(--gray-200);
            border-radius: var(--radius); padding: 24px;
            transition: all .2s ease;
        }
        .card:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        /* ── Toast notifications ── */
        #toast-container {
            position: fixed; top: 24px; right: 24px;
            z-index: 9999; display: flex; flex-direction: column; gap: 10px;
        }
        .toast {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 20px; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 500;
            box-shadow: var(--shadow-lg);
            animation: slideIn .3s ease forwards;
            min-width: 280px; max-width: 380px;
        }
        .toast.success { background: #ECFDF5; color: #065F46; border-left: 4px solid var(--success); }
        .toast.error   { background: #FEF2F2; color: #991B1B; border-left: 4px solid var(--danger); }
        .toast.info    { background: #EFF6FF; color: #1E40AF; border-left: 4px solid #3B82F6; }
        .toast.deleted { 
            background: #323232; color: #fff; border: none; 
            border-radius: 4px; box-shadow: 0 3px 5px -1px rgba(0,0,0,.2), 0 6px 10px 0 rgba(0,0,0,.14), 0 1px 18px 0 rgba(0,0,0,.12);
        }
        .toast-undo {
            color: #F4B400; font-weight: 500; background: none; border: none; cursor: pointer;
            padding: 0 8px; font-size: 14px; margin-left: auto; font-family: inherit; letter-spacing: 0.3px;
        }
        .toast-undo:hover { text-decoration: underline; }
        .toast-icon { font-size: 18px; flex-shrink: 0; }
        .toast-close {
            margin-left: auto; background: none; border: none;
            cursor: pointer; color: inherit; opacity: .6; font-size: 16px;
            padding: 2px; flex-shrink: 0;
        }
        .toast-close:hover { opacity: 1; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideOut {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(40px); }
        }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 1000;
            background: rgba(17,24,39,.5); backdrop-filter: blur(4px);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none; transition: opacity .2s ease;
        }
        .modal-overlay.active { opacity: 1; pointer-events: all; }
        .modal {
            background: #fff; border-radius: var(--radius);
            padding: 32px; max-width: 420px; width: 90%;
            box-shadow: var(--shadow-lg);
            transform: scale(.95); transition: transform .2s ease;
        }
        .modal-overlay.active .modal { transform: scale(1); }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); position: fixed; z-index: 100; height: 100vh; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            .topbar-logo span { display: none; }
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div id="toast-container"></div>

    @yield('content')

    <!-- Delete Confirm Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div style="text-align:center; margin-bottom:20px;">
                <div style="width:56px;height:56px;background:#FEF2F2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:24px;"><i class="fa-regular fa-trash-can" style="color:#EF4444;font-size:24px;"></i></div>
                <h3 style="font-size:18px;font-weight:700;color:var(--gray-900);margin-bottom:8px;">Delete Note</h3>
                <p style="color:var(--gray-500);font-size:14px;">Are you sure you want to delete <strong id="deleteNoteTitle"></strong>? This action cannot be undone.</p>
            </div>
            <div style="display:flex;gap:12px;">
                <button class="btn btn-ghost" style="flex:1;" onclick="closeDeleteModal()">Cancel</button>
                <form id="deleteForm" method="POST" style="flex:1;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width:100%;">Delete Note</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
    // ── Toast System ──
    function showToast(message, type = 'success') {
        const icons = { 
            success: '<i class="fa-solid fa-circle-check" style="color:#10B981;"></i>', 
            error: '<i class="fa-solid fa-circle-xmark" style="color:#EF4444;"></i>', 
            info: '<i class="fa-solid fa-circle-info" style="color:#3B82F6;"></i>' 
        };
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        if (type === 'deleted') {
            toast.innerHTML = `
                <span style="flex:1;">Note trashed</span>
                <button class="toast-undo" onclick="dismissToast(this.parentElement)">Undo</button>
                <button class="toast-close" style="color:#fff; opacity:0.7; margin-left:8px;" onclick="dismissToast(this.parentElement)">✕</button>
            `;
        } else {
            toast.innerHTML = `
                <span class="toast-icon">${icons[type]}</span>
                <span>${message}</span>
                <button class="toast-close" onclick="dismissToast(this.parentElement)">✕</button>
            `;
        }
        
        container.appendChild(toast);
        setTimeout(() => dismissToast(toast), 4000);
    }
    function dismissToast(el) {
        el.style.animation = 'slideOut .3s ease forwards';
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

    // ── Mobile Sidebar ──
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) sidebar.classList.toggle('open');
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
    </script>
</body>
</html>
