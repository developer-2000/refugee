<table style="font-family:Arial;width:100%;max-width:500px;border:1px solid #e8e8e8;margin:5.5em auto 0;padding: 20px;border-radius:8px;">
    <tbody>
    <tr style="font-family:Arial;margin:0;" align="center">
        <td style="font-family:Arial;margin:0;padding-bottom: 15px;border-bottom: 1px solid #e8e8e8;" align="center">
            <a target="_blank" href="http://127.0.0.1:8000/"
               style="text-decoration-line:none;color:#205fec"
            >
                <img src="http://127.0.0.1:8000/img/email/logo-site.png" alt="Logotype evro-work.com" style="display: block;" title="Logotype evro-work.com" width="150"></a>
                <h2 style="font-family:Arial;margin:0 0 10px 0;font-size:16px;line-height:1.38;padding-top:10px;padding-bottom:0px">
                    {!! $data["title_site"] !!}
                </h2>
        </td>
    </tr>
    <tr style="font-family:Arial;margin:0">
        <td style="font-family:Arial;margin:0;padding: 30px 0;">
            <p style="padding:0;font-weight: 700;margin: 0;font-size: 15px;">
                {!! $data["full_name_person_write"] !!}
            </p>
            <p style="padding:0 0 30px;margin: 0;font-weight: 700;">
                {!! $data["chat_interlocutor"] !!}
                <a rel="noopener noreferrer"
                   href="http://refugee{!! $data["chat_link"] !!}"
                   style="text-decoration-line:none;color:#205fec" target="_blank"
                >
                    {!! $data["chat_title"] !!}
                </a>
            </p>
            <p style="padding:0 0 15px;margin: 0;font-weight: 700;">
                {!! $data["you_have_review_document"] !!}
                <a rel="noopener noreferrer"
                   href="http://refugee{!! $data["offer_document_link"] !!}"
                   style="text-decoration-line:none;color:#205fec" target="_blank"
                >
                    {!! $data["offer_document_title"] !!}
                </a>
            </p>
            <p style="padding:0;margin: 0;">
                {!! $data["chat_text"] !!}
            </p>
        </td>
    </tr>
    <tr style="font-family:Arial;margin:0;">
        <td style="font-family:Arial;margin:0;padding-top: 15px;text-align:center;border-top: 1px solid #e8e8e8;">
            <p style="padding: 0;">
                {!! $data["thank_you_choosing"] !!}
            </p>
            <p style="padding: 0;">
                {!! $data["if_you_have_questions"] !!}
            </p>
            <a rel="noopener noreferrer" href="http://refugee/ru/feedback"
               style="text-decoration-line:none;color:#205fec"
               target="_blank"
            >
                {!! $data["support_center"] !!}
            </a>
        </td>
    </tr>
    </tbody>
</table>
