@if(isset($payments) && isset($expiration))
    <ul class="list-group">

        <li class="list-group-item">

            
        Regitration date: {{ date("Y-m-d",strtotime($profile->user->created_at)) }}       
        </li>



        <li class="list-group-item">
            Past payments
            <ul class="list-group">
                @foreach($payments as $payment) 
                    <li class="list-group-item">
                        {{ $payment->payment_date }}
                    </i>

                @endforeach
            </ul>
        </li>

        <li class="list-group-item">
        Account will expire: {{ $expiration->expiration_date }}
        </li>

    </ul>
@endif