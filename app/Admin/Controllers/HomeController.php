<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            /*$content->header('Dashboard');
            $content->description('Description...');*/

            $content->row(view('admin.title'));

            $content->row(function (Row $row) {

                $row->column(2, function (Column $column) {
                    $column->append('');
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });

                $row->column(2, function (Column $column) {
                    $column->append('');
                });
            });
        });
    }
}
