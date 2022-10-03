<?php
namespace App\Http\Traits;

use Jorenvh\Share\ShareFacade;

trait SharingTraite {

    // вернуть ссылки шаринга соц-сетей
    public function getLinksShare() {
        $title = env('APP_NAME_EN', "");
        return ShareFacade::page(url()->current(), $title)
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();
    }


}
