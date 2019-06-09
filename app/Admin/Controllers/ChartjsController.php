<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Callout;

class ChartjsController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title($title = 'Chartjs')
            ->row($this->info('https://github.com/laravel-admin-extensions/chartjs', $title))
            ->row(function (Row $row) {

                $bar = view('admin.chartjs.bar');
                $row->column(1/3, new Box('Bar chart', $bar));

                $scatter = view('admin.chartjs.scatter');
                $row->column(1/3, new Box('Scatter chart', $scatter));

                $bar = view('admin.chartjs.line');
                $row->column(1/3, new Box('Line chart', $bar));

            })->row(function (Row $row) {

                $bar = view('admin.chartjs.doughnut');
                $row->column(1/3, new Box('Doughnut chart', $bar));

                $scatter = view('admin.chartjs.combo-bar-line');
                $row->column(1/3, new Box('Chart.js Combo Bar Line Chart', $scatter));

                $bar = view('admin.chartjs.line-stacked');
                $row->column(1/3, new Box('Chart.js Line Chart - Stacked Area', $bar));

            });
    }

    protected function info($url, $title)
    {
        $content = "<a href=\"{$url}\" target='_blank'>{$url}</a>";

        return new Callout($content, $title, 'info');
    }
}