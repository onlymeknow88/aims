<x-mail::message>

Berikut kami beritahukan bahwa ada Peraturan Baru yang telah dibuat

Modul : KPP

Nomor : {{$data->number}}

Judul : {{$data->title}}

Jenis Peraturan : {{$data->ruleType->name ?? '-'}}

Otoritas Instansi : {{$data->agencyAuthority->name ?? '-'}}

Status : {{$data->status}}

Date : {{date("d/m/Y")}}

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('kpp/obedience')">
View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
