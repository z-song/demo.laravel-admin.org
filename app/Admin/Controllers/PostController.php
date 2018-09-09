<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\ReleasePost;
use App\Admin\Extensions\Tools\RestorePost;
use App\Admin\Extensions\Tools\ShowSelected;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Tag;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class PostController extends Controller
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
            ->header('Posts')
            ->description('Post list..')
            ->body($this->grid());
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('Post')
            ->description('Post详情')
            ->body(Admin::show(Post::findOrFail($id), function (Show $show) {

                $show->panel()
                    ->style('danger')
                    ->title('post基本信息')
                    ->tools(function ($tools) {
    //                        $tools->disableEdit();
                    });;

                $show->title()->foo();
                $show->content()->json();
                $show->rate();
                $show->created_at();
                $show->updated_at();
                $show->release_at();

                $show->divider();

                $show->tags('标签')->as(function ($tags) {
                    return $tags->pluck('name');
                })->badge();

                $show->author('作者信息', function ($author) {

                    $author->setResource('/demo/users');

                    $author->id();
                    $author->name();
                    $author->email();
                    $author->avatar();
                    $author->profile()->age();
                    $author->profile()->gender('性别')->using(['m' => '女', 'f' => '男'], '未知');

                    $author->panel()->tools(function ($tools) {
                        $tools->disableDelete();
                    });
                });

                $show->comments('评论', function ($line) {

                    $line->resource('/demo/post-comments');

                    $line->id();
                    $line->content()->limit(10);
                    $line->created_at();
                    $line->updated_at();

                    $line->filter(function ($filter) {
                        $filter->like('content');
                    });
                });
        }));
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
            ->header('header')
            ->description('description')
            ->row($this->form()->edit($id))
            ->row(Admin::grid(PostComment::class, function (Grid $grid) use ($id) {

                $grid->setName('comments')
                    ->setTitle('Comments')
                    ->setRelation(Post::find($id)->comments())
                    ->resource('/demo/post-comments');

                $grid->id();
                $grid->content();
                $grid->created_at();
                $grid->updated_at();

            }));
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('header')
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
        $grid = new Grid(new Post());

//        $grid->expandFilter();

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

            if ($rate < 1) {
                return '';
            }

            return join('&nbsp;', array_fill(0, min(5, $rate), $html));
        });

        $grid->column('float_bar')->floatBar();

        $grid->column('Comments')->display(function () {
            return $this->comments()->take(5)->get(['id', 'content', 'created_at'])->toArray();
        })->table();

        $grid->created_at();

        $grid->rows(function (Grid\Row $row) {
            if ($row->id % 2) {
//                    $row->setAttributes(['style' => 'color:red;']);
            }
        });

        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('title');

            $filter->equal('created_at')->datetime();

            $filter->between('updated_at')->datetime();

            $filter->between('rate');

            $filter->where(function ($query) {

                $input = $this->input;

                $query->whereHas('tags', function ($query) use ($input) {
                    $query->where('name', $input);
                });

            }, 'Has tag', 'tag');

            $filter->scope('trashed')->onlyTrashed();
            $filter->scope('hot')->where('rate', '>', 3);
            $filter->scope('released')->where('released', 1);
            $filter->scope('new', 'Updated today')->whereDate('updated_at', date('Y-m-d'));
        });

        $grid->tools(function ($tools) {

            $tools->batch(function (Grid\Tools\BatchActions $batch) {

                $batch->add('Restore', new RestorePost());
                $batch->add('Release', new ReleasePost(1));
                $batch->add('Unrelease', new ReleasePost(0));
                $batch->add('Show selected', new ShowSelected());
            });

        });

//            $grid->footer(function (Grid\Tools\Footer $footer) {
//
//                $totalRate = $footer->column('rate')->sum();
//
//                $footer->td()->colspan(4);
//
//                $footer->td("总评分 : $totalRate");
//            });

//            $grid->exporter(new CustomExporter());
        return $grid;
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
        $form = new Form(new Post);

        $form->display('id', 'ID');

        $form->text('title')->default('hello');

        $form->select('author_id')->options(function ($id) {
            $user = User::find($id);

            if ($user) {
                return [$user->id => $user->name];
            }
        })->ajax('/demo/api/users');

        // @see https://github.com/laravel-admin-extensions/summernote
        $form->summernote('content');

        $form->number('rate');
        $form->switch('released');

        $form->listbox('tags')->options(Tag::all()->pluck('name', 'id'))->settings(['selectorMinimalHeight' => 300]);

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        $form->tools(function (Form\Tools $tools) {

//                $tools->disableList();
//                $tools->disableDelete();
//                $tools->disableView();

//                $tools->append('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
        });

        return $form;
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
