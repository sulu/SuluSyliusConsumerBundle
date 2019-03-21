# Addresses

## Messages

Use this messages to create/modify/update/delete addresses from Sylius.

### CreateAddressMessage

Creates a new address for a customer.

```php
$customer = new Customer(99, 'test@test.com', 'test@test.com', 'm');
$address = new Address(null, 'Elon', 'Musk', '10941 Savona Rd', 'CA 900077', 'Los Angeles', 'US');

// create message
$message = new CreateAddressMessage($customer, $address);

// send message
$this->messageBus->dispatch($message);

// get result
$address = $message->getResult();
```

### ModifyAddressMessage

Updates an existing address.

```php
$address = new Address(27, 'Elon', 'Musk', '10941 Savona Rd', 'CA 900077', 'Los Angeles', 'US');

// create message
$message = new ModifyAddressMessage($address);

// send message
$this->messageBus->dispatch($message);
```

### RemoveAddressMessage

Removes an existing address.

```php
// create message
$message = new RemoveAddressMessage(99);

// send message
$this->messageBus->dispatch($message);
```

## Queries

Loads the address with given id.

### FindAddressQuery

```php
// create message
$message = new FindAddressQuery(99);

// send message
$this->getMessageBus()->dispatch($message);

// get result
$address = $message->getAddress();
```

### FindAddressesByCustomerQuery

Loads all addresses for given customer.
Optional parameters are `page` (default `1`) and `limit` (default `10`).
This message will return an object of type `AddressList`.

```php
$customer = new Customer(99, 'test@test.com', 'test@test.com', 'm');

// create message
$message = new FindAddressesByCustomerQuery(99);

// send message
$this->getMessageBus()->dispatch($message);

// get result
$addressList = $message->getAddressList();
$addressList->getAddresses());
$addressList->getPage());
$addressList->getLimit());
$addressList->getPages());
$addressList->getTotal());
```
