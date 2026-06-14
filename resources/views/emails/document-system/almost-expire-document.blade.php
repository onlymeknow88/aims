<x-mail::message>

Berikut kami beritahukan bahwa document hampir kadaluarasa

Category Document : Document System

Document : {{ $data['documents']['title'] }}

Number : {{ $data['documents']['document_number'] }}

Date : {{ date('d/m/Y') }}

Status : Active

Expire In : {{ $data['day'] }}

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('document-systems/login')">
    View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
