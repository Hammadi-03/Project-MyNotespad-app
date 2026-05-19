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
        ]);

        $note = Auth::user()->notes()->create([
            'title'   => $data['title'],
            'content' => $data['content'] ?? '',
            'color'   => $data['color'] ?? 'default',
        ]);

        return redirect()->route('notes.index')
            ->with('success', 'Note "' . $note->title . '" created successfully!');
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
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'color'   => ['nullable', 'string', 'in:default,blue,green,yellow,red,purple'],
        ]);

        $note->update($data);

        return redirect()->route('notes.index')
            ->with('success', 'Note updated successfully!');
    }

    public function destroy(Note $note)
    {
        Gate::authorize('delete', $note);
        $title = $note->title;
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Note "' . $title . '" deleted.');
    }

    public function togglePin(Note $note)
    {
        Gate::authorize('update', $note);
        $note->update(['is_pinned' => !$note->is_pinned]);

        $msg = $note->fresh()->is_pinned ? 'Note pinned! 📌' : 'Note unpinned.';

        return back()->with('success', $msg);
    }
}
