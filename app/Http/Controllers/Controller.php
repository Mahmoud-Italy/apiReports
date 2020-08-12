<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // useing resource routes
    // use RestfulControllerTrait;


    // statusBar
    public function statusBar($data)
    {
        $statusBar  = [
              'all'       => count($data),
              'active'    => count($data->where('status', true)->where('trash', false)),
              'inactive'  => count($data->where('status', false)->where('trash', false)), 
              'trash'     => count($data->where('trash', true))
            ];
        return $statusBar;
    }

    // permissions
    public function permissions($table)
    {
        $permissions  = [
              'view'    => Permission::hasPermission('view_'.$table) ?? false,
              'add'     => Permission::hasPermission('add_'.$table) ?? false,
              'edit'    => Permission::hasPermission('edit_'.$table) ?? false,
              'delete'  => Permission::hasPermission('delete_'.$table) ?? false
            ];
        return $permissions;
    }

    // paginate
    public function paginate($data)
    {
        $nextPageUrl = $data->nextPageUrl();
        $prevPageUrl = $data->previousPageUrl();
        $lastPage    = $data->lastPage();
        $currentPage = $data->currentPage();
        $perPage     = $data->perPage();
        $total       = $data->total();
        $pagination  = [
                'total'         => $total, 
                'per_page'      => $perPage, 
                'current_page'  => $currentPage, 
                'last_page'     => $lastPage, 
                'next_page_url' => $nextPageUrl, 
                'prev_page_url' => $prevPageUrl
              ];
        return $pagination;
    }

}
