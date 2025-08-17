<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public ?Article $article = null;
    public $isEditMode = false;

    public $title = '';
    public $content = '';
    public $image;
    public $is_published = false;
    public $existingImageUrl = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image',
        'is_published' => 'required|boolean',
    ];

    public function mount($article = null)
    {
        if ($article) {
            $this->isEditMode = true;
            $this->article = $article;
            $this->title = $article->title;
            $this->content = $article->content;
            $this->is_published = $article->is_published;
            $this->existingImageUrl = $article->image;
        }
    }

    public function store()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'title' => $this->title,
            'content' => $this->content,
            'is_published' => $this->is_published,
            'published_at' => $this->is_published ? now() : null,
        ];

        if ($this->image) {
            if ($this->isEditMode && $this->article->image) {
                Storage::disk('public')->delete($this->article->image);
            }
            $data['image'] = $this->image->store('articles', 'public');
        }

        if ($this->isEditMode) {
            $this->article->update($data);
        } else {
            Article::create($data);
        }

        session()->flash('message', 'Artikel berhasil disimpan.');
        return $this->redirectRoute('admin.articles.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.articles.form')
            ->layout('components.layouts.app');
    }
}
