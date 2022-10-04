@extends('layouts.app')
@section('scripts')
    @parent
    <script>
        $( document ).ready(function(){
            $( ".svg-translate" ).click(() => {
                $(".svg-translate").css("display","none")
                new google.translate.TranslateElement({ layout: google.translate.TranslateElement.InlineLayout.SIMPLE }, "google_translate_element")
            });

            // клик по select выбора language
            $('.box-translate-google').on('click', '#google_translate_element', function () {
                // добавить scroll frame выбора языков
                var iframe = document.getElementsByTagName('iframe')[1];
                $(iframe).css({"width":"100%"})
                $(iframe.contentWindow.document.childNodes).children("body").css({"overflow":"scroll"})
            });
        });

    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@endsection
@section('content')

    <show-charity
        :lang="{{json_encode($lang)}}"
        :response="{{json_encode($response)}}"
    ></show-charity>

@endsection


