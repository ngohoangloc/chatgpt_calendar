<?php
interface UserInterface
{
    /**
     * @return array<self>
     */
    public function get_users(): array;

    public function find( string $user_id  ): self|null;

    public function save(): string;

    public function delete(): void;
}
