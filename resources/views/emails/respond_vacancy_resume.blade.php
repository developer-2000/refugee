<table style="font-family:Arial;width:100%;max-width:650px;border:1px solid #e8e8e8;margin:5.5em auto 0;padding: 20px;border-radius:8px;">
    <tbody>
    <tr style="font-family:Arial;margin:0;" align="center">
        <td style="font-family:Arial;margin:0;padding-bottom: 15px;border-bottom: 1px solid #e8e8e8;" align="center">
            <a target="_blank" href="{!! $data["domain"] !!}{!! $data["lang_url"] !!}"
               style="text-decoration-line:none;color:#205fec"
            >
                <img src="{!! $data["domain"] !!}/img/email/logo-site.png" alt="Logotype {!! $data["domain"] !!}" style="display: block;width:150px;" title="logotype"></a>
            <h2 style="font-family:Arial;margin:0 0 10px 0;font-size:16px;line-height:1.38;padding-top:10px;padding-bottom:0px">
                {!! $data["title_site"] !!}
            </h2>
        </td>
    </tr>
    <tr style="font-family:Arial;margin:0">
        <td style="font-family:Arial;margin:0;padding: 25px 0;">
            <p style="padding:0;font-weight: 700;margin: 0;font-size: 15px;">
                {!! $data["full_name_person_write"] !!}
            </p>
            <p style="padding:0 0 30px;margin: 0;font-weight: 700;">
                {!! $data["chat_interlocutor"] !!}
                <a rel="noopener noreferrer"
                   href="{!! $data["domain"] !!}{!! $data["chat_link"] !!}"
                   style="text-decoration-line:none;color:#205fec" target="_blank"
                >
                    {!! $data["chat_title"] !!}
                </a>
            </p>
            <p style="padding:0 0 15px;margin: 0;font-weight: 700;">
                {!! $data["you_have_review_document"] !!}
                <a rel="noopener noreferrer"
                   href="{!! $data["domain"] !!}{!! $data["offer_document_link"] !!}"
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
            <a rel="noopener noreferrer" href="{!! $data["domain"] !!}{!! $data["lang_url"] !!}feedback"
               style="text-decoration-line:none;color:#205fec"
               target="_blank"
            >
                {!! $data["support_center"] !!}
            </a>
        </td>
    </tr>
    </tbody>
</table>
