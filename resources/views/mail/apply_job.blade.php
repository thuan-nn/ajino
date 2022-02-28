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
                        {{$data['email']}},
                        {{$data['phone_number']}},
                        {{$data['title']}},
                        {{$data['content']}},
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
