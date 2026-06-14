<x-mail::message>
Berikut kami beritahukan terkait invitation event :

Event : {{ $data['event']['title'] }}

Tanggal : {{ $data['event']['start_date'] }} - {{ $data['event']['end_date'] }}

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

@if ($data['type'] == 'login')
<x-mail::button :url="url('coe')">
Event
</x-mail::button>
@else
<x-mail::button :url="url($data['link'])">
Link untuk user non login
</x-mail::button>
@endif

</x-mail::message>
