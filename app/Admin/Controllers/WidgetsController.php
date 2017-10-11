<?php

namespace App\Admin\Controllers;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Alert;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Callout;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;

class WidgetsController extends Controller
{
    public function form1()
    {
        return Admin::content(function (Content $content) {
            $content->header('Form-1');

            $this->showFormParameters($content);

            $form = new Form();

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

            $content->body(new Box('Form-1', $form));
        });
    }

    public function form2()
    {
        return Admin::content(function (Content $content) {
            $content->header('Form-2');

            $this->showFormParameters($content);

            $form = new Form();

            $form->method('get');

            $options = [
                1 => 'Sansa',
                2 => 'Brandon',
                3 => 'Daenerys',
                4 => 'Jon'
            ];
            $form->select('name')->options($options);

            $form->multipleSelect('name1')->options($options);

            $form->file('file');
            $form->image('image');
            $form->slider('slider');
            $form->map('latitude', 'longitude', 'Position');

            $content->body(new Box('Form-2', $form));
        });
    }

    public function form3()
    {
        return Admin::content(function (Content $content) {
            $content->header('Form-3');

            $this->showFormParameters($content);

            $form = new Form();
            $form->method('get');
            $form->date('date');
            $form->time('time');
            $form->datetime('datetime');
            $form->divide();
            $form->dateRange('date_start', 'date_end', 'Date range');
            $form->timeRange('time_start', 'time_end', 'Time range');
            $form->dateTimeRange('date_time_start', 'date_time_end', '时间范围');

            $content->body(new Box('Form-3', $form));
        });
    }

    public function table()
    {
        return Admin::content(function (Content $content) {
            $content->header('Table');

            // table 1
            $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
            $rows = [
                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
                [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
            ];

            $table1 = new Table($headers, $rows);

            $content->row((new Box('Table-1', $table1))->style('info')->solid());

            $headers = ['Keys', 'Values'];
            $rows = [
                'name'   => 'Joe',
                'age'    => 25,
                'gender' => 'Male',
                'birth'  => '1989-12-05',
            ];

            $table2 = new Table($headers, $rows);

            $content->body((new Box('Table-2', $table2))->style('danger')->solid());
        });
    }

    public function box()
    {
        return Admin::content(function (Content $content) {
            $content->header('Box container');

            $box1 = new Box('First box', '<pre>Lorem ipsum dolor sit amet</pre>');
            $box2 = new Box('Second box', '<p>Lorem ipsum dolor sit amet</p><p>consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>');
            $box3 = new Box('Third box');

            $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
            $rows = [
                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
                [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
            ];
            $table = new Table($headers, $rows);
            $box4 = new Box('Forth Box', $table);

            $content->row($box1->collapsable());
            $content->row($box2->style('danger'));
            $content->row($box3->removable()->style('warning'));
            $content->row($box4->solid()->style('primary'));
        });
    }

    public function infoBox()
    {
        return Admin::content(function (Content $content) {
            $content->header('Info box');
            $content->description('Description...');

            $content->row(function ($row) {
                $row->column(3, new InfoBox('New Users', 'users', 'aqua', '/demo/users', '1024'));
                $row->column(3, new InfoBox('New Orders', 'shopping-cart', 'green', '/demo/orders', '150%'));
                $row->column(3, new InfoBox('Articles', 'book', 'yellow', '/demo/articles', '2786'));
                $row->column(3, new InfoBox('Documents', 'file', 'red', '/demo/files', '698726'));
            });
        });
    }

    public function tab()
    {
        return Admin::content(function (Content $content) {
            $content->header('Tabs');
            $content->description('Description...');

            $this->showFormParameters($content);

            $tab = new Tab();

            $form = new Form();

            $form->method('get');

            $form->date('date');
            $form->time('time');
            $form->datetime('datetime');
            $form->divide();
            $form->dateRange('date_start', 'date_end', 'Date range');
            $form->timeRange('time_start', 'time_end', 'Time Range');
            $form->dateTimeRange('date_time_start', 'date_time_end', 'Datetime range');

            $tab->add('Form', $form);

            $box = new Box('Second box', '<p>Lorem ipsum dolor sit amet</p><p>consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>');
            $tab->add('Box', $box);

            $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
            $rows = [
                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
                [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
            ];

            $table = new Table($headers, $rows);
            $tab->add('Table', $table);

            $content->row($tab);
        });
    }

    public function notice()
    {
        return Admin::content(function (Content $content) {
            $content->header('Alerts and Callouts');
            $content->description('Description...');

            $content->row(function (Row $row) {

                $words = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non,
                    facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam,
                    orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus.';

                $row->column(6, function (Column $column) use ($words) {
                    $column->append(new Alert($words));
                    $column->append((new Alert($words, 'Alert!!'))->style('success')->icon('user'));
                    $column->append((new Alert($words))->style('warning')->icon('book'));
                    $column->append((new Alert($words))->style('info')->icon('info'));
                });

                $row->column(6, function (Column $column) use ($words) {
                    $column->append(new Callout($words));
                    $column->append((new Callout($words))->style('warning'));
                    $column->append((new Callout($words))->style('info'));
                    $column->append((new Callout($words, 'Warning!!'))->style('success'));
                });
            });
        });
    }

    public function editors()
    {
        return Admin::content(function (Content $content) {
            $content->header('Editors');

            $this->showFormParameters($content);

            $form1 = new Form();
            $form1->method('get');
            $form1->editor('text', 'Text');

//            $form2 = new Form();
//            $form2->method('get');
//            $form2->php('text3', 'PHP')->default(file_get_contents(public_path('index.php')));
//
//            $form3 = new Form();
//            $form3->method('get');
//            $form3->markdown('text4', 'Markdown')->default(file_get_contents(base_path('readme.md')));

            $content->body((new Box('WangEditor', $form1)));
//            $content->body((new Box('PHP Editor', $form2)));
//            $content->body((new Box('Markdown Editor', $form3)));

        });
    }

    protected function showFormParameters($content)
    {
        $parameters = request()->except(['_pjax', '_token']);

        if (!empty($parameters)) {

            ob_start();

            dump($parameters);

            $contents = ob_get_contents();

            ob_end_clean();

            $content->row(new Box('Form parameters', $contents));
        }
    }
}

