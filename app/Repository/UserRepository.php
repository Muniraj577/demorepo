<?php

namespace App\Repository;

use App\Contracts\UserInterface;
use App\Enum\GenderEnum;
use App\Enum\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    public function allUsers($request)
    {
        $columns = array(
            0 => 'id',
            1 => 'first_name',
            2 => 'last_name',
            3 => 'email',
            4 => 'phone',
            5 => 'dob',
            6 => 'gender',
            7 => 'address',
            8 => 'role',
            9 => 'id',
        );

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input("length");
        $start = $request->input("start");
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = User::offset($start)
                ->limit($limit)
                ->orderBy($order, 'desc')
                ->get();
        } else {
            $search = $request->input('search.value');
            $users = User::where("id", "LIKE", "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', "LIKE", "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, 'desc')
                ->get();

            $totalFiltered = User::where("id", "LIKE", "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', "LIKE", "%{$search}%")
                ->count();
        }
        $data = array();
        if (!empty($users)) {
            $i = 1;
            foreach ($users as $user) {
                $edit = route("admin.user.edit", $user->id);
                $delete = route("admin.user.delete", $user->id);
                $nestedData['id'] = $i++;
                $nestedData['first_name'] = $user->first_name;
                $nestedData['last_name'] = $user->last_name;
                $nestedData['email'] = $user->email;
                $nestedData['phone'] = $user->phone;
                $nestedData['dob'] = getFormattedDate('Y-m-d', $user->dob);
                $nestedData['gender'] = $user->gender != null ? GenderEnum::getLabel($user->gender) : '';
                $nestedData['address'] = $user->address;
                $nestedData['role'] = RoleEnum::getLabel($user->role);
                if ($user->id != getUser()->id) {
                    $nestedData['action'] = "<div style='display: inline-flex;'>
                <div>
                <a href='{$edit}' id='editUser' class='edit btn btn-sm' data-id='" . $user->id . "' name='edit'><i class='fas fa-edit' style='color: blue;'></i></a>
                <a href='javascript:void(0)' id='deleteUser' class='edit btn btn-sm' onclick='deleteData(`" . $user->id . "`, `" . $delete . "`)' data-id='" . $user->id . "' name='delete'><i class='fas fa-trash' style='color: red;'></i></a>
                </div>
                </div>";
                } else {
                    $nestedData['action'] = "<div style='display: inline-flex;'>
                <div>
                <a href='{$edit}' id='editUser' class='edit btn btn-sm' data-id='" . $user->id . "' name='edit'><i class='fas fa-edit' style='color: blue;'></i></a>
                </div>
                </div>";
                }

                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => (int)$request->input('draw'),
            "recordsTotal" => (int)$totalData,
            "recordsFiltered" => (int)$totalFiltered,
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function getAll()
    {
        return User::get();
    }

    public function save($data)
    {
        $input = $data->except('_token');
        $input['password'] = Hash::make($data->password);
        User::create($input);
    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function findOrFail($id)
    {
        return User::findOrFail($id);
    }

    public function update($data, $id)
    {
        $user = $this->findOrFail($id);
        $oldPassword = $user->password;
        $input = $data->except("_token");
        $input['password'] = $data->has("password") ? Hash::make($data->password) : $oldPassword;
        $user->update($input);
    }

    public function delete($id)
    {
        $user = User::where("id", $id)->first();
        return $user->delete();
    }

}