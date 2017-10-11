<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\UserGender;
use App\Http\Controllers\Controller;
use App\Models\ChinaArea;
use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    use ModelForm;

    protected function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('Users');
            $content->description('list');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Users');
            $content->description('edit');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Users');
            $content->description('new');

            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->model()->gender(Request::get('gender'));

            $grid->model()->with('profile')->orderBy('id', 'DESC');

            $grid->paginate(20);

            $grid->id('ID')->sortable();

            $grid->name()->editable();

            $grid->column('expand')->expand(function () {

                $profile = array_only($this->profile, ['homepage', 'gender', 'birthday', 'address', 'last_login_at', 'last_login_ip', 'lat', 'lng']);

                return new Table([], $profile);

            }, 'Profile');
//
            $grid->column('position')->openMap(function () {

                return [$this->profile['lat'], $this->profile['lng']];

            }, 'Position');

            $grid->column('profile.homepage')->urlWrapper();

            $grid->email()->prependIcon('envelope');

            //$grid->profile()->mobile()->prependIcon('phone');

            //$grid->column('profile.age')->progressBar(['success', 'striped'], 'xs')->sortable();

            $grid->profile()->age()->sortable();

            $grid->created_at();

            $grid->updated_at();

            $grid->filter(function (Grid\Filter $filter) {

//                $filter->disableIdFilter();

                $filter->equal('address.province_id', 'Province')
                    ->select(ChinaArea::province()->pluck('name', 'id'))
                    ->load('address.city_id', '/demo/api/china/city');

                $filter->equal('address.city_id', 'City')->select()
                    ->load('address.district_id', '/demo/api/china/district');

                $filter->equal('address.district_id', 'District')->select();
            });

            $grid->tools(function ($tools) {
                $tools->append(new UserGender());
            });

            $grid->actions(function ($actions) {

                if ($actions->getKey() % 2 == 0) {
                    $actions->disableDelete();
                    $actions->append('<a href=""><i class="fa fa-eye"></i></a>');
                } else {
                    $actions->disableEdit();
                    $actions->prepend('<a href=""><i class="fa fa-paper-plane"></i></a>');
                }
            });
        });
    }

    public function form()
    {
        return User::form(function (Form $form) {

            $form->model()->makeVisible('password');

            $form->tab('Basic', function (Form $form) {

                $form->display('id');

                //$form->input('name')->rules('required');

                $form->text('name')/*->rules('required')*/;
                $form->email('email')->rules('required');
                $form->display('created_at');
                $form->display('updated_at');

            })->tab('Profile', function (Form $form) {

                $form->url('profile.homepage');
                $form->ip('profile.last_login_ip');
                $form->datetime('profile.last_login_at');
                $form->color('profile.color')->default('#c48c20');
                $form->mobile('profile.mobile')->default(13524120142);
                $form->date('profile.birthday');

//                $form->map('profile.lat', 'profile.lng', 'Position')->useTencentMap();
                $form->slider('profile.age', 'Age')->options(['max' => 50, 'min' => 20, 'step' => 1, 'postfix' => 'years old']);
                $form->datetimeRange('profile.created_at', 'profile.updated_at', 'Time line');

            })->tab('Sns info', function (Form $form) {

                $form->text('sns.qq');
                $form->text('sns.wechat')->rules('required');
                $form->text('sns.weibo');
                $form->text('sns.github');
                $form->text('sns.google');
                $form->text('sns.facebook');
                $form->text('sns.twitter');
                $form->display('sns.created_at');
                $form->display('sns.updated_at');

            })->tab('Address', function (Form $form) {

                $form->select('address.province_id')->options(
                    ChinaArea::province()->pluck('name', 'id')
                )
                    ->load('address.city_id', '/demo/api/china/city')
                    ->load('test', '/demo/api/china/city');

                $form->select('address.city_id')->options(function ($id) {
                    return ChinaArea::options($id);
                })->load('address.district_id', '/demo/api/china/district');

                $form->select('address.district_id')->options(function ($id) {
                    return ChinaArea::options($id);
                });

                $form->text('address.address');

            })->tab('Password', function (Form $form) {

                $form->password('password')->rules('confirmed');
                $form->password('password_confirmation');

            });

            $form->ignore(['password_confirmation']);
        });
    }
}

