<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\UserInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Traits\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use AdminMethods;

    private $page = "user.";
    private $redirectTo = "admin.user.index";

    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->view($this->page.'index');
    }

    public function allUsers(Request $request)
    {
        return $this->userRepository->allUsers($request);
    }

    public function create()
    {
        return $this->view($this->page.'create');
    }

    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->userRepository->save($request);
            DB::commit();
            return $this->successMsgAndRedirect('User created successfully', $this->redirectTo);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = $this->userRepository->findOrFail($id);
        return $this->view($this->page.'edit', [
            'user' => $user
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = $this->userRepository->update($request, $id);
            $msg = "User updated successfully";
            DB::commit();
            return $this->successMsgAndRedirect($msg, $this->redirectTo);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $user = $this->userRepository->getById($id);
            $user->delete();
            DB::commit();
            return $this->successMsgAndRedirect("User deleted", $this->redirectTo);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }
}
