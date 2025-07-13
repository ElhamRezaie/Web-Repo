<?php
// permissions.php

class Permissions {
    private $permissions = [
        'Admin' => [
            'create_user' => true,
            'edit_user' => true,
            'delete_user' => true,
            'view_user' => true,
            'manage_roles' => true,
        ],
        'Data Entry' => [
            'create_user' => true,
            'edit_user' => true,
            'delete_user' => false,
            'view_user' => true,
            'manage_roles' => false,
        ],
        'Read-only' => [
            'create_user' => false,
            'edit_user' => false,
            'delete_user' => false,
            'view_user' => true,
            'manage_roles' => false,
        ],
    ];

    public function hasPermission($role, $permission) {
        return isset($this->permissions[$role]) && isset($this->permissions[$role][$permission]) 
               ? $this->permissions[$role][$permission] 
               : false;
    }
}
?>