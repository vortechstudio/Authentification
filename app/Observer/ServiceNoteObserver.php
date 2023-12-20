<?php

namespace App\Observer;

use App\Enum\BlogCategoryEnum;
use App\Models\Blog;
use App\Models\ServiceNote;

class ServiceNoteObserver
{
    public function created(ServiceNote $serviceNote): void
    {
        if ($serviceNote->published) {
            if($serviceNote->published_at <= now()->endOfHour()) {
                $title = "est disponible !";
            } else {
                $title = "sera disponible le {$serviceNote->published_at->format('d/m/Y')}";
            }
            Blog::create([
                "title" => "La version {$serviceNote->version}: '{$serviceNote->title}' de {$serviceNote->service->name} {$title}",
                "category" => $serviceNote->service->cercle_reference,
                "subcategory" => "notice",
                "description" => "",
                "contenue" => "Lorem",
                "published" => true,
                "published_at" => $serviceNote->published_at,
                "publish_to_social" => false,
                "publish_social_at" => null,
                "author" => $serviceNote->service->cercle_reference,
                "promote" => true
            ]);

            session()->flash('info', "Un article concernant la mise à jour à été publier");
        }
    }
}
