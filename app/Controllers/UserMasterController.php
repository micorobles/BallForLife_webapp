<?php

namespace App\Controllers;

use App\Models\User;
use App\Libraries\TokenHelper;

class UserMasterController extends BaseController
{

    protected $users;
    protected $session;
    protected $tokenHelper;

    public function __construct()
    {
        $this->users = model(User::class);  // Inject the User model into the controller
        $this->session = \Config\Services::session();
        $this->tokenHelper = new TokenHelper();
    }

    public function index(): string
    {
        helper('breadcrumb');
        $data['title'] = "User Master";
        // $data['message'] = "HI!";
        return view('Masters/usersMaster', $data);
    }

    public function getUserList()
    {
        // Get parameters from the request
        $draw = intval($this->request->getPost('draw'));
        $start = intval($this->request->getPost('start'));
        $length = intval($this->request->getPost('length'));
        $order = $this->request->getPost('order') ?? []; // Use empty array if not set
        $columns = ['id','email', 'firstname', 'lastname', 'position', 'status', 'updated_at'];
        
        // Determine sorting
        $sortColumnIndex = $order[0]['column'] ?? 5; // Default to first column
        $sortDirection = $order[0]['dir'] ?? 'desc';

        // Validate the sort column index
        $sortColumn = $columns[$sortColumnIndex];

        // Initialize query builder
        $builder = $this->users->where('is_deleted', false)
            ->orderBy($sortColumn, $sortDirection);

        // Apply column-specific search
        foreach ($columns as $index => $columnName) {
            $columnSearchValue = $this->request->getPost("columns[$index][search][value]");
            if (!empty($columnSearchValue)) {
                $builder->like($columnName, $columnSearchValue);
            }
        }

        // Get the general search value
        $searchValue = $this->request->getPost('search')['value'] ?? '';

        // Apply global search if there is a value
        if ($searchValue) {
            $builder->groupStart();
            foreach ($columns as $column) {
                $builder->orLike($column, $searchValue);
            }
            $builder->groupEnd();
        }

        // Select from db with sorting and pagination
        $userList = $builder->findAll($length, $start);

        // Get total count of users for recordsTotal
        $totalCount = $this->users->countAll();
        $filteredCount = $builder->countAllResults(false); // Count with current filters

        // error_log('User list: ' . print_r($userList, true));
        // Prepare the data response
        $data = array_map(function ($user) {
            return [
                'id' => $user['ID'],
                'email' => $user['email'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'position' => $user['position'],
                'status' => $user['status'],
                'updated_at' => $user['updated_at']
            ];
        }, $userList);

        return $this->response->setJSON([
            "draw" => $draw,
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $filteredCount, // Updated to count after filtering
            "data" => $data
        ]);
    }
    public function modifyUserStatusOrPassword($userID)
    {

        $userChanges['status'] = $this->request->getPost('modal-status');
        $userChanges['role'] = $this->request->getPost('modal-role');
        $newPassword = $this->request->getPost('modal-password');

        if (!empty($newPassword)) {
            $userChanges['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $modifyUser = $this->users->update($userID, $userChanges);

        if (!$modifyUser) {
            return $this->jsonResponse(false, 'Error modifying user', $userChanges);
        }

        return $this->jsonResponse(true, 'User modified', $modifyUser);
    }
    public function deleteUser($userID)
    {

        $deleteUser = $this->users->update($userID, ['is_deleted' => true]);

        if (!$deleteUser) {
            return $this->jsonResponse(false, 'Error deleting user', $deleteUser);
        }

        return $this->jsonResponse(true, 'User deleted', '');
    }

    public function acceptUser($userID)
    {

        $acceptUser = $this->users->update($userID, ['status' => 'Active']);

        if (!$acceptUser) {
            return $this->jsonResponse(false, 'Error accepting user', $acceptUser);
        }

        return $this->jsonResponse(true, 'User accepted!', '');
    }
}
