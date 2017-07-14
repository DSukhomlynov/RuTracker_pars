<?php

namespace app\models;

use yii\base\Model;

class Captcha extends Model
{
    public $captcha;
    public $cap_sid;
    public $cap_code;
    public $cap_image;


    public function rules()
    {
        return [
            // username and password are both required
            [['captcha', 'cap_sid', 'cap_code', 'cap_image'], 'safe'],
        ];
    }
}

