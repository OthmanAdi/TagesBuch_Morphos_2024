<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class DiaryService
{
    protected $storagePath;

    public function __construct()
    {
        $this->storagePath = config('diary.storage_path');
        if (!File::exists($this->storagePath)) {
            File::put($this->storagePath, json_encode([]));
        }
    }

    public function getAllEntries()
    {
        if (!File::exists($this->storagePath)) {
            return [];
        }
        $content = File::get($this->storagePath);
        return json_decode($content, true) ?? [];
    }

    public function getEntry($id)
    {
        $entries = $this->getAllEntries();
        return $entries[$id] ?? null;
    }

    public function createEntry($data)
    {
        $entries = $this->getAllEntries();
        $newId = count($entries);
        $entries[$newId] = [
            'id' => $newId,
            'date' => $data['date'],
            'title' => $data['title'],
            'content' => $data['content'],
            'mood' => $data['mood'],
        ];
        $success = $this->saveEntries($entries);

        // Add this line for debugging
        Log::info('Entry saved to file', ['success' => $success, 'path' => $this->storagePath]);

        return $newId;
    }

    public function updateEntry($id, $data)
    {
        $entries = $this->getAllEntries();
        if (!isset($entries[$id])) {
            return false;
        }
        $entries[$id] = array_merge($entries[$id], $data);
        return $this->saveEntries($entries);
    }

    public function deleteEntry($id)
    {
        $entries = $this->getAllEntries();
        if (!isset($entries[$id])) {
            return false;
        }
        unset($entries[$id]);
        return $this->saveEntries($entries);
    }

    protected function saveEntries($entries)
    {
        $success = File::put($this->storagePath, json_encode($entries, JSON_PRETTY_PRINT));
        Log::info('Saving entries', ['path' => $this->storagePath, 'success' => $success]);
        return $success;
    }
}
