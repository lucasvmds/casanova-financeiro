<?php

declare(strict_types=1);

namespace App\Support;

class FlashMessages
{
    /**
     * Adiciona novas mensagens flash
     * 
     * @param string $level
     * @param string $content
     * @return void
     */
    private static function add (string $level, string $content): void
    {
        $messages = session()->get('flash_messages') ?? [];
        $messages[] = [
            'id' => uniqid(),
            'level' => $level,
            'content' => $content,
        ];
        session()->flash('flash_messages', $messages);
    }

    /**
     * Adiciona mensagem de sucesso (cor verde)
     * 
     * @param string $content Conteudo da mensagem
     * @return void
     */
    public static function success(string $content): void
    {
        self::add('success', $content);
    }
    /**
     * Adiciona mensagem de erro (cor vermelha)
     * 
     * @param string $content Conteudo da mensagem
     * @return void
     */
    public static function error(string $content): void
    {
        self::add('error', $content);
    }
    /**
     * Adiciona mensagem de aviso (cor amarela)
     * 
     * @param string $content Conteudo da mensagem
     * @return void
     */
    public static function warning(string $content): void
    {
        self::add('warning', $content);
    }
}