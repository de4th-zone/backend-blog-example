<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;

class ArticleTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user', 'category', 'tags'
    ];

    public function transform(Article $article)
    {
        return [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'excerpt' => $article->excerpt,
            'image' => config('custom.img_url') . '/' . $article->image,
            'content' => $article->content,
            'pinned' => $article->pinned,
            'published' => $article->published,
            'published_at' => $article->published_at,
            'created_at' => $article->created_at,
            'updated_at' => $article->updated_at
        ];
    }

    public function includeUser(Article $article)
    {
        $user = $article->user;
        return $this->item($user, function(User $user) {
            return [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'avatar' => config('custom.img_url') . '/' . $user->avatar,
                'user_name' => $user->user_name
            ];
        });
    }

    public function includeCategory(Article $article)
    {
        $category = $article->category;
        return $this->item($category,  function(Category $category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
                'slug' => $category->slug
            ];
        });
    }

    public function includeTags(Article $article)
    {
        $tags = $article->tags;
        return $this->collection($tags,  function(Tag $tag) {
            return [
                'id' => $tag->id,
                'title' => $tag->title,
                'slug' => $tag->slug
            ];
        });
    }
}
