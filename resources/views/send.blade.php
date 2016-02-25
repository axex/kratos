<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <style>
        * {
            word-wrap: break-word;
        }
        html, body {
            background-color: transparent;
            margin: 0;
            padding: 0;
        }

        body {
            font: 16px/1.5 "Microsoft Yahei", "微软雅黑", verdana;
            word-wrap: break-word;
        }

        pre {
            white-space: pre-wrap;
            white-space: -moz-pre-wrap;
            white-space: -o-pre-wrap;
            word-wrap: break-word;
            font: 16px/1.5 "Microsoft Yahei", "微软雅黑", verdana;
            padding: 8px 10px;
            margin: 0;
        }

        img {
            border: none;
            vertical-align: middle;
        }

        iframe {
            display: none;
        }
    </style>
</head>
<body class="js-body">
<div>
    <div style="background:#555555;padding-top:20px;">
        <br>&nbsp;&nbsp;
        <br>
        <table width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tr>
                <td style="font-family:微软雅黑,Sans-Serif;background:#F5F5F5;border-radius:4px;box-shadow:0 0 8px #333333;">
                    <br>
                    <table width="570" cellspacing="0" cellpadding="0" border="0" align="center">

                        <tr>
                            <td width="200" height="102" valign="middle">
                                <a href=""
                                   target="_blank" style="border:none;text-decoration:none;color:#649F0C">
                                    <img src="http://www.75team.com/weekly/static/logo_s.png" border="0"
                                         style="display:block;font-size:30px;font-family:微软雅黑;color:#649F0C" alt="Kratos"
                                         title="Kratos">
                                </a>
                            </td>
                            <td valign="middle">
                                <div style="margin-bottom:5px;font-family:Helvetica,微软雅黑,Sans-Serif;font-size:30px;color:#649F0C;">
                                    第 {{ $issue }} 期
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br>
                    @foreach($articles as $article)
                        <table width="570" cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed;"
                               align="center">
                            <tr>
                                <td height="40" style="color:#fff;font-size:18px;font-family:微软雅黑,Sans-Serif"
                                    bgcolor="#649F0C">&nbsp;&nbsp;
                                    {{ $article[0]->category->name }}
                                </td>
                            </tr>
                            @foreach($article as $art)
                                <tr>
                                    <td style="font-size:18px;padding:25px 10px 5px 10px;font-family:微软雅黑,Sans-Serif">
                                        <a href="{{ $art->url }}" target="_blank"
                                           style="color:#333333">{{ $art->title }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;padding:5px 10px 0 10px;color:#666666;font-family:微软雅黑,Sans-Serif;line-height:24px;">
                                        {!! $art->desc !!} @if($art->presenter) {{ '（' . $art->presenter . '推荐）' }} @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <br>
                    @endforeach

                    <br>
                    <table width="570" cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed;"
                           align="center">
                        <tr>
                            <td style="font-size:14px;line-height:24px;color:#666;padding:10px;" align="center">我们的网站 <a href="{{ url('/') }}">{{ url('/') }}</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="600" cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed;margin-top:15px;" align="center">
            <tr>
                <td bgcolor="#555555" height="170" style="color:#FFFFFF;font-size: 12px;line-height:24px;font-family:微软雅黑,Sans-Serif" align="center">
                    如果您也有资源要分享，请<a href="{{ route('add') }}" style="color:#FFFFFF" target="_blank">点击这里提交</a>
                    <br>
                    如果您以后不想收到类似邮件，请<a href="{{ $unsubscribe }}" style="color:#FFFFFF" target="_blank">点击这里退订</a>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>