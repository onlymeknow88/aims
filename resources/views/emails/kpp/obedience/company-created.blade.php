<x-mail::message>

Berikut kami beritahukan bahwa ada Peraturan Baru untuk {{$data->company->company_name}}

Modul : KPP

Nomor : {{$data->rule->number}}

Judul : {{$data->rule->title}}

Jenis Peraturan : {{$data->rule->ruleType->name ?? '-'}}

Otoritas Instansi : {{$data->rule->agencyAuthority->name ?? '-'}}

Status : {{$data->rule->status}}

Date : {{date("d/m/Y")}}

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('kpp/obedience/detail?id='. $data->id)">
View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
