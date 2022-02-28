@extends('mail.index')
@section('main')
    <tr>
        <td class="innerpadding borderbottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="h2">
                        Welcome to Ajinomoto Vietnam, {{$data['name']}}!
                    </td>
                </tr>
                <tr>
                    <td class="bodycopy">
                        <p>Từ: {{$data['name']}}</p>
                        <p>Email: {{$data['email']}}</p>
                        <p>Địa chỉ: {{$data['address']}}</p>
                        <p>Điện thoại: {{$data['phone_number']}}</p>
                        <p>Lý do: {{\App\Enums\ReasonContactEnum::getDescription($data['reason'])}}</p>
                        <p>Nội dung:</p> <br>
                        <p>{{$data['address']}}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
