<?php

namespace App\Controllers;

use App\Models\User;

class UserMasterController extends BaseController
{
    public function index(): string
    {
        helper('breadcrumb');
        $data['title'] = "User Master";
        // $data['message'] = "HI!";
        return view('Masters/usersMaster', $data);
    }

    public function getUserList()
    {
        $users = new User();

        // Get parameters from the request
        $draw = intval($this->request->getPost('draw'));
        $start = intval($this->request->getPost('start'));
        $length = intval($this->request->getPost('length'));
        $order = $this->request->getPost('order') ?? []; // Use empty array if not set
        $columns = ['email', 'firstname', 'lastname', 'position', 'status','updated_at'];

        // Determine sorting
        $sortColumnIndex = $order[0]['column'] ?? 0; // Default to first column
        $sortDirection = $order[0]['dir'] ?? 'asc';

        // Validate the sort column index
        $sortColumn = $columns[$sortColumnIndex]; 

        // Initialize query builder
        $builder = $users->orderBy($sortColumn, $sortDirection);

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
        $totalCount = $users->countAll();
        $filteredCount = $builder->countAllResults(false); // Count with current filters

        error_log('User list: ' . print_r($userList, true));
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
}
