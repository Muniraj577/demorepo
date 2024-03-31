<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Music;
use App\Models\User;
use App\Traits\AdminMethods;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use AdminMethods;

    public function index()
    {
        $dashboard_datas = $this->__datas()['dashboard_row'];
        return $this->view('dashboard',[
            "dashboard_datas" => $dashboard_datas,
        ]);
    }

    private function __datas()
    {
        return [
            "dashboard_row" => [
                [
                    "title" => "Total Users",
                    "totalCount" => User::count(),
                    "link" => route("admin.user.index"),
                    "icon" => "fas fa-users",
                    "color" => "bg-info",
                ],
                [
                    "title" => "Total Artists",
                    "totalCount" => Artist::count(),
                    "link" => route("admin.artist.index"),
                    "icon" => "fas fa-users",
                    "color" => "bg-warning"
                ],
                [
                    "title" => "Total Musics",
                    "totalCount" => Music::count(),
                    "link" => null,
                    "icon" => "fas fa-music",
                    "color" => "bg-danger"
                ],
            ]
        ];
    }

}
