<?php
class SettingMeta
{
    public function __construct(
        public int $setting_id,
        public ?string $setting_key = null,
        public ?string $value = null,
    ) {
    }
}
