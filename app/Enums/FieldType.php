<?php

namespace App\Enums;

interface FieldType
{
    public const TEXT       = 'text';
    public const NUMBER     = 'number';
    public const EMAIL      = 'email';
    public const PASSWORD   = 'password';
    public const RADIO      = 'radio';
    public const CHECKBOX   = 'checkbox';
    public const DATE       = 'date';
}
