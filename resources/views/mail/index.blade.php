<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    @include('mail.layouts.styles-template-mail')
</head>
<body yahoo bgcolor="#f6f8f1">
<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>
        @include('mail.layouts.header')
        <!--main-->
        @yield('main')
        <!--main-->
        @include('mail.layouts.footer')
        </td>
    </tr>
</table>
@include('mail.layouts.contact-content')
@include('mail.layouts.career-content')
</body>
</html>
