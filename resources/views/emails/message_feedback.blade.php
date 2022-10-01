<table style="font-family:Arial;width:100%;max-width:650px;border:1px solid #e8e8e8;margin:5.5em auto 0;padding: 20px;border-radius:8px;">
    <tbody>
    <tr style="font-family:Arial;margin:0;" align="center">
        <td style="font-family:Arial;margin:0;padding-bottom: 15px;border-bottom: 1px solid #e8e8e8;" align="center">
            <a target="_blank" href="{!! $data["domain"] !!}{!! $data["lang_url"] !!}"
               style="text-decoration-line:none;color:#205fec"
            >
                <img src="{!! $data["domain"] !!}/img/email/logo-site.png" alt="Logotype {!! $data["domain"] !!}" style="display: block;width:150px;" title="Logotype {!! $data["domain"] !!}"></a>
            <h2 style="font-family:Arial;margin:0 0 10px 0;font-size:16px;line-height:1.38;padding-top:10px;padding-bottom:0px">
                {!! $data["title_site"] !!}
            </h2>
        </td>
    </tr>
    <tr style="font-family:Arial;margin:0">
        <td style="font-family:Arial;margin:0;padding:30px 20px;">
            <img class="adapt-img" src="{!! $data["domain"] !!}/img/email/feedback.png"  alt="message feedback"
                 style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;margin:0 auto 15px"
                 width="100"
            >
            <p style="text-align:center;padding:0;font-size:17px;font-weight:700;">
                {!! $data["we_greet_you"] !!} {!! $data["full_name"] !!}.
            </p>
            <p style="text-align:left;padding:0;">
                {!! $data["we_have_received"] !!}
            </p>
            <p style="text-align:left;padding-bottom:10px;">
                {!! $data["text"] !!}
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
