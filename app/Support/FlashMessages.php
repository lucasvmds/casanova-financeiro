<?php

declare(strict_types=1);

namespace App\Support;

use BadMethodCallException;
use Inertia\Inertia;

/**
 * 
 * @package App\Support
 * @method static self success(string $content)
 * @method static self warning(string $content)
 * @method static self error(string $content)
 * @method self success(string $content)
 * @method self warning(string $content)
 * @method self error(string $content)
 */
class FlashMessages
{
    private const MESSAGE_LEVES = [
        'success',
        'warning',
        'error',
    ];

    public function __construct(
        private bool $share_now = false,
    ){}

    private function shouldShareNow(): bool
    {
        return (bool) Inertia::getShared('flash_messages') || $this->share_now;
    }

    private function add(string $level, string $content): void
    {
        $message_data = [
            'id' => uniqid(),
            'level' => $level,
            'content' => $content,
        ];

        if ($this->shouldShareNow()) {
            $messages = Inertia::getShared('flash_messages', []);
            $messages[] = $message_data;
            Inertia::share('flash_messages', $messages);
        } else {
            $messages = session()->get('flash_messages', []);
            $messages[] = $message_data;
            session()->flash('flash_messages', $messages);
        }
    }

    public static function shareNow(): self
    {
        return new static(true); 
    }

    private function validateMethod(string $name): void
    {
        if (! in_array($name, self::MESSAGE_LEVES)) throw new BadMethodCallException('Method '.$name.' not found.');
    }

    public static function __callStatic(string $name, array $arguments = []): self
    {
        $instance = new static;
        $instance->validateMethod($name);
        $instance->add($name, ...$arguments);
        return $instance;
    }

    public function __call(string $name, array $arguments = []): self
    {
        $this->validateMethod($name);
        $this->add($name, ...$arguments);
        return $this;
    }
}