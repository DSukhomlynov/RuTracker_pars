<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class MyList extends ActiveRecord
{
    public static function tableName()
    {
        return 'data';
    }

    public static function getData()
    {
        $data = self::find()->where(['id' => 0])->one();
        return $data;
    }


    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        Yii::setAlias('@cookies', Yii::getAlias('@webroot') . '/assets/tmp');
    }

    public function rules()
    {
        return [
            [['text', 'cap_sid', 'cap_code', 'cap_code_value'], 'safe']
        ];
    }

    public static function initcap($login, $password, $code)
    {

    }

    public static function initializanion($login, $password, $code, &$captcha)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_URL, 'https://rutracker.org/forum/login.php');
        curl_setopt($ch, CURLOPT_COOKIEJAR, Yii::getAlias('@cookies') . '/cookiefile');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');

        $login = mb_convert_encoding($login, 'windows-1251', mb_detect_encoding($login));
        $password = mb_convert_encoding($password, 'windows-1251', mb_detect_encoding($password));
        $login = rawurlencode($login);
        $password = rawurlencode($password);

        if ($code == NULL) {
            $data = array('redirect' => 'search.php',
                'login_username' => $login,
                'login_password' => $password,
                'login' => '%C2%F5%EE%E4'
            );
            $post = "redirect=search.php&login_username=$login&login_password=$password&login=%C2%F5%EE%E4";
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        if ($code != NULL) {
            $data = array('redirect' => 'index.php',
                'login_username' => $login,
                'login_password' => $password,
                'cap_sid' => $captcha->cap_sid,
                $captcha->cap_code => $code,
                'login' => '%C2%F5%EE%E4'
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $res = curl_exec($ch);
        $res = iconv("windows-1251", "utf-8", $res);

        $document = \phpQuery::newDocument($res);
        $autorized = $document->find(".logged-in-as-wrap")->html();

        $captcha->cap_image = $document->find("[alt='pic']");
        $captcha->cap_sid = $document->find("[name='cap_sid']")->attr('value');
        $captcha->cap_code = $document->find("[name^='cap_code_']")->attr('name');

        $error = "Что-то пошло не так, попробуйте зайти заново";
        curl_close($ch);

        if (!empty($autorized)) {
            return "success";
        } elseif (isset($captcha->cap_image)) {
            return "captcha";
        } else {
            return $error;
        }

    }

    public static function get_content($url, $page)
    {
        $ch = curl_init();
        // - настройки curl
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, Yii::getAlias('@cookies') . '/cookiefile');
        curl_setopt($ch, CURLOPT_URL, 'https://rutracker.org/forum/tracker.php?nm=' . $url);

        curl_setopt($ch, CURLOPT_COOKIEJAR, Yii::getAlias('@cookies') . '/cookiefile');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.0; ru; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3');

        $str = $page * 50;
        $data = array('search_id' => 'Nr9mSdem1r9D',
            'start' => $str,
            'nm' => $url
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $res = curl_exec($ch);
        $res = iconv("windows-1251", "utf-8", $res);

        curl_close($ch);

        $doc = \phpQuery::newDocument($res);
        $autorized = $doc->find(".logged-in-as-wrap")->html();

        $i = 0;
        foreach ($doc->find("#tor-tbl tbody tr.tCenter.hl-tr") as $el) {
            $torr[$i][0] = pq($el)->find('[data-topic_id]')->text();
            $torr[$i][1] = pq($el)->find('[data-topic_id]')->attr('href');
            $torr[$i][1] = str_replace("viewtopic", "dl", $torr[$i][1]);
            $torr[$i][1] = 'https://rutracker.org/forum/' . $torr[$i][1];
            $torr[$i][2] = pq($el)->find('.seedmed')->text();
            if ($torr[$i][2] == null) {
                $torr[$i][2] = 0;
            }
            $torr[$i][3] = pq($el)->find('.leechmed')->text();
            $torr[$i][4] = pq($el)->find('.small.tr-dl.dl-stub')->text();
            $torr[$i][4] = substr($torr[$i][4], 0, -3);
            $i++;
        }

        return $torr;
    }

}