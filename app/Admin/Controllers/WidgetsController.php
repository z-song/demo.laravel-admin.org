<?php

namespace App\Admin\Controllers;

use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets;

class WidgetsController extends Controller
{
    public function table(Content $content)
    {
        $content->title('Table');

        // table 1
        $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
        $rows = [
            [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
            [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
            [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
            [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
            [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
        ];

        $table1 = new Widgets\Table($headers, $rows);

        $content->row((new Widgets\Box('Table-1', $table1))->style('info')->solid());

        $headers = ['Keys', 'Values'];
        $rows = [
            'name'   => 'Joe',
            'age'    => 25,
            'gender' => 'Male',
            'birth'  => '1989-12-05',
        ];

        $table2 = new Widgets\Table($headers, $rows);

        $content->body((new Widgets\Box('Table-2', $table2))->style('danger')->solid());

        return $content;
    }

    public function box(Content $content)
    {
        $content->title('Box container');

        $box1 = new Widgets\Box('First box', '<pre>Lorem ipsum dolor sit amet</pre>');
        $box2 = new Widgets\Box('Second box', '<p>Lorem ipsum dolor sit amet</p><p>consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>');
        $box3 = new Widgets\Box('Third box');

        $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
        $rows = [
            [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
            [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
            [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
            [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
            [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
        ];
        $table = new Widgets\Table($headers, $rows);
        $box4 = new Widgets\Box('Forth Box', $table);

        $content->row($box1->collapsable());
        $content->row($box2->style('danger'));
        $content->row($box3->removable()->style('warning'));
        $content->row($box4->solid()->style('primary'));

        return $content;
    }

    public function infoBox(Content $content)
    {
        $content->title('Info box');
        $content->description('Description...');

        $content->row(function ($row) {
            $row->column(3, new Widgets\InfoBox('New Users', 'users', 'aqua', '/demo/users', '1024'));
            $row->column(3, new Widgets\InfoBox('New Orders', 'shopping-cart', 'green', '/demo/orders', '150%'));
            $row->column(3, new Widgets\InfoBox('Articles', 'book', 'yellow', '/demo/articles', '2786'));
            $row->column(3, new Widgets\InfoBox('Documents', 'file', 'red', '/demo/files', '698726'));
        });

        return $content;
    }

    public function tab(Content $content)
    {
        $content->title('Tabs');
        $content->description('Description...');

        $this->showFormParameters($content);

        $tab = new Widgets\Tab();

        $form = new Widgets\Form();

        $form->method('get');

        $form->date('date');
        $form->time('time');
        $form->datetime('datetime');
        $form->divider();
        $form->dateRange('date_start', 'date_end', 'Date range');
        $form->timeRange('time_start', 'time_end', 'Time Range');
        $form->dateTimeRange('date_time_start', 'date_time_end', 'Datetime range');

        $tab->add('Form', $form);

        $box = new Widgets\Box('Second box', '<p>Lorem ipsum dolor sit amet</p><p>consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>');
        $tab->add('Box', $box);

        $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
        $rows = [
            [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
            [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
            [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
            [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
            [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
        ];

        $table = new Widgets\Table($headers, $rows);
        $tab->add('Table', $table);

        $content->row($tab);

        return $content;
    }

    public function notice(Content $content)
    {
        $content->title('Alerts and Callouts');
        $content->description('Description...');

        $content->row(function (Row $row) {

            $words = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non,
                facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam,
                orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus.';

            $row->column(6, function (Column $column) use ($words) {
                $column->append(new Widgets\Alert($words));
                $column->append((new Widgets\Alert($words, 'Alert!!'))->style('success')->icon('user'));
                $column->append((new Widgets\Alert($words))->style('warning')->icon('book'));
                $column->append((new Widgets\Alert($words))->style('info')->icon('info'));
            });

            $row->column(6, function (Column $column) use ($words) {
                $column->append(new Widgets\Callout($words));
                $column->append((new Widgets\Callout($words))->style('warning'));
                $column->append((new Widgets\Callout($words))->style('info'));
                $column->append((new Widgets\Callout($words, 'Warning!!'))->style('success'));
            });
        });

        return $content;
    }

    public function editors(Content $content)
    {
        $content->title('Editors');

        $this->showFormParameters($content);

        $form1 = new Widgets\Form();
        $form1->method('get');
        $form1->editor('text', 'Text');

//            $form2 = new Form();
//            $form2->method('get');
//            $form2->php('text3', 'PHP')->default(file_get_contents(public_path('index.php')));
//
//            $form3 = new Form();
//            $form3->method('get');
//            $form3->markdown('text4', 'Markdown')->default(file_get_contents(base_path('readme.md')));

        $content->body((new Widgets\Box('WangEditor', $form1)));
//            $content->body((new Box('PHP Editor', $form2)));
//            $content->body((new Box('Markdown Editor', $form3)));


        return $content;
    }

    protected function showFormParameters($content)
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

