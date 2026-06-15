# Miravia SDK

PHP SDK for the [Miravia](https://miravia.com) marketplace API, built on [Saloon v4](https://docs.saloon.dev).

## Requirements

- PHP 8.5+
- Laravel / Illuminate packages (^13.0)

## Installation

```bash
composer require deplox/miravia-sdk
```

Laravel auto-discovery registers the service provider automatically. To publish the config file:

```bash
php artisan vendor:publish --tag=miravia-config
```

## Configuration

Add the following to your `.env`:

```env
MIRAVIA_BASE_URL=https://api.miravia.es/rest
MIRAVIA_APP_KEY=your-app-key
MIRAVIA_SECRET_KEY=your-secret-key
MIRAVIA_SIGN_METHOD=sha256
MIRAVIA_HTTP_TIMEOUT=30
MIRAVIA_CACHE_EXPIRY_SECONDS=300
MIRAVIA_TOKEN_REFRESH_THRESHOLD_DAYS=7
```

| Key | Default | Description |
|-----|---------|-------------|
| `MIRAVIA_BASE_URL` | _(empty)_ | Full base URL of the Miravia REST API |
| `MIRAVIA_APP_KEY` | _(empty)_ | App key from the Miravia developer portal |
| `MIRAVIA_SECRET_KEY` | _(empty)_ | Secret key used to sign requests |
| `MIRAVIA_SIGN_METHOD` | `sha256` | Signing algorithm (`sha256`) |
| `MIRAVIA_HTTP_TIMEOUT` | `30` | HTTP request timeout in seconds |
| `MIRAVIA_CACHE_EXPIRY_SECONDS` | `300` | Response cache TTL in seconds |
| `MIRAVIA_TOKEN_REFRESH_THRESHOLD_DAYS` | `7` | Days before expiry to consider a token "expiring soon" |

### Standalone (without Laravel)

```php
use Deplox\MiraviaSdk\MiraviaConnector;

$connector = new MiraviaConnector(
    appKey: 'your-app-key',
    secretKey: 'your-secret-key',
    signMethod: 'sha256',
    accessToken: 'seller-access-token', // optional, omit for token generation calls
);
```

---

## Authentication

Miravia uses OAuth-style short-lived access tokens. The flow is:

1. Redirect the seller to the Miravia authorization URL
2. Receive an authorization code via callback
3. Exchange the code for an `AccessToken`
4. Store the token; use `accessTokenExpiresSoon()` to detect when to refresh

### Generate an access token

```php
use Deplox\MiraviaSdk\Resources\SystemApi;

$system = new SystemApi($connector); // connector without access token

$token = $system->generateAccessToken('authorization-code-from-callback')->dto();
// $token is an AccessToken DTO

// Persist these values
$token->accessToken;            // string
$token->refreshToken;           // string
$token->accessTokenExpiresAt;   // CarbonInterface
$token->refreshTokenExpiresAt;  // CarbonInterface
$token->countryCode;            // 'es', 'it', ...
$token->accountPlatform;        // 'miravia'

// Serialize to array for storage
$token->toArray();
```

### Refresh an access token

```php
$token = $system->refreshAccessToken($storedRefreshToken)->dto();
```

### Check expiry

```php
if ($token->accessTokenExpiresSoon()) {
    // Refresh before the next request
}

if ($token->refreshTokenExpiresSoon()) {
    // Re-authorize the seller — refresh token itself is near expiry
}
```

### Set the token on the connector

```php
$connector->withAccessToken($token->accessToken);
```

---

## Usage

### Via the `Miravia` facade class (recommended with Laravel)

```php
use Deplox\MiraviaSdk\Miravia;

$miravia = app(Miravia::class);

$miravia->ordersApi()->list(...);
$miravia->sellerApi()->get();
$miravia->systemApi()->generateAccessToken(...);
$miravia->financeApi()->transactions(...);
$miravia->productV2Api()->fetchAll();
$miravia->returnAndRefundApi()->list(...);
$miravia->fulfillmentApi()->shipmentProviders();
```

### Via the connector directly

```php
use Deplox\MiraviaSdk\MiraviaConnector;
use Deplox\MiraviaSdk\Resources\OrdersApi;

$connector = new MiraviaConnector('app-key', 'secret', 'sha256', 'access-token');
$ordersApi = new OrdersApi($connector);
```

---

## Resources

All resource methods return a `Response` object. Call `.dto()` to get the typed DTO, `.dtoOrFail()` to throw on error, or work with the raw response via Saloon's response API.

```php
$response = $ordersApi->list($payload);

$dto     = $response->dto();          // typed DTO or null on failure
$dto     = $response->dtoOrFail();    // throws RequestException on failure
$array   = $response->array();        // raw decoded JSON
$json    = $response->json('data');   // dot-notation accessor
$cached  = $response->isCached();     // bool — true if served from cache
```

### Orders

```php
use Deplox\MiraviaSdk\Payloads\Orders\GetOrdersPayload;
use Deplox\MiraviaSdk\Enums\OrderStatus;
use Deplox\MiraviaSdk\Enums\Country;

$api = $miravia->ordersApi();

// List orders
$payload = new GetOrdersPayload(
    createdAfter: now()->subDays(7),
    status: OrderStatus::Pending,
    countryCode: Country::Es,
    limit: 50,
);
$collection = $api->list($payload)->dto();
// $collection->total    — int, total matching orders
// $collection->items    — Collection<Order>

// Get a single order
$order = $api->get(orderId: 12345)->dto();

// Get items for an order
$items = $api->getItems(orderId: 12345)->dto();
// returns Collection<OrderItem>

// Get items for multiple orders at once
$items = $api->getMultipleItems(ids: [12345, 67890])->dto();
```

#### `Order` DTO properties

| Property | Type | Description |
|----------|------|-------------|
| `id` | `int` | Order ID |
| `orderNumber` | `?int` | Marketplace order number |
| `countryCode` | `string` | Lowercase country code (`es`, `it`) |
| `currencyCode` | `string` | Always `EUR` |
| `marketplaceCode` | `string` | `miravia` or `ae` |
| `warehouseCode` | `string` | Fulfillment warehouse |
| `customerName` | `?string` | Buyer name |
| `paymentMethod` | `?string` | Payment method string |
| `statuses` | `Collection<string>` | All statuses on the order |
| `quantity` | `int` | Item count |
| `total` | `float` | Order total (EUR) |
| `shippingFee` | `float` | Shipping fee |
| `shippingFeeOriginal` | `float` | Pre-discount shipping fee |
| `shippingFeeDiscount` | `float` | Seller shipping discount |
| `voucher` | `float` | Platform voucher applied |
| `voucherSeller` | `float` | Seller-funded voucher |
| `needCancelConfirm` | `bool` | Cancel confirmation required |
| `cancelSellerAgreed` | `bool` | Seller agreed to cancel |
| `isCancelPending` | `bool` | Cancel in progress |
| `addressBilling` | `?Address` | Billing address DTO |
| `addressShipping` | `?Address` | Shipping address DTO |
| `createdAt` | `CarbonInterface` | |
| `updatedAt` | `CarbonInterface` | |

#### `OrderItem` DTO properties (key fields)

| Property | Type | Description |
|----------|------|-------------|
| `id` | `int` | Order item ID |
| `orderId` | `int` | Parent order ID |
| `name` | `string` | Product name |
| `sellerSku` | `string` | Seller SKU |
| `shopSku` | `string` | Platform SKU |
| `status` | `string` | Item status |
| `itemPrice` | `float` | Unit price |
| `paidPrice` | `float` | What buyer paid |
| `shippingFee` | `float` | Shipping fee |
| `voucher` | `float` | Voucher applied |
| `cancelReturnInitiator` | `?string` | Who initiated (`null` for `null-null`) |
| `trackingCode` | `?string` | Shipment tracking number |
| `shipmentProvider` | `?string` | Logistics provider |
| `createdAt` | `CarbonInterface` | |
| `updatedAt` | `CarbonInterface` | |

---

### Seller

```php
$api = $miravia->sellerApi();

// Get seller profile
$seller = $api->get()->dto();
// $seller->sellerId, ->name, ->status, ->isVerified, ->isCb, ...

// Get warehouses
$warehouses = $api->warehouses()->dto();
// $warehouses->items — Collection<Warehouse>
```

---

### Finance

```php
use Deplox\MiraviaSdk\Payloads\Finance\GetTransactionsPayload;

$api = $miravia->financeApi();

// Payout status since a date
$payouts = $api->payouts(createdAfter: now()->subDays(30))->dto();
// $payouts->items — Collection<PayoutStatus>

// Transaction list
$payload = new GetTransactionsPayload(
    startTime: now()->subMonth(),
    endTime: now(),
    limit: 100,
);
$transactions = $api->transactions($payload)->dto();
// $transactions->items — Collection<Transaction>
```

---

### Products (v2 — recommended)

```php
use Deplox\MiraviaSdk\Payloads\ProductV2\GetProductPayload;
use Deplox\MiraviaSdk\Enums\ProductStatus;

$api = $miravia->productV2Api();

// Paginated list
$payload = new GetProductPayload(
    status: ProductStatus::Active,
    page: 1,
    pageSize: 50,
);
$collection = $api->list($payload)->dto();
// $collection->total, ->count, ->items — Collection<Product>

// Fetch specific products by ID
$collection = $api->fetchByIds([111, 222, 333]);

// Fetch ALL products (auto-paginates)
$collection = $api->fetchAll();

// Fetch all with a filter
$collection = $api->fetchAll(new GetProductPayload(status: ProductStatus::Active));
```

#### `Product` DTO (key fields)

| Property | Type | Description |
|----------|------|-------------|
| `id` | `int` | Product ID |
| `name` | `string` | Product title |
| `status` | `string` | Current status |
| `marketplaceStatuses` | `Collection` | Per-marketplace status |
| `variants` | `Collection<ProductVariant>` | SKU variants |
| `mainImages` | `array` | Image URLs |
| `createdAt` | `CarbonInterface` | |
| `updatedAt` | `CarbonInterface` | |

---

### Products (v1 — legacy)

```php
use Deplox\MiraviaSdk\Resources\ProductApi;
use Deplox\MiraviaSdk\Payloads\Product\GetProductsPayload;

$api = new ProductApi($connector);

$api->list(new GetProductsPayload(status: 'active'));
$api->getItems(productId: '12345');
$api->getCategoryTree(lang: 'es_ES');
$api->getBrandsByMaxId(maxId: null, pageSize: 100);
$api->getBrandsByPages(startRow: 0, pageSize: 100);
```

---

### Returns & Refunds

```php
use Deplox\MiraviaSdk\Payloads\ReturnAndRefund\GetReversalsPayload;

$api = $miravia->returnAndRefundApi();

$payload = new GetReversalsPayload(
    pageNo: 1,
    pageSize: 50,
    reverseOrderLineStartTime: now()->subMonth(),
    reverseOrderLineEndTime: now(),
);
$reversals = $api->list($payload)->dto();
// $reversals->items — Collection<Reversal>
```

---

### Fulfillment

```php
$api = $miravia->fulfillmentApi();

$providers = $api->shipmentProviders()->dto();
// $providers->items — Collection<ShipmentProvider>
```

---

## Payload Reference

All payloads can be constructed directly or via `::fromArray()` with validated input.

### `GetOrdersPayload`

| Parameter | Type | Required | Validation |
|-----------|------|----------|------------|
| `createdAfter` | `?CarbonInterface` | one of created/updated after | — |
| `createdBefore` | `?CarbonInterface` | no | — |
| `updatedAfter` | `?CarbonInterface` | one of created/updated after | — |
| `updatedBefore` | `?CarbonInterface` | no | — |
| `buyerId` | `?int` | no | integer |
| `countryCode` | `?Country` | no | `Country` enum |
| `status` | `?OrderStatus` | no | `OrderStatus` enum |
| `marketplace` | `?Marketplace` | no | `Marketplace` enum |
| `sortBy` | `?SortTimestamp` | no | `SortTimestamp` enum |
| `sortDirection` | `?SortDirection` | no | `SortDirection` enum |
| `offset` | `?int` | no | multiple of 10 |
| `limit` | `?int` | no | multiple of 10, max 100 |

### `GetTransactionsPayload`

| Parameter | Type | Required | Validation |
|-----------|------|----------|------------|
| `startTime` | `?CarbonInterface` | yes | date |
| `endTime` | `?CarbonInterface` | yes | date |
| `transactionType` | `?TransactionType` | no | `TransactionType` enum |
| `tradeOrderId` | `?int` | no | integer |
| `tradeOrderLineId` | `?int` | no | integer |
| `offset` | `?int` | no | multiple of 10 |
| `limit` | `?int` | no | multiple of 10, max 500 |

### `GetProductPayload` (v2)

| Parameter | Type | Required | Validation |
|-----------|------|----------|------------|
| `ids` | `?array<int>` | no | array |
| `skus` | `?array<string>` | no | array |
| `marketplace` | `?Marketplace` | no | `Marketplace` enum |
| `status` | `?ProductStatus` | no | `ProductStatus` enum |
| `page` | `?int` | no | min 1 |
| `pageSize` | `?int` | no | min 1, max 50 |
| `minCreatedAt` | `?int` | no | Unix timestamp |
| `maxCreatedAt` | `?int` | no | Unix timestamp |
| `language` | `?string` | no | — |
| `showAllLanguages` | `?bool` | no | — |
| `productIdCursor` | `?string` | no | — |
| `extraInfoFilter` | `?array` | no | array |

### `GetReversalsPayload`

| Parameter | Type | Default | Validation |
|-----------|------|---------|------------|
| `pageNo` | `int` | `1` | min 1 |
| `pageSize` | `int` | `10` | min 1, max 200 |
| `ofcStatusList` | `?string` | — | — |
| `reverseStatusList` | `?string` | — | — |
| `reverseOrderId` | `?int` | — | — |
| `tradeOrderId` | `?int` | — | — |
| `reverseOrderLineStartTime` | `?CarbonInterface` | — | — |
| `reverseOrderLineEndTime` | `?CarbonInterface` | — | — |
| `tradeOrderStartTime` | `?CarbonInterface` | — | — |
| `tradeOrderEndTime` | `?CarbonInterface` | — | — |
| `disputeInProgress` | `?bool` | — | — |
| `reverseTrackingNumber` | `?string` | — | — |
| `marketplace` | `?Marketplace` | — | `Marketplace` enum |

---

## Enums

All enums under `Deplox\MiraviaSdk\Enums\` normalize API strings via `fromApiValue()`.

| Enum | Cases |
|------|-------|
| `Country` | `Es`, `It`, `Pt`, `Fr`, `De`, ... |
| `Currency` | `EUR` |
| `Marketplace` | `Miravia`, `AliExpress` |
| `OrderStatus` | `Pending`, `Confirmed`, `Shipped`, `Delivered`, `Canceled`, `Returned`, ... |
| `ProductStatus` | `Active`, `Inactive`, `Deleted` |
| `SortDirection` | `Asc`, `Desc` |
| `SortTimestamp` | `CreatedAt`, `UpdatedAt` |
| `TransactionType` | Various integer-backed transaction types |
| `ReversalStatus` | Return/reversal lifecycle states |
| `WarehouseStatus` | `Active`, `Inactive` |

---

## Response & Error Handling

The Miravia API returns HTTP 200 for both success and error responses. The SDK detects failures by checking `code !== '0'` in the response body and marks those responses as failed, triggering Saloon's retry and exception pipeline.

```php
use Saloon\Exceptions\Request\RequestException;

try {
    $dto = $response->dtoOrFail();
} catch (RequestException $e) {
    $error = $e->getResponse()->json(); // ['code' => 'E001', 'message' => '...', 'type' => '...']
}

// Or check manually
if ($response->failed()) {
    $error = $response->error(); // ['type', 'code', 'message', 'request_id']
}
```

### Laravel HTTP responses

`Response` implements `Responsable`, so you can return it from a controller:

```php
public function orders(): Response
{
    return $miravia->ordersApi()->list($payload);
    // Renders {"meta": {...}, "data": {...}}
}
```

The `meta` block includes `status`, `failed`, and `cached` flags.

---

## Caching, Rate Limiting & Retries

These are active by default on every `MiraviaConnector` instance.

| Feature | Behaviour |
|---------|-----------|
| **Caching** | GET responses cached for `MIRAVIA_CACHE_EXPIRY_SECONDS` (default 300 s) using Laravel's default cache driver |
| **Rate limiting** | Saloon rate-limit plugin; raises `RateLimitReachedException` when the Miravia quota is hit |
| **Retries** | 3 attempts with exponential backoff starting at 2 s; covers both HTTP errors and API error codes |

Disable caching per-request if you need fresh data:

```php
// Saloon allows disabling cache via request-level config — extend Request and override defaultConfig()
```

---

## Request Signing

Every request is automatically signed with HMAC-SHA256 (or the configured `sign_method`). The `SignRequest` middleware runs on each request and appends `app_key`, `timestamp`, `sign_method`, and `sign` query parameters. You never need to sign manually.

---

## Testing

```bash
composer test      # Pest test suite (102 tests)
composer stan      # PHPStan level 8
```

In your own tests, use Saloon's `MockClient`:

```php
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

$connector = new MiraviaConnector('key', 'secret', 'sha256', 'token');
$connector->withMockClient(new MockClient([
    MockResponse::make(['code' => '0', 'data' => [/* ... */]]),
]));

$dto = (new OrdersApi($connector))->get(12345)->dto();
```

For tests that verify signing (where the request must go through the middleware pipeline):

```php
$pendingRequest = $connector->createPendingRequest(new GetSellerRequest);
$query = $pendingRequest->query()->all();

expect($query)->toHaveKey('sign')->toHaveKey('timestamp');
```

---

## Architecture

```
src/
├── MiraviaConnector.php       # Saloon connector — auth, signing, retries, caching
├── Miravia.php                # Facade class — entry point to all resource APIs
├── MiraviaSdkServiceProvider  # Laravel service provider — singleton bindings
├── Response.php               # Extended Saloon response — Responsable, error(), meta()
├── Resource.php               # Base resource class
├── Request.php                # Base request class
│
├── Resources/                 # API resource classes
│   ├── OrdersApi.php
│   ├── SellerApi.php
│   ├── SystemApi.php
│   ├── FinanceApi.php
│   ├── ProductApi.php         # v1 (legacy)
│   ├── ProductV2Api.php       # v2 with auto-pagination
│   ├── ReturnAndRefundApi.php
│   └── FulfillmentApi.php
│
├── Payloads/                  # Validated input objects
├── Requests/                  # Saloon request classes (one per endpoint)
├── Objects/                   # Response DTOs (readonly, Arrayable)
├── Enums/                     # Backed enums with API value normalization
├── Middlewares/               # SignRequest middleware
├── Concerns/                  # HasCaching, HasRateLimits, HasRetries, PaginatesRequests
└── Support/                   # ApiValueParser, TextSanitizer
```

### `ApiValueParser`

Utility for safe parsing of Miravia API values:

```php
use Deplox\MiraviaSdk\Support\ApiValueParser;

ApiValueParser::amount('49,99');           // 49.99 — European comma-decimal
ApiValueParser::amount(null);              // 0.0
ApiValueParser::bool('true');             // true
ApiValueParser::bool('0');                // false
ApiValueParser::cancelReturnInitiator('null-null');  // null
ApiValueParser::cancelReturnInitiator('seller-cancel'); // 'seller-cancel'
ApiValueParser::countries(['ES', 'IT']);  // ['ES', 'IT']
```

> **Important:** Miravia returns monetary amounts as European-formatted strings (e.g. `"49,99"`). Always use `ApiValueParser::amount()` — never cast directly with `(float)`.
