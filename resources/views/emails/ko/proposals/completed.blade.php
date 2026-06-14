<x-mail::message>

Berikut kami beritahukan bahwa proposal KO telah lulus komisioning

Modul : KO

Number : {{$data->number}}

Date : {{date("d/m/Y")}}

Status : Completed

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('ko/login')">
View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
