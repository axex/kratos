@extends('frontend.subscribe.head')

@section('body')
    <table height="100%" width="100%" style="background-color: #eee;">
        <tr>
            <td align="center" valign="top">
                <table width="600">
                    <tr>
                        <td align="left" valign="top">
                            <h1>Kratos收件人</h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <table width="600" style="background-color: #fff;">
                    <tr>
                        <td align="left">
                            <p>我们收到了改变您订阅偏好的要求 Kratos收件人.</p>

                            <p>如果您提出过这一要求，并希望改变您的选择，请使用以下链接</p>

                            <p><a href="{{ url('/subscribe/profile/' . $confirmCode ) }}" class="button" target="_blank">更新您的偏好</a></p>

                            <p>如果您没有提出这一要求，它可能是由其他人错误提交。您可以忽略此电子邮件，您的订阅偏好不会发生改变。</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@stop
