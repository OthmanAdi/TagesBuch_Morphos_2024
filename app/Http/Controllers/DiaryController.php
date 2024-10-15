<?php

namespace App\Http\Controllers;

use App\Services\DiaryService;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    protected $diaryService;

    public function __construct(DiaryService $diaryService)
    {
        $this->diaryService = $diaryService;
    }

    public function index()
    {
        $entries = $this->diaryService->getAllEntries();
        return view('diary.index', compact('entries'));
    }

    public function create()
    {
        return view('diary.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'title' => 'required|max:255',
            'content' => 'required',
            'mood' => 'required|in:happy,neutral,sad',
        ]);

        $id = $this->diaryService->createEntry($validatedData);

        return redirect()->route('diary.show', $id)->with('success', 'Tagebucheintrag erfolgreich erstellt!');
    }

    public function show($id)
    {
        $entry = $this->diaryService->getEntry($id);
        if (!$entry) {
            abort(404);
        }

        return view('diary.show', compact('entry'));
    }

    public function edit($id)
    {
        $entry = $this->diaryService->getEntry($id);
        if (!$entry) {
            abort(404);
        }

        return view('diary.edit', compact('entry'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'title' => 'required|max:255',
            'content' => 'required',
            'mood' => 'required|in:happy,neutral,sad',
        ]);

        $success = $this->diaryService->updateEntry($id, $validatedData);

        if (!$success) {
            abort(404);
        }

        return redirect()->route('diary.show', $id)->with('success', 'Tagebucheintrag erfolgreich aktualisiert!');
    }

    public function destroy($id)
    {
        $success = $this->diaryService->deleteEntry($id);

        if (!$success) {
            abort(404);
        }

        return redirect()->route('diary.index')->with('success', 'Tagebucheintrag erfolgreich gelöscht!');
    }
}