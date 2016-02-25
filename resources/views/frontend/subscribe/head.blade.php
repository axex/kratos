<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Kratos收件人</title>
    <style type="text/css">/* Forms */

        label {
            display:block;
            width:auto;
            margin-top:8px;
            font-weight:bold;
        }
        input, textarea, select {
            display:block;
            margin:0;
            padding:10px;
            background:#fff;
            width:100%;
            border:2px solid #d0d0d0 !important;
            border-radius:3px;
            -webkit-appearance: none;
        }

        .field-group input, select, textarea {
            font-size: 14px;
        }

        .field-group.error > input,
        .field-group.error > select,
        .field-group.error .addressfield input.empty,
        .field-group.error .birthdayfield,
        .field-group.error .subfields,
        .field-group.error .datefield .dijitInputInner,
        .datefield .dijitTextBoxError .dijitInputInner,
        .field-group.error textarea {
            border-color:#e85c41 !important;
        }

        textarea {
            font:14px/18px 'Helvetica', Arial, sans-serif;
            width:100%;
            height:150px;
            overflow:auto;
        }

        html[dir="rtl"] select {background-position:14px -295px;}

        /* Firefox always displays native select arrow button, so hide the background image arrow. */
        @-moz-document url-prefix() {
            select {
                padding: 8px;
                background-position: -99px 0 !important;
                -moz-appearance: none;
            }
        }

        input:focus, textarea:focus, select:focus, .focused-field .subfields {
            border-color:#5d5d5d !important;
            outline:none;
        }

        /* Prevent Chrome's autofill yellow box shadow */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px white inset !important;
        }

        .field-help .help {
            min-height:16px;
            text-decoration: none;
        }


        /* Error container */

        .feedback br {display:none;}

        .feedback div {
            font:14px/20px 'Helvetica', Arial, sans-serif !important;
            padding:0 !important;
            margin:0 !important;
        }

        .indicates-required {text-align:right;}
        .indicates-required span {
            font-size:150%;
            font-weight:bold;
            display:inline !important;
        }

        /* Groups, checkboxes, radio buttons */
        ul.interestgroup_field,
        ul.interestgroup_field li,
        ul.unsub-options,
        ul.unsub-options li,
        .interestgroup_row {
            display:block;
            padding:0;
            margin:0;
            list-style:none;
        }
        label.checkbox, label.radio {
            font-weight:normal;
            position:relative;
            line-height:24px;
        }
        .checkbox input, .radio input {
            width:auto !important;
            display:inline-block;
            margin-right:5px;
            padding:0;
            border:none;
            background-color:transparent;
        }

        .subfields input {
            display:inline-block;
            margin:0;
            padding:0;
            width:2.5em;
            border:none !important;
            text-align:center;
        }
        .subfields label {display:none;}
        .phonedetail2 input {width:3.4em;}
        .birthdayfield input {width:1.7em;}

        /* Forward to friend */
        .captcha input {display:inline;}

        /* Archive list */
        #archive-list li {
            display:block;
            list-style:none;
            margin:0;
            padding:6px 10px;
            border-bottom:1px solid #eee;
        }

        input, textarea, select {
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }


        /* Image replacement for checkbox and radio buttons. */
        /* Placing in @media block forces browsers that don't support :checked to fall back to native inputs. */
        @media only screen {
            .mergeRow-radio .field-group, .mergeRow-interests-checkboxes .field-group {
                margin: 0 -6px 11px -6px;
            }

            /* Position and hide the real checkboxes and radio buttons */
            .checkbox input, .radio input {
                position: absolute;
                width: 24px;
                height: 24px;
                overflow: hidden;
                margin: 0;
                padding: 0;
                outline: 0;
                opacity: 0;
            }

            .checkbox input + span, .radio input + span {
                display: block;
                border-radius: 3px;
                padding: 6px 6px 6px 38px;
            }

            .checkbox:hover span,
            .checkbox input:focus + span,
            .radio:hover span,
            .radio input:focus + span {
                background: rgba(0, 0, 0, .05);
            }

            /* Insert a pseudo element inside each label with a background sprite.  */
            .checkbox input + span:before, .radio input + span:before {
                display: block;
                position: absolute;
                top: 6px;
                left: 6px;
                width: 24px;
                height: 24px;
                content: " ";
                vertical-align: top;
            }
        }
    </style>
    <style type="text/css">
        body{
            font:14px/20px 'Helvetica', Arial, sans-serif;
            margin:0;
            padding:75px 0 0 0;
            text-align:center;
            -webkit-text-size-adjust:none;
        }
        p{
            padding:0 0 10px 0;
        }
        h1 img{
            max-width:100%;
            height:auto !important;
            vertical-align:bottom;
        }
        h2{
            font-size:22px;
            line-height:28px;
            margin:0 0 12px 0;
        }
        h3{
            margin:0 0 12px 0;
        }
        .wrapper{
            width:600px;
            margin:0 auto 10px auto;
            text-align:left;
        }

        .wrapper .error {
            color: #e85c41;
            font-weight: 700;
        }
        input.button{
            border:none !important;
        }
        .button{
            display:inline-block;
            font-weight:500;
            font-size:16px;
            line-height:42px;
            font-family:'Helvetica', Arial, sans-serif;
            width:auto;
            white-space:nowrap;
            height:42px;
            margin:12px 5px 12px 0;
            padding:0 22px;
            text-decoration:none;
            text-align:center;
            cursor:pointer;
            border:0;
            border-radius:3px;
            vertical-align:top;
        }
        .button span{
            display:inline;
            font-family:'Helvetica', Arial, sans-serif;
            text-decoration:none;
            font-weight:500;
            font-style:normal;
            font-size:16px;
            line-height:42px;
            cursor:pointer;
            border:none;
        }
        .rounded6{
            border-radius:6px;
        }

        .profile-list li{
            display:block;
            margin:0;
            padding:5px 0;
            border-bottom:1px solid #eee;
        }
        html[dir=rtl] .wrapper,html[dir=rtl] .container,html[dir=rtl] label{
            text-align:right !important;
        }
        html[dir=rtl] ul.interestgroup_field label{
            padding:0;
        }
        html[dir=rtl] ul.interestgroup_field input{
            margin-left:5px;
        }
        html[dir=rtl] .hidden-from-view{
            right:-5000px;
            left:auto;
        }
        body,#bodyTable{
            background-color:#eeeeee;
        }
        h1{
            font-size:28px;
            line-height:110%;
            margin-bottom:30px;
            margin-top:0;
            padding:0;
        }
        #templateBody{
            background-color:#ffffff;
        }
        .bodyContent{
            line-height:150%;
            font-family:Helvetica;
            font-size:14px;
            color:#333333;
            padding:20px;
        }
        a:link,a:active,a:visited,a{
            color:#336699;
        }
        .button:link,.button:active,.button:visited,.button,.button span{
            background-color:#5d5d5d !important;
            color:#ffffff !important;
        }

        label{
            line-height:150%;
            font-family:Helvetica;
            font-size:16px;
            color:#5d5d5d;
        }
        .field-group input,select,textarea,.dijitInputField{
            font-family:Helvetica;
            color:#5d5d5d !important;
        }
    </style>
</head>
<body>
@yield('body')
</body>
</html>