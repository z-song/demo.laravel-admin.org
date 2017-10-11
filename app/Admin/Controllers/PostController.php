<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ExcelExporter;
use App\Admin\Extensions\Tools\ReleasePost;
use App\Admin\Extensions\Tools\RestorePost;
use App\Admin\Extensions\Tools\ShowSelected;
use App\Admin\Extensions\Tools\Trashed;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Posts');
            $content->description('Post list..');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Post::class, function (Grid $grid) {

            if (request('trashed') == 1) {
                $grid->model()->onlyTrashed();
            }

            $grid->id('ID')->sortable();

            $grid->title()->ucfirst()->limit(30);

            $grid->tags()->pluck('name')->label();

            $states = [
                'on' => ['text' => 'YES'],
                'off' => ['text' => 'NO'],
            ];

            $grid->released()->switch($states);

            $grid->rate()->display(function ($rate) {
                $html = "<i class='fa fa-star' style='color:#ff8913'></i>";

                return join('&nbsp;', array_fill(0, min(5, $rate), $html));
            });

            $grid->created_at();

            $grid->column('float_bar')->floatBar();

            $grid->rows(function (Grid\Row $row) {
                if ($row->id % 2) {
                    $row->setAttributes(['style' => 'color:red;']);
                }
            });

            $grid->filter(function (Grid\Filter $filter) {

                $filter->equal('title');

                $filter->equal('created_at')->datetime();

                $filter->between('updated_at')->datetime();

                $filter->between('rate');

                $filter->where(function ($query) {

                    $input = $this->input;

                    $query->whereHas('tags', function ($query) use ($input) {
                        $query->where('name', $input);
                    });

                }, 'Has tag', 'tag');
            });

            $grid->tools(function ($tools) {

                $tools->append(new Trashed());

                $tools->batch(function (Grid\Tools\BatchActions $batch) {

                    $batch->add('Restore', new RestorePost());
                    $batch->add('Release', new ReleasePost(1));
                    $batch->add('Unrelease', new ReleasePost(0));
                    $batch->add('Show selected', new ShowSelected());
                });

            });

            $grid->exporter(new ExcelExporter());
        });
    }

    protected function _form()
    {
        return Admin::form(Post::class, function (Form $form) {

            $form->row(function ($row) {
                $row->width(2)->display('id', 'ID');
            });

            $form->row(function ($row) {
                $row->width(4)->text('title', '文章标题')->rules('min:3|max:5')->help('标题标题标题标题标题标题标题');
                $row->width(4)->select('author_id', '选择作者')->options(function ($id) {
                    $user = User::find($id);

                    if ($user) {
                        return [$user->id => $user->name];
                    }
                })->ajax('/demo/api/users');
                $row->width(2)->number('rate', '评分');
                $row->width(2)->switch('released', '发布?');
            });

            $form->row(function ($row) {
                $row->width(5)->listbox('tags', '选择标签')->options(Tag::all()->pluck('name', 'id'))->settings(['selectorMinimalHeight' => 300]);
                $row->width(7)->textarea('content', '文章内容')->rows(19)->help('标题标题标题标题标题标题标题');
            });

            $form->row(function ($row) {

                $row->width(6)->datetimeRange('created_at', 'updated_at', '创建时间');
//                $row->width(3)->display('created_at', '创建时间');
//                $row->width(3)->display('updated_at', '更新时间');
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
        return Admin::form(Post::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title')->default('hello');

            $form->select('author_id')->options(function ($id) {
                $user = User::find($id);

                if ($user) {
                    return [$user->id => $user->name];
                }
            })->ajax('/demo/api/users');

            $form->editor('content');

            $form->number('rate');
            $form->switch('released');

            $form->listbox('tags')->options(Tag::all()->pluck('name', 'id'))->settings(['selectorMinimalHeight' => 300]);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function users(Request $request)
    {
        $q = $request->get('q');

        return User::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }

    public function release(Request $request)
    {
        foreach (Post::find($request->get('ids')) as $post) {
            $post->released = $request->get('action');
            $post->save();
        }
    }

    public function restore(Request $request)
    {
        return Post::onlyTrashed()->find($request->get('ids'))->each->restore();
    }
}
