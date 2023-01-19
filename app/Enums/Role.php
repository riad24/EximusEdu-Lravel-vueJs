<?php

namespace App\Enums;

interface Role
{
    public const ADMIN        = 1;
    public const CUSTOMER     = 2;
    public const SUPPLIER     = 3;
    public const POS_OPERATOR  = 4;
    public const BRANCH_MANAGER = 5;
}
