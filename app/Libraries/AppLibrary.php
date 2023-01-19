<?php

namespace App\Libraries;

use App\Enums\AmountType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;
use Smartisan\Settings\Facades\Settings;

class AppLibrary
{

    public static function date($date, $pattern = null) : string
    {
        if (!$pattern) {
            $pattern = 'd-m-Y';
        }
        return Carbon::parse($date)->format($pattern);
    }

    public static function associativeToNumericArrayBuilder($array) : array
    {
        $i          = 1;
        $buildArray = [];
        if (count($array)) {
            foreach ($array as $arr) {
                if (isset($arr['children'])) {
                    $children = $arr['children'];
                    unset($arr['children']);

                    $arr['parent']  = 0;
                    $buildArray[$i] = $arr;
                    $parentId       = $i;
                    $i++;
                    foreach ($children as $child) {
                        $child['parent'] = $parentId;
                        $buildArray[$i]  = $child;
                        $i++;
                    }
                } else {
                    $arr['parent']  = 0;
                    $buildArray[$i] = $arr;
                    $i++;
                }
            }
        }
        return $buildArray;
    }

    public static function numericToAssociativeArrayBuilder($array) : array
    {
        $i                 = 0;
        $parentId          = null;
        $parentIncrementId = null;
        $buildArray        = [];
        if (count($array)) {
            foreach ($array as $arr) {
                if (!$arr['parent']) {
                    $parentId          = $arr['id'];
                    $parentIncrementId = $i;
                    $buildArray[$i]    = $arr;
                    $i++;
                }

                if ($arr['parent'] === $parentId) {
                    $buildArray[$parentIncrementId]['children'][] = $arr;
                }
            }
        }
        return $buildArray;
    }

    public static function permissionWithAccess(&$permissions, $rolePermissions) : object
    {
        if ($permissions) {
            foreach ($permissions as $permission) {
                if (isset($rolePermissions[$permission->id])) {
                    $permission->access = true;
                } else {
                    $permission->access = false;
                }
            }
        }
        return $permissions;
    }

    public static function menu(&$menus, $permissions) : array
    {
        if ($menus && $permissions) {
            foreach ($menus as $key => $menu) {
                if (isset($permissions[$menu['url']]) && !$permissions[$menu['url']]['access']) {
                    if ($menu['url'] != '#') {
                        unset($menus[$key]);
                    }
                }
            }
        }
        return $menus;
    }

    public static function pluck($array, $value, $key = null, $type = 'object') : array
    {
        $returnArray = [];
        if ($array) {
            foreach ($array as $item) {
                if ($key != null) {
                    if ($type == 'array') {
                        $returnArray[$item[$key]] = strtolower($value) == 'obj' ? $item : $item[$value];
                    } else {
                        $returnArray[$item[$key]] = strtolower($value) == 'obj' ? $item : $item->$value;
                    }
                } elseif ($value == 'obj') {
                    $returnArray[] = $item;
                } elseif ($type == 'array') {
                    $returnArray[] = $item[$value];
                } else {
                    $returnArray[] = $item->$value;
                }
            }
        }
        return $returnArray;
    }

    public static function currency($amount) : string
    {
        return number_format($amount, 2, '.', '');
    }

    public static function username($name)
    {
        if ($name) {
            $username = strtolower(str_replace(' ', '', $name)) . rand(1, 999999);
            if (User::where(['username' => $username])->first()) {
                self::username($name);
            }
            return $username;
        }
    }


    public static function amountCheck($amount, $attr = 'price') : object
    {
        $response = [
            'status'  => true,
            'message' => ''
        ];

        if (!is_numeric($amount)) {
            $response['status']  = false;
            $response['message'] = "This {$attr} must be integer.";
        }

        if ($amount <= 0) {
            if ($response['status'] == false) {
                return (object)$response;
            } else {
                $response['status']  = false;
                $response['message'] = "This {$attr} negative amount not allow.";
            }
        }

        $replaceValue = str_replace('.', '', $amount);
        if (strlen($replaceValue) > 12) {
            if ($response['status'] == false) {
                return (object)$response;
            } else {
                $response['status']  = false;
                $response['message'] = "This {$attr} length can't be greater than 12 digit.";
            }
        }

        if (!preg_match("/^\d{1,10}(\.\d{1,2})?$/", $amount)) {
            if ($response['status'] == false) {
                return (object)$response;
            } else {
                $response['status']  = false;
                $response['message'] = "This {$attr} amount provide invalid.";
            }
        }

        return (object)$response;
    }

}
