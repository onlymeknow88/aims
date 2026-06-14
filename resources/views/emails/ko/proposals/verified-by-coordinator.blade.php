<x-mail::message>

Berikut kami beritahukan bahwa proposal telah di verifikasi koordinator dan telah masuk antrian komisioning

Modul : KO

Number : {{$data->number}}

Date : {{date("d/m/Y")}}

Status : Commissioning

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('ko/login')">
View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
