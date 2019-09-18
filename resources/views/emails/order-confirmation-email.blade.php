<p>Thanks for your order!</p>
<p>You can view your tickets at any time by visiting this URL:</p>
<p><a href='{{ url("/orders/{$order->confirmation_number}") }}'></a>{{ url("/orders/{$order->confirmation_number}") }}</p>