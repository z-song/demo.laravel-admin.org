<?php

namespace App\Admin\Controllers\China;

use App\Http\Controllers\Controller;
use App\Models\ChinaArea;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChinaController extends Controller
{
    public function cascading(Request $request)
    {
        return Admin::content(function (Content $content) use ($request) {

            $content->header('Cascading select');

            $form = new Form($request->all());
            $form->method('GET');
            $form->action('/demo/china/cascading-select');

            $form->select('province')->options(

                ChinaArea::province()->pluck('name', 'id')

            )->load('city', '/demo/api/china/city');

            $form->select('city')->options(function ($id) {

                return ChinaArea::options($id);

            })->load('district', '/demo/api/china/district');

            $form->select('district')->options(function ($id) {

                return ChinaArea::options($id);

            });
            $content->row(new Box('Form', $form));

            if ($request->has('province')) {
                $content->row(new Box('Query', new Table(['key', 'value'], $request->only(['province', 'city', 'district']))));
            }
        });
    }

    public function city(Request $request)
    {
        $provinceId = $request->get('q');

        return ChinaArea::city()->where('parent_id', $provinceId)->get(['id', DB::raw('name as text')]);
    }

    public function district(Request $request)
    {
        $cityId = $request->get('q');

        return ChinaArea::district()->where('parent_id', $cityId)->get(['id', DB::raw('name as text')]);
    }
}
