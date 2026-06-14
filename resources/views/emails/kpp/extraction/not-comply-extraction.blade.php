<x-mail::message>

Berikut kami beritahukan bahwa ada ekstraksi yang tidak patuh {{$data->obedience->company->company_name}}

Modul : KPP

Nomor : {{$data->obedience->rule->number}}

Judul : {{$data->obedience->rule->title}}

Jenis Peraturan : {{$data->obedience->rule->ruleType->name ?? '-'}}

Otoritas Instansi : {{$data->obedience->rule->agencyAuthority->name ?? '-'}}

Status : {{$data->obedience->rule->status}}

Date : {{date("d/m/Y")}}

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('kpp/obedience/detail?id='. $data->obedience->id)">
View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
