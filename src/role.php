<?php
class Role {
    private $roles = [
        'admin' => [
            'name' => 'Admin',
            'permissions' => ['create', 'read', 'update', 'delete']
        ],
        'readonly' => [
            'name' => 'Read-only',
            'permissions' => ['read']
        ],
        'data_entry' => [
            'name' => 'Data Entry',
            'permissions' => ['create', 'read', 'update']
        ]
    ];

    public function getRoles() {
        return $this->roles;
    }

    public function getRole($roleKey) {
        return isset($this->roles[$roleKey]) ? $this->roles[$roleKey] : null;
    }

    public function assignRole($userId, $roleKey) {
        // Logic to assign a role to a user in the database
    }

    public function removeRole($userId, $roleKey) {
        // Logic to remove a role from a user in the database
    }
}
?>