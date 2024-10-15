<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class DiaryService
{
    protected $storagePath;

    public function __construct()
    {
        $this->storagePath = config('diary.storage_path');
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

        $this->saveEntries($entries);

        return $newId;
    }

    public function updateEntry($id, $data)
    {
        $entries = $this->getAllEntries();
        if (!isset($entries[$id])) {
            return false;
        }

        $entries[$id] = array_merge($entries[$id], $data);
        $this->saveEntries($entries);

        return true;
    }

    public function deleteEntry($id)
    {
        $entries = $this->getAllEntries();
        if (!isset($entries[$id])) {
            return false;
        }

        unset($entries[$id]);
        $this->saveEntries($entries);

        return true;
    }

    protected function saveEntries($entries)
    {
        File::put($this->storagePath, json_encode($entries, JSON_PRETTY_PRINT));
    }
}