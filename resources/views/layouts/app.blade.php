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
    
</head>
<body class="{{ ($globalSettings['dark_theme'] ?? false) ? 'dark-theme' : '' }}">
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

    <!-- Settings Modal -->
    <div class="keep-modal-backdrop" id="settingsModal">
        <div class="keep-modal-card">
            <h3 style="font-size:18px;font-weight:700;margin-bottom:16px;">Settings</h3>
            <form id="settingsForm" method="POST" action="{{ route('settings.save') }}">
                @csrf
                <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:24px;">
                    <label style="display:flex; align-items:center; gap:12px; cursor:pointer;">
                        <input type="checkbox" name="add_to_bottom" value="1" {{ ($globalSettings['add_to_bottom'] ?? true) ? 'checked' : '' }} style="width:18px; height:18px;">
                        <span>Add new items to the bottom</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:12px; cursor:pointer;">
                        <input type="checkbox" name="move_checked_to_bottom" value="1" {{ ($globalSettings['move_checked_to_bottom'] ?? true) ? 'checked' : '' }} style="width:18px; height:18px;">
                        <span>Move checked items to bottom</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:12px; cursor:pointer;">
                        <input type="checkbox" name="dark_theme" id="darkThemeCheckbox" value="1" {{ ($globalSettings['dark_theme'] ?? false) ? 'checked' : '' }} style="width:18px; height:18px;">
                        <span>Enable dark theme</span>
                    </label>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" class="btn btn-ghost" onclick="closeSettingsModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Send Feedback Modal -->
    <div class="keep-modal-backdrop" id="feedbackModal">
        <div class="keep-modal-card">
            <h3 style="font-size:18px;font-weight:700;margin-bottom:16px;">Send feedback to Antigravity Notes</h3>
            <form id="feedbackForm" method="POST" action="{{ route('feedback.submit') }}">
                @csrf
                <textarea name="content" required placeholder="Tell us what you think! Describe your issue or share your ideas..." style="width:100%; height:120px; padding:12px; border:1px solid var(--gray-200); border-radius:6px; font-family:inherit; resize:none; margin-bottom:16px;"></textarea>
                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" class="btn btn-ghost" onclick="closeFeedbackModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Labels Modal -->
    <div class="keep-modal-backdrop" id="editLabelsModal">
        <div class="keep-modal-card" style="max-width: 360px; padding: 16px;">
            <h3 style="font-size:16px;font-weight:600;margin-bottom:16px;">Edit labels</h3>
            
            <!-- Create new label line -->
            <div style="display:flex; align-items:center; gap:8px; border-bottom:1px solid var(--gray-200); padding-bottom:12px; margin-bottom:16px;">
                <button type="button" class="card-toolbar-btn" style="padding:4px; font-size:14px; opacity:0.6;"><i class="fa-solid fa-plus"></i></button>
                <input type="text" id="newLabelInput" placeholder="Create new label" style="flex:1; border:none; outline:none; font-size:14px; font-weight:500; background:transparent;">
                <button type="button" class="card-toolbar-btn" onclick="submitCreateLabel()" style="padding:4px; font-size:14px; color:var(--primary);"><i class="fa-solid fa-check"></i></button>
            </div>

            <!-- Existing Labels Scroll Container -->
            <div id="labelsListContainer" style="max-height: 240px; overflow-y: auto; display:flex; flex-direction:column; gap:12px; margin-bottom:16px;">
                @foreach($globalLabels as $lbl)
                <div class="label-row" id="label-row-{{ $lbl->id }}" style="display:flex; align-items:center; gap:8px;">
                    <button type="button" class="card-toolbar-btn delete-btn" onclick="submitDeleteLabel({{ $lbl->id }})" style="padding:4px; font-size:14px; opacity:0.6;"><i class="fa-solid fa-trash-can"></i></button>
                    <input type="text" class="label-name-input" id="label-input-{{ $lbl->id }}" value="{{ $lbl->name }}" style="flex:1; border:none; outline:none; font-size:14px; background:transparent;" onfocus="showSaveLabelIcon({{ $lbl->id }})">
                    <button type="button" class="card-toolbar-btn save-btn" id="label-save-{{ $lbl->id }}" onclick="submitUpdateLabel({{ $lbl->id }})" style="padding:4px; font-size:14px; color:var(--primary); display:none;"><i class="fa-solid fa-check"></i></button>
                </div>
                @endforeach
            </div>

            <div style="display:flex; justify-content:flex-end; border-top:1px solid var(--gray-200); padding-top:12px;">
                <button type="button" class="btn btn-ghost" style="padding: 6px 16px; font-size:13px;" onclick="closeEditLabelsModal()">Done</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                if (typeof window.showToast === 'function') {
                    window.showToast(@json(session('success')), 'success');
                }
            @endif
            @if(session('error'))
                if (typeof window.showToast === 'function') {
                    window.showToast(@json(session('error')), 'error');
                }
            @endif
            @if(session('info'))
                if (typeof window.showToast === 'function') {
                    window.showToast(@json(session('info')), 'info');
                }
            @endif
            @if(session('deleted'))
                if (typeof window.showToast === 'function') {
                    window.showToast('Note trashed', 'deleted');
                }
            @endif
        });
    </script>
</body>
</html>
