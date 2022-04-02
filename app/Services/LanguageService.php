<?php
namespace App\Services;

class LanguageService
{
    /**
     * выбрать флаги и языки для менюхи
     * @return array
     */
    public function getLanguageArray() {
        $lang = [];
        $array_land = config('site.locale.languages');   // мой масив языков
        $lang_local = $this->getNameLanguage();
        $avatar = $array_land[$lang_local][3]['avatar'];
        session(['locale' => $lang_local]);

        // создать масив языков для клиентской части
        foreach ($array_land as $array){
            $lang[] = (object) $array[3];
        }

        return compact( 'avatar', 'lang', 'lang_local');
    }

    /**
     * если в сессии нет языка, выдает язык браузера
     * если в языках сайта нет языка браузера, выдает язык проекта (uk)
     * если в сессии есть язык, выдает его
     * в сессию язык пападает после первой загрузки страницы и при переключениях языка
     *
     * @return false|\Illuminate\Config\Repository|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed|string
     */
    private function getNameLanguage() {
        // язык выбранный ранее юзером (null или uk)
        $session_lang = session('locale');

        if (is_null($session_lang)){
            $browser = $this->getPreferredBrowserLanguage();

            // язык браузера схож с одним из языков сайта
            if ( in_array( $browser, array_keys(config('site.locale.languages')) ) ) {
                return $browser;
            }
            else{
                return config('app.locale');
            }
        }

        return $session_lang;
    }

    /**
     * приоритетный яз браузера - ru
     * @return false|\Illuminate\Config\Repository|mixed|string
     */
    private function getPreferredBrowserLanguage() {
        $l = [];

        // создать приоритетный масив языков
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && ($list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ) {
            if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
                $l = array_combine($list[1], $list[2]);
                foreach ($l as $n => $v){
                    $l[$n] = $v ? $v : 1;
                }
                arsort($l, SORT_NUMERIC);
            }
        }

        // выбрать код приоритетного - ru
        if (count($l)){
            foreach ($l as $str => $key){
                return substr($str, 0, strpos($str, "-"));
            }
        }

        return config('app.locale');
    }

}
