<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MultipleImage;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class MultipleImageController extends Controller
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
            ->header('Multiple images upload')
            ->body($this->grid());
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
            ->header('Multiple images upload')
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
            ->header('Multiple images upload')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MultipleImage());

        $grid->id('ID')->sortable();

        $grid->title()->editable();

        $grid->pictures()->image();

        $grid->created_at();
        $grid->updated_at();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MultipleImage());

        $form->display('id', 'ID');

        $form->text('title')->rules('required');
        $form->multipleImage('pictures');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
