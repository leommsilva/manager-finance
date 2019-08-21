<?php namespace App\Repositories;

use App\Repositories\Repository;
use App\Persistence\Eloquent\Category;

class Categories extends Repository
{

    public function getAll()
    {
        return Category::where('user_id', $this->user->id)->orderBy('title', 'ASC')->get();
    }

    public function save($params)
    {
        $category = new Category();
        $category->title = $params['title'];
        $category->type = $params['type'];
        $category->user_id = $this->user->id;
        $category->save();
        return $category;
    }

    public function getToList()
    {
        $data = [];
        foreach ($this->getAll() as $category) {
            $type = ($category->type === 'c')
                ? '<span class="text-green">Credit</span>'
                : '<span class="text-red">Debit</span>';
            $data[] = [
                'id' => $category->id,
                'Title' => $category->title,
                'Type' => $type
            ];
        }
        return $data;
    }

    public function delete($id)
    {
        $category = Category::find($id);
        return $category->delete();
    }
}
