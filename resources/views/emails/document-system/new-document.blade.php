<x-mail::message>

Berikut kami beritahukan bahwa document telah berhasil di buat

Category Document : Document System

Number : {{ $data['number'] }}

Date : {{ date('d/m/Y') }}

Status : Wating for Review

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('document-systems/login')">
    View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
