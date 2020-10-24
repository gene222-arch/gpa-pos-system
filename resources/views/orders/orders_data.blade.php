<table class="table table-striped">

    <thead class="table-header">
        <tr class="table-col-name">
            <th>ID</th>
            <th>Customer Name</th>
            <th>Total</th>
            <th>Received Amount</th>
            <th>Status</th>
            <th>To Pay</th>
            <th>Date Ordered</th>
            <th colspan="3" class="orders-actions">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($orders as $order)

            <tr class="order__data__{{ $order->id }}">
                
                <td class="order-id">{{ $order->id }}</td>
                <td class="order-customer-id-{{ $order->id }}">{{ $order->getCustomerName() ?? '' }}</td>
                <td class="order-user-id-{{ $order->id }}">
                    {{ config('settings.currency_symbol') . $order->getTotal() }}
                </td>
                <td>{{ config('settings.currency_symbol') . $order->receivedAmount() }}</td>
                <td>
                    @if ($order->receivedAmount() == $order->getTotal())
                        <span class="badge badge-success">
                            Paid
                        </span>
                    @elseif ($order->receivedAmount() > $order->getTotal())
                        <span class="badge badge-light">
                            Change
                        </span>
                    @elseif (empty($order->receivedAmount()))
                        <span class="badge badge-warning">
                            Partial
                        </span>    
                    @else
                        <span class="badge badge-danger">
                            Not Paid
                        </span>
                    @endif
                </td>
                <td>
                    {{ config('settings.currency_symbol') . number_format($order->getTotal() - $order->receivedAmount(), 2) }}
                </td>
                <td>
                    {{ $order->created_at }}
                </td>
                <td class="read">
                    <a data-target="#showEmployeeModal" data-toggle="modal" class="btn btn-info show-order show-order{{ $order->id }}" id="{{ $order->id }}">
                        <i class="far fa-eye"></i>
                    </a>
                </td>

                <td class="edit">
                    <a data-target="#editEmployeeModal" data-toggle="modal" class="btn btn-warning edit-order edit-order{{ $order->id }}" id="{{ $order->id }}">
                        <i class="far fa-edit"></i>
                    </a>
                </td>

                <td class="delete">
                    <a class="btn btn-danger destroy-order " id="{{ $order->id }}"> 
                        <i class="far fa-trash-alt"></i>
                    </a>
                </td> 

            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <th></th>
        <th></th>
        <th class="total">{{ config('settings.currency_symbol') . $total }}</th>
        <th class="totalReceivedAmount">{{ config('settings.currency_symbol') . $totalReceivedAmount }}</th>
        <th></th>
        <th></th>
        <th></th>
    </tfoot>
</table>


@if (!count($orders))
    <img src="{{ asset('storage/table/empty_data.png') }}" alt="">
@endif



