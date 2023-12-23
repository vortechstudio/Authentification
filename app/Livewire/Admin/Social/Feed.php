<?php

namespace App\Livewire\Admin\Social;

use App\Models\Social\Post;
use App\Models\Social\PostComment;
use App\Notifications\Social\PostRejectNotification;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Feed extends Component
{
    use WithPagination;
    public string $search = '';
    public int $perPage = 5;
    public string $orderField = 'title';
    public string $orderDirection = 'ASC';
    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'title'],
        'orderDirection' => ['except' => 'ASC'],
    ];
    public string $reason_reject_post = '';
    public string $reason_reject_comment = '';
    #[Title("Gestion des postes sociales")]
    public function render()
    {
        return view('livewire.admin.social.feed', [
            "feeds" => \App\Models\Social\Post::where('title', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage)
        ])
            ->layout('components.layouts.admin');
    }

    public function setOrderField(string $name)
    {
        if($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : "ASC";
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    private function resetField()
    {

    }

    public function rejectPost(int $post_id)
    {
        $post = Post::find($post_id);
        $post->update([
            'is_reject' => true,
            'is_reject_reason' => $this->reason_reject_post,
            'is_reject_at' => now()
        ]);

        $post->user->notify(new PostRejectNotification($post));

        session()->flash('success', "Ce poste à été rejeter par l'administrateur");
    }

    public function acceptPost(int $post_id)
    {
        $post = Post::find($post_id);
        $post->update([
            'is_reject' => false,
            'is_reject_reason' => null,
            'is_reject_at' => null
        ]);

        session()->flash('success', "Ce poste à été accepter par l'administrateur");
    }

    public function blockResponse(int $comment_id)
    {
        $comment = PostComment::find($comment_id);
        $comment->update([
            "is_reject" => true,
            'is_reject_reason' => $this->reason_reject_comment,
            'is_reject_at' => now()

        ]);

        session()->flash("success", "Ce message à été bloqué avec succès");
    }

    public function unblockResponse(int $comment_id)
    {
        $comment = PostComment::find($comment_id);
        $comment->update([
            "is_reject" => false,
            'is_reject_reason' => null,
            'is_reject_at' => null
        ]);

        session()->flash("success", "Ce message à été bloqué avec succès");
    }
}
