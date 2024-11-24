<?php

class TokenGenerator
{
    /**
     * Generar un token único y seguro.
     * @return string Token generado.
     */
    public static function generate()
    {
        // Usa random_bytes para mayor seguridad (criptográficamente seguro)
        return bin2hex(random_bytes(32));
    }
}
