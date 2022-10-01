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
            <td style="font-family:Arial;margin:0;padding:25px 0;">
                <p style="text-align:center;padding:0 0 20px;font-size:17px;font-weight:700;margin: 0;">
                    {!! $data["update_your_personal_account"] !!}
                </p>
                <p style="padding:0;margin: 0;">
                    {!! $data["follow_link_change_password"] !!}
                </p>
                <p style="padding:0;margin: 0;">
                    <a rel="noopener noreferrer" href="{!! $data["url"] !!}"
                       style="text-decoration-line:none;color:#205fec" target="_blank">
                        {!! $data["url"] !!}
                    </a>
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
