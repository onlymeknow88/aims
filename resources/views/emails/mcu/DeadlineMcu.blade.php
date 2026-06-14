<x-mail::message>
Berikut kami beritahukan terkait [reminder approval, dokumen yang akan expired] di [Medical Check Up] kepada
{{ $data->doctor_name }}

Name : {{ $data->employee_name }}
Document Date : {{ $data->create_date }}
Due Date : {{ $data->deadline_date }}

Demikian email ini kami sampaikan, atas perhatiannya. Terima kasih

<x-mail::button :url="url('mcu/login')">
Approve Document
</x-mail::button>
</x-mail::message>
