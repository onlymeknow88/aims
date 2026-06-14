<x-mail::message>
Berikut kami beritahukan terkait:

Event : {{ $data->event_name }}
Item : [item]
Sub item : [Sub_Item]
Tanggal : [{{ $data->deadline_date }}]

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('coe')">
Event
</x-mail::button>
</x-mail::message>
