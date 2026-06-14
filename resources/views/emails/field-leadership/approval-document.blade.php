<x-mail::message>

Berikut kami beritahukan bahwa document telah direview oleh PJA

Category Document : Field Leadership

Number : {{ $data->number }}

Date : {{ date('d/m/Y') }}

Status : {{ $data->status }} - Wating for Approval

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('field-leadership/login')">
    View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
