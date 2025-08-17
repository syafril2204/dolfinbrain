<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public ?Article $selectedArticle = null;
    public $isDetailModalOpen = false;

    public function updatingSearch()
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
            ->latest()
            ->paginate(9); // Ubah ke 9 agar pas di grid 3 kolom

        return view('livewire.admin.articles.index', [
            'articles' => $articles,
        ])->layout('components.layouts.app');
    }
}
