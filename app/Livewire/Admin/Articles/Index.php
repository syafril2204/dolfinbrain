<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public $search = '';
    public $filterType = ''; // <-- Properti baru untuk filter
    public ?Article $selectedArticle = null;
    public $isDetailModalOpen = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingFilterType()
    {
        $this->resetPage();
    }
    /**
     * Menampilkan detail artikel dalam modal.
     */
    public function showDetail(Article $article)
    {
        $this->selectedArticle = $article;
        $this->isDetailModalOpen = true;
    }

    /**
     * Menutup modal detail.
     */
    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->selectedArticle = null;
    }

    public function delete(Article $article)
    {
        if ($article->image && Storage::disk('public')->exists($article->image)) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();
        session()->flash('message', 'Artikel berhasil dihapus.');
    }
    public function render()
    {
        $articles = Article::with('user')
            ->where('title', 'like', '%' . $this->search . '%')
            ->when($this->filterType, function ($query) { // <-- Logika filter
                $query->where('type', $this->filterType);
            })
            ->latest()
            ->paginate(9);

        return view('livewire.admin.articles.index', [
            'articles' => $articles,
        ])->layout('components.layouts.app');
    }
}
