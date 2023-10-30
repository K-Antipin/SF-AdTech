<?php

namespace App\Kernel\Http;

use App\Kernel\Upload\UploadedFile;
use App\Kernel\Upload\UploadedFileInterface;
use App\Kernel\Validator\ValidatorInterface;

class Request implements RequestInterface
{
    private ValidatorInterface $validator;

    public function __construct(
        public readonly array $get,
        public readonly array $post,
        public readonly array $server,
        public readonly array $files,
        public readonly array $cookies,
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_SERVER, $_FILES, $_COOKIE);
    }

    public function uri(): string
    {
        $uri = strtok($this->server['REQUEST_URI'], '?');
        if (strlen($uri) > 1 && substr($uri, -1) === '/') {
            $uri = substr($uri, 0, -1);
        }
        return $uri;
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function domain(): string
    {
        return $this->server['SERVER_NAME'];
    }

    public function input(string $key, $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function file(string $key): ?UploadedFileInterface
    {
        if (!isset($this->files[$key])) {
            return null;
        }

        return new UploadedFile(
            $this->files[$key]['name'],
            $this->files[$key]['type'],
            $this->files[$key]['tmp_name'],
            $this->files[$key]['error'],
            $this->files[$key]['size'],
        );
    }

    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    public function validate(array $rules): bool
    {
        $data = [];

        foreach ($rules as $field => $rule) {
            $data[$field] = $this->input($field);
        }

        return $this->validator->validate($data, $rules);
    }

    public function errors(): array
    {
        return $this->validator->errors();
    }
}
