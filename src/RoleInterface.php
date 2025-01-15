<?php
interface RoleInterface
{

    public function get_roles(): array;

    public function find( int $role_id  ): self|null;

}
