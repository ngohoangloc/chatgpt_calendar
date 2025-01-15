<?php
class Message {
    public function __construct(
        public  string $role,
        public ?string $content = null,
        public ?string $function_name = null,
        public ?string $function_arguments = null,
        public ?int $user_id = null,
    ) {
        if( in_array( $role, [
            "user",
            "assistant",
            "tool",
            "function",
        ] ) ) {
            if( $content === null ) {
                throw new \Exception( sprintf( "Content is required for message of role '%s'", $role ) );
            }
        }
    }
}
