<?php
interface SettingInterface
{
    /**
     * @return array<SettingMeta>
     */
    public function get_settings(): array;

    public function find( int $setting_id  );

    /**
     * @return array<SettingMeta>
     */
    public function get_meta(int $id): array;

    public function add_meta( SettingMeta $meta ): bool;

    public function set_id( int $setting );

    public function set_title( string $title );

    public function set_role( int $role_id );

    public function get_id();

    public function get_title();

    public function get_role();

    public function save(): string;

    public function delete(): void;
}
