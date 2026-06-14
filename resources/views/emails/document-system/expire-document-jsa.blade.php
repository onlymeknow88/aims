<x-mail::message>

Berikut kami beritahukan bahwa document telah kadaluarsa

Category Document : Job Safety Analysis

Document : {{ $data['title'] }}

Number : {{ $data['document_number'] }}

Date : {{ date('d/m/Y') }}

Status : Expired

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('document-systems/login')">
    View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
