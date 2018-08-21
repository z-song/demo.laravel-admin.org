<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Tree;

class CategoryController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('All categories')
            ->body($this->tree());
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit category')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create new category')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Tree
     */
    protected function tree()
    {
        return Category::tree(function (Tree $tree) {

            $tree->branch(function ($branch) {

                $src = config('admin.upload.host') . '/' . $branch['logo'] ;

                $logo = "<img src='$src' style='max-width:30px;max-height:30px' class='img'/>";

                return "{$branch['id']} - {$branch['title']} $logo";

            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        $form->display('id', 'ID');

        $form->select('parent_id')->options(Category::selectOptions());

        $form->text('title')->rules('required');
        $form->textarea('desc')->rules('required');
        $form->image('logo');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
