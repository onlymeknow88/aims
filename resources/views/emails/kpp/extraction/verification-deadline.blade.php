<x-mail::message>

Berikut kami beritahukan terkait request approval KPP kepada {{$data->responsibleUser->name}}

Modul : KPP

Pasal : {{$data->number}}

Ayat : {{$data->number}}

Date : {{$data->date}}

Status : Checking

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('kpp/login')">
View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
