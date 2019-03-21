# Order

## Messages

Use this messages to address/complete orders in Sylius.

### AddressOrderMessage

Sets the shipping and delivery address onto the given order.
The parameter `deliveryAddress` is optional (when it's not provided the `shippingAddress` is used).

```php
$shippingAddress = new Address(null, 'Elon', 'Musk', '10941 Savona Rd', 'CA 900077', 'Los Angeles', 'US');

// create message
$message = new AddressOrderMessage(99, $shippingAddress);

// send message
$this->messageBus->dispatch($message);
```

### CompleteOrderMessage

Completes the given order.

```php
// create message
$message = new CompleteOrderMessage(99);

// send message
$this->messageBus->dispatch($message);
```

## Queries

### FindOrdersByCustomerQuery

Loads all orders for given customer.
Optional parameters are `page` (default `1`), `limit` (default `10`), `from` (default `null`) and `to` (default `null`).
This message will return an object of type `OrderList`.

```php
$customer = new Customer(99, 'test@test.com', 'test@test.com', 'm');

// create message
$message = new FindOrdersByCustomerQuery(
    $customer,
    1,
    5,
    new \DateTime('2018-05-05 17:10:00'),
    new \DateTime('2018-10-01 08:00:00')
);

// send message
$this->getMessageBus()->dispatch($message);

// get result
$orderList = $message->getOrderList();
$orderList->getOrders());
$orderList->getPage());
$orderList->getLimit());
$orderList->getPages());
$orderList->getTotal());
```
