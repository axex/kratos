@extends('frontend.subscribe.head')

@section('body')
    <table border="0" cellpadding="20" cellspacing="0" height="100%" width="100%" style="background-color: #eeeeee;">
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="border-radius: 6px;">
                    <tr>
                        <td align="center" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="600">
                                <tbody>
                                <tr>
                                    <td>
                                        <h1 style="font-size: 28px;line-height: 110%;margin-bottom: 30px;margin-top: 0;padding: 0;">
                                            Kratos收件人</h1>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="600" style="border-radius: 6px;background-color: #ffffff;">
                                <tr>

                                    <td align="left" valign="top" style="line-height: 150%;font-family: Helvetica;font-size: 14px;color: #333333;padding: 20px;">

                                        <h2 style="font-size: 22px;line-height: 28px;margin: 0 0 12px 0;">请确认订阅</h2>
                                        <a target="_blank" href="{{ url('subscribe/'. $confirmCode . '/' . $email) }}"
                                           style="color: #ffffff !important;display: inline-block;font-weight: 500;font-size: 16px;line-height: 42px;font-family: 'Helvetica', Arial, sans-serif;width: auto;white-space: nowrap;height: 42px;margin: 12px 5px 12px 0;padding: 0 22px;text-decoration: none;text-align: center;cursor: pointer;border: 0;border-radius: 3px;vertical-align: top;background-color: #5d5d5d !important;"
                                           >
                                            <span style="display: inline;font-family: 'Helvetica', Arial, sans-serif;text-decoration: none;font-weight: 500;font-style: normal;font-size: 16px;line-height: 42px;cursor: pointer;border: none;background-color: #5d5d5d !important;color: #ffffff !important;">请点击这里，确认您订阅我们的列表。</span></a>
                                        <br>
                                        <div><p style="padding: 0 0 10px 0;">如果您错误地收到本电子邮件，只需将其删除即可。如果您不点击上面的链接，就不会订阅。</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@stop



