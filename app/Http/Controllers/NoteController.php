<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->notes()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $notes      = $query->get();
        $pinned     = $notes->where('is_pinned', true);
        $unpinned   = $notes->where('is_pinned', false);
        $totalNotes = Auth::user()->notes()->count();

        return view('notes.index', compact('notes', 'pinned', 'unpinned', 'totalNotes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'color'   => ['nullable', 'string', 'in:default,blue,green,yellow,red,purple'],
            'image'   => ['nullable', 'image', 'max:4096'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('notes', 'public');
        }

        $note = Auth::user()->notes()->create([
            'title'   => $data['title'],
            'content' => $data['content'] ?? '',
            'color'   => $data['color'] ?? 'default',
            'image'   => $imagePath,
        ]);

        return redirect()->route('notes.index')
            ->with('success', 'Note created.');
    }

    public function edit(Note $note)
    {
        Gate::authorize('update', $note);
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        Gate::authorize('update', $note);

        $data = $request->validate([
            'title'   => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'color'   => ['nullable', 'string', 'in:default,blue,green,yellow,red,purple'],
            'image'   => ['nullable', 'image', 'max:4096'],
        ]);

        $updateData = [
            'title' => $data['title'] ?? '',
            'content' => $data['content'] ?? '',
            'color' => $data['color'] ?? $note->color,
        ];

        if ($request->hasFile('image')) {
            if ($note->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($note->image);
            }
            $updateData['image'] = $request->file('image')->store('notes', 'public');
        } elseif ($request->input('remove_image') == '1') {
            if ($note->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($note->image);
            }
            $updateData['image'] = null;
        }

        $note->update($updateData);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'note' => $note
            ]);
        }

        return redirect()->route('notes.index')
            ->with('success', 'Note updated successfully!');
    }

    public function destroy(Note $note)
    {
        Gate::authorize('delete', $note);
        $note->delete();

        return redirect()->route('notes.index')
            ->with('deleted', true);
    }

    public function togglePin(Note $note)
    {
        Gate::authorize('update', $note);
        $note->update(['is_pinned' => !$note->is_pinned]);

        $msg = $note->fresh()->is_pinned ? 'Note pinned!' : 'Note unpinned.';

        return back()->with('success', $msg);
    }

    public function updateColor(Request $request, Note $note)
    {
        Gate::authorize('update', $note);

        $data = $request->validate([
            'color' => ['required', 'string', 'in:default,blue,green,yellow,red,purple'],
        ]);

        $note->update(['color' => $data['color']]);

        return response()->json(['success' => true]);
    }

    public function uploadImage(Request $request, Note $note)
    {
        Gate::authorize('update', $note);

        $request->validate([
            'image' => ['required', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($note->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($note->image);
            }
            
            $path = $request->file('image')->store('notes', 'public');
            $note->update(['image' => $path]);

            return response()->json([
                'success' => true,
                'image_url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    public function trash()
    {
        $notes = Auth::user()->notes()->onlyTrashed()->latest()->get();
        return view('notes.trash', compact('notes'));
    }

    public function restore($id)
    {
        $note = Auth::user()->notes()->onlyTrashed()->findOrFail($id);
        $note->restore();

        return redirect()->route('notes.trash')
            ->with('success', 'Note restored.');
    }

    public function forceDelete($id)
    {
        $note = Auth::user()->notes()->onlyTrashed()->findOrFail($id);
        if ($note->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($note->image);
        }
        $note->forceDelete();

        return redirect()->route('notes.trash')
            ->with('success', 'Note deleted forever.');
    }

    public function emptyTrash()
    {
        $notes = Auth::user()->notes()->onlyTrashed()->get();
        foreach ($notes as $note) {
            if ($note->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($note->image);
            }
            $note->forceDelete();
        }

        return redirect()->route('notes.trash')
            ->with('success', 'Trash emptied.');
    }

    public function duplicate(Note $note)
    {
        Gate::authorize('update', $note);

        $newNote = $note->replicate();
        if ($note->title) {
            $newNote->title = $note->title . ' (Copy)';
        } else {
            $newNote->title = 'Copy';
        }
        
        if ($note->image) {
            $extension = pathinfo($note->image, PATHINFO_EXTENSION);
            $newPath = 'notes/' . uniqid() . '.' . $extension;
            \Illuminate\Support\Facades\Storage::disk('public')->copy($note->image, $newPath);
            $newNote->image = $newPath;
        }
        $newNote->save();

        return redirect()->route('notes.index')
            ->with('success', 'Note duplicated.');
    }
}
