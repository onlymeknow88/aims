<x-mail::message>

Berikut kami beritahukan terkait request approval Inspeksi KPLH kepada {{ $data->pja->user->name }}

Modul : Inspeksi KPLH

Date : {{ date('d/m/Y') }}

Status : Waiting Approval

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('kplh/login')">
View
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
