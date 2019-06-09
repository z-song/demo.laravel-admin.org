<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Settings;
use App\Admin\Forms\Steps;
use App\Http\Controllers\Controller;
use App\Models\User;
use Encore\Admin\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\MultipleSteps;
use Encore\Admin\Widgets;

class FormController extends Controller
{
    public function form1(Content $content)
    {
        $this->dumpRequest($content);

        $content->title('Form 1');

        $form = new Widgets\Form();

        $form->method('get');

        $form->text('text');
        $form->email('email');
        $form->mobile('mobile', '电话');
        $form->url('url');
        $form->ip('ip');
        $form->color('color', '颜色');
        $form->number('number', '数字');
        $form->switch('switch', '开关');
        $form->textarea('text');
        $form->currency('currency');
        $form->rate('rate');

        $form->divider();

        $form->radio('radio')->options(['PHP', 'Java', 'Javascript'])->stacked();
        $form->checkbox('checkbox')->options(['PHP', 'Java', 'Javascript', 'C#', 'Python', 'Golang'])->canCheckAll();

        $content->body(new Widgets\Box('Form 1', $form));

        return $content;
    }

    public function form2(Content $content)
    {
        $this->dumpRequest($content);

        $content->title('Form 2');

        $form = new Widgets\Form();

        $form->method('get');

        $options = [
            1 => 'Sansa',
            2 => 'Brandon',
            3 => 'Daenerys',
            4 => 'Jon'
        ];
        $form->select('name')->options($options);
        $form->multipleSelect('name1')->options($options);
        $form->listbox('options')->options(User::all()->pluck('name', 'id')->toArray());
        $form->tags('tags')->options($options);

        $form->divider();

        $form->file('file');
        $form->image('image');
        $form->slider('slider');
        $form->map('latitude', 'longitude', 'Position');

        $content->body(new Widgets\Box('Form-2', $form));

        return $content;
    }

    public function form3(Content $content)
    {
        $this->dumpRequest($content);

        $content->title('Form 3');

        $form = new Widgets\Form();

        $form->method('get');

        $form->timezone('timezone');
        $form->date('date');
        $form->time('time');
        $form->datetime('datetime');
        $form->divider();
        $form->dateRange('date_start', 'date_end', 'Date range');
        $form->timeRange('time_start', 'time_end', 'Time range');
        $form->dateTimeRange('date_time_start', 'date_time_end', '时间范围');

        $content->body(new Widgets\Box('Form-3', $form));

        return $content;
    }

    public function form4(Content $content)
    {
        $this->dumpRequest($content);

        $content->title('Form 4');

        $form = new Widgets\Form();
        $form->method('get');

        $form->table('extra', 'Table', function ($form) {
            $form->text('name');
            $form->email('email');
            $form->ip('ip');
        });

        $form->list('methods')->default(['GET', 'POST', 'PUT', 'DELETE']);
        $form->keyValue('extensions')->default(Admin::$extensions);

        $content->body(new Widgets\Box('Form-3', $form));

        return $content;
    }

    public function settings(Content $content)
    {
        return $content
            ->title('Tabbed form')
            ->body(Widgets\Tab::forms([
                'basic'    => Settings\Basic::class,
                'site'     => Settings\Site::class,
                'upload'   => Settings\Upload::class,
                'database' => Settings\Database::class,
                'develop'  => Settings\Develop::class,
            ]));
    }

    public function register(Content $content)
    {
        return $content
            ->title('Multiple step form')
            ->body(MultipleSteps::make([
                'info'     => Steps\Info::class,
                'profile'  => Steps\Profile::class,
                'password' => Steps\Password::class,
            ]));
    }

    protected function dumpRequest(Content $content)
    {
        $parameters = request()->except(['_pjax', '_token']);

        if (!empty($parameters)) {

            ob_start();

            dump($parameters);

            $contents = ob_get_contents();

            ob_end_clean();

            $content->row(new Widgets\Box('Form parameters', $contents));
        }
    }
}