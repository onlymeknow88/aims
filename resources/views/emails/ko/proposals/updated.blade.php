<x-mail::message>

Berikut kami beritahukan bahwa ada pembaruan status proposal.

Modul : KO

Number : {{$data->number}}

Status : {{$data->status}}

Perusahaan : {{ $data->ccow->company_name }}

Area : {{ $data->area }}

Date : {{date("d/m/Y")}}

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('ko/login')">
View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
