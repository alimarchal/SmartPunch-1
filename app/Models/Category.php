<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    private $descendants = [];

    public function subcategories()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function children()
    {
        return $this->subcategories()->with('children');
    }

    public function hasChildren()
    {
        if ($this->children->count()) {
            return true;
        }

        return false;
    }

    public function findDescendants(User $category)
    {
        $this->descendants[] = $category->id;

        if ($category->hasChildren()) {
            foreach ($category->children as $child) {
                $this->findDescendants($child);
            }
        }
    }

    public function getDescendants(User $category)
    {
        $this->findDescendants($category);
        return $this->descendants;
    }
}
