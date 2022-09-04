<?php

namespace App\Core\Services;

use JetBrains\PhpStorm\Pure;

class SessionService
{
    /**
     * @param string $name
     * @param string|array $value
     * @return $this
     */
    public function set(string $name, string|array $value): static
    {
        $_SESSION[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @param null $value
     * @return bool
     */
    public function has(string $name, $value = null): bool
    {

        if (isset($value)) {
            return (isset($_SESSION[$name]) && $_SESSION[$name] == $value);
        }
        return isset($_SESSION[$name]);

    }

    /**
     * @param string $name
     * @param null $value
     * @return bool
     */
    public function hasFlash(string $name, $value = null): bool
    {

        if (isset($value)) {
            return (isset($_SESSION['flash'][$name]) && $_SESSION['flash'][$name]['flash'] > 0 && $_SESSION['flash'][$name]['value'] == $value);
        }
        return (isset($_SESSION['flash'][$name]));

    }


    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name): mixed
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getFlash(string $name): mixed
    {
        if ($this->hasFlash($name)) {
            return $_SESSION['flash'][$name]['value'];
        }
        return null;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $_SESSION;
    }

    /**
     * @param $name
     * @return $this
     */
    public function delete($name): static
    {
        if ($this->has($name)) {
            unset($_SESSION[$name]);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function flush(): static
    {
        $_SESSION = [];
        return $this;
    }

    public function reduceFlash()
    {
        foreach ($_SESSION['flash'] ?? [] as $key => $session) {
            if ($_SESSION['flash'][$key]['flash'] == 0) {
                unset($_SESSION['flash'][$key]);
            } else {
                $_SESSION['flash'][$key]['flash'] -= 1;
            }
        }
    }
}