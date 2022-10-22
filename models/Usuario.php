<?php

namespace Model;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->passwordActual = $args['passwordActual'] ?? '';
        $this->passwordNuevo = $args['passwordNuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    public function validarLogin()
    {
        if (!$this->email) self::$alertas['error'][] = 'El email del usuario es obligatorio';
        else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) self::$alertas['error'][] = 'El correo es inválido';

        if (!$this->password) self::$alertas['error'][] = 'La contraseña no puede ir vacía';

        return self::$alertas;
    }

    // Validación para cuentas nuevas
    public function validarNuevaCuenta()
    {
        if (!$this->nombre) self::$alertas['error'][] = 'El nombre del usuario es obligatorio';
        if (!$this->email) self::$alertas['error'][] = 'El email del usuario es obligatorio';

        if (!$this->password) self::$alertas['error'][] = 'La contraseña no puede ir vacía';
        else if (strlen($this->password) < 6) self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        else if ($this->password !== $this->password2) self::$alertas['error'][] = 'Las contraseñas no coinciden';

        return self::$alertas;
    }

    public function validarEmail()
    {
        if (!$this->email) self::$alertas['error'][] = 'El correo es obligatorio';
        else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) self::$alertas['error'][] = 'El correo es inválido';

        return self::$alertas;
    }

    public function validarPassword()
    {
        if (!$this->password) self::$alertas['error'][] = 'La contraseña no puede ir vacía';
        else if (strlen($this->password) < 6) self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';

        return self::$alertas;
    }

    public function validarPerfil()
    {
        if (!$this->nombre) self::$alertas['error'][] = 'El nombre del usuario es obligatorio';
        if (!$this->email) self::$alertas['error'][] = 'El email del usuario es obligatorio';

        return self::$alertas;
    }

    public function nuevoPassword(): array
    {
        if (!$this->passwordActual) self::$alertas['error'][] = 'La contraseña actual no puede ir vacía';

        if (!$this->passwordNuevo) self::$alertas['error'][] = 'La contraseña nueva no puede ir vacía';
        else if (strlen($this->passwordNuevo) < 6) self::$alertas['error'][] = 'La contraseña nueva debe contener al menos 6 caracteres';

        return self::$alertas;
    }

    public function comprobarPassword(): bool
    {
        return password_verify($this->passwordActual, $this->password);
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->token = md5(uniqid());
    }
}
