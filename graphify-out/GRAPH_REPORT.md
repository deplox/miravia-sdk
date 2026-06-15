# Graph Report - .  (2026-06-14)

## Corpus Check
- Corpus is ~18,597 words - fits in a single context window. You may not need a graph.

## Summary
- 587 nodes · 769 edges · 56 communities (41 shown, 15 thin omitted)
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 39 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- [[_COMMUNITY_Fulfillment & Pagination|Fulfillment & Pagination]]
- [[_COMMUNITY_Graphify Pipeline|Graphify Pipeline]]
- [[_COMMUNITY_Finance Transactions|Finance Transactions]]
- [[_COMMUNITY_API Resource Layer|API Resource Layer]]
- [[_COMMUNITY_Package Configuration|Package Configuration]]
- [[_COMMUNITY_Returns & Reversals|Returns & Reversals]]
- [[_COMMUNITY_Caching & Connection|Caching & Connection]]
- [[_COMMUNITY_Order Items Requests|Order Items Requests]]
- [[_COMMUNITY_Seller & Payout Data|Seller & Payout Data]]
- [[_COMMUNITY_Order Detail & Address|Order Detail & Address]]
- [[_COMMUNITY_Finance Payouts|Finance Payouts]]
- [[_COMMUNITY_SDK Entry Points|SDK Entry Points]]
- [[_COMMUNITY_Product V2 Retrieval|Product V2 Retrieval]]
- [[_COMMUNITY_Product API (v1)|Product API (v1)]]
- [[_COMMUNITY_Finance Transaction Requests|Finance Transaction Requests]]
- [[_COMMUNITY_Orders List Requests|Orders List Requests]]
- [[_COMMUNITY_Shipment Provider Objects|Shipment Provider Objects]]
- [[_COMMUNITY_HTTP Response Layer|HTTP Response Layer]]
- [[_COMMUNITY_Seller Warehouse Objects|Seller Warehouse Objects]]
- [[_COMMUNITY_Product V2 Objects|Product V2 Objects]]
- [[_COMMUNITY_Product V2 Variants|Product V2 Variants]]
- [[_COMMUNITY_Rate Limiting|Rate Limiting]]
- [[_COMMUNITY_Access Token Auth|Access Token Auth]]
- [[_COMMUNITY_Request Signing|Request Signing]]
- [[_COMMUNITY_Product Categories|Product Categories]]
- [[_COMMUNITY_Retry Logic|Retry Logic]]
- [[_COMMUNITY_Authentication|Authentication]]
- [[_COMMUNITY_Carrier Objects|Carrier Objects]]
- [[_COMMUNITY_Category Objects|Category Objects]]
- [[_COMMUNITY_Product V1 Payloads|Product V1 Payloads]]
- [[_COMMUNITY_Country Pricing|Country Pricing]]
- [[_COMMUNITY_Product V2 Payloads|Product V2 Payloads]]
- [[_COMMUNITY_Marketplace Status|Marketplace Status]]
- [[_COMMUNITY_Warehouse Quantity|Warehouse Quantity]]
- [[_COMMUNITY_Laravel Service Provider|Laravel Service Provider]]
- [[_COMMUNITY_Rate Limit Exception|Rate Limit Exception]]
- [[_COMMUNITY_Graph DB Exports|Graph DB Exports]]
- [[_COMMUNITY_Graphify Interpreter Guard|Graphify Interpreter Guard]]
- [[_COMMUNITY_Graph Benchmark|Graph Benchmark]]
- [[_COMMUNITY_Graphify Explain Command|Graphify Explain Command]]
- [[_COMMUNITY_Graphify Path Command|Graphify Path Command]]

## God Nodes (most connected - your core abstractions)
1. `graphify Full Pipeline` - 20 edges
2. `Resource` - 19 edges
3. `MiraviaConnector` - 15 edges
4. `CarbonInterface` - 14 edges
5. `AccessToken` - 11 edges
6. `require` - 10 edges
7. `Miravia` - 9 edges
8. `GenerateAccessTokenRequest` - 9 edges
9. `RefreshAccessTokenRequest` - 9 edges
10. `ApiValueParser` - 9 edges

## Surprising Connections (you probably didn't know these)
- `Project graphify Query Rules` --references--> `graphify Full Pipeline`  [EXTRACTED]
  CLAUDE.md → .claude/skills/graphify/SKILL.md
- `Project graphify Query Rules` --references--> `graphify Query Flow`  [EXTRACTED]
  CLAUDE.md → .claude/skills/graphify/SKILL.md
- `MCP Server (--mcp)` --semantically_similar_to--> `graphify Query Flow`  [INFERRED] [semantically similar]
  .claude/skills/graphify/references/exports.md → .claude/skills/graphify/SKILL.md
- `Fast Path (Existing Graph Query)` --semantically_similar_to--> `Code-Only Change Fast Path (Skip Semantic)`  [INFERRED] [semantically similar]
  .claude/skills/graphify/SKILL.md → .claude/skills/graphify/references/update.md
- `Honesty Rules` --semantically_similar_to--> `Confidence Score Rubric`  [INFERRED] [semantically similar]
  .claude/skills/graphify/SKILL.md → .claude/skills/graphify/references/extraction-spec.md

## Import Cycles
- None detected.

## Hyperedges (group relationships)
- **graphify Full Pipeline Steps (1-9)** — graphify_skill_step1_install, graphify_skill_step2_detect, graphify_skill_step3_extract, graphify_skill_step4_build, graphify_skill_step5_label, graphify_skill_step6_viz, graphify_skill_step9_cleanup [EXTRACTED 1.00]
- **Extraction: AST + Semantic + Merge** — graphify_skill_ast_extraction, graphify_skill_semantic_extraction, graphify_skill_merge_ast_semantic [EXTRACTED 1.00]
- **Graph Database Export Options** — refs_exports_neo4j, refs_exports_falkordb, refs_exports_mcp_server [EXTRACTED 1.00]

## Communities (56 total, 15 thin omitted)

### Community 0 - "Fulfillment & Pagination"
Cohesion: 0.05
Nodes (26): paginate(), GetShipmentProvidersRequest, HasBody, HasFormBody, GetBrandByMaxIdRequest, GetBrandByPagesRequest, GetProductItemsRequest, Request (+18 more)

### Community 1 - "Graphify Pipeline"
Cohesion: 0.06
Nodes (39): graphify Skill, Part A: AST Structural Extraction, Extraction Cache (Step B0), Fast Path (Existing Graph Query), Gemini Backend for Semantic Extraction, graphify Full Pipeline, Honesty Rules, Part C: Merge AST + Semantic Extraction (+31 more)

### Community 2 - "Finance Transactions"
Cohesion: 0.07
Nodes (13): CarbonInterface, GetTransactionsPayload, Transaction, GetTransactionsPayload, GetOrdersPayload, FinanceApi, GetReversalsPayload, self (+5 more)

### Community 3 - "API Resource Layer"
Cohesion: 0.10
Nodes (14): GetOrdersPayload, GetReversalsPayload, FulfillmentApi, OrdersApi, ReturnAndRefundApi, SellerApi, SystemApi, static (+6 more)

### Community 4 - "Package Configuration"
Cohesion: 0.07
Nodes (28): autoload, psr-4, config, optimize-autoloader, preferred-install, sort-packages, description, extra (+20 more)

### Community 5 - "Returns & Reversals"
Cohesion: 0.08
Nodes (9): GetReversalsRequest, Reversal, ReversalCollection, ReversalLine, self, self, self, Method (+1 more)

### Community 6 - "Caching & Connection"
Cohesion: 0.12
Nodes (14): Cacheable, cacheKey(), resolveCacheDriver(), Connector, Driver, HasCaching, HasRateLimits, HasRetries (+6 more)

### Community 7 - "Order Items Requests"
Cohesion: 0.11
Nodes (8): GetMultipleOrderItemsRequest, GetOrderItemsRequest, OrderItem, self, Method, Response, Method, Response

### Community 8 - "Seller & Payout Data"
Cohesion: 0.11
Nodes (7): GetSellerRequest, Seller, self, self, Method, Response, ApiValueParser

### Community 9 - "Order Detail & Address"
Cohesion: 0.11
Nodes (7): Address, GetOrderRequest, Order, self, self, Method, Response

### Community 10 - "Finance Payouts"
Cohesion: 0.12
Nodes (6): GetPayoutsRequest, PayoutStatus, PayoutStatusCollection, self, Method, Response

### Community 11 - "SDK Entry Points"
Cohesion: 0.17
Nodes (8): FinanceApi, FulfillmentApi, OrdersApi, ProductV2Api, ReturnAndRefundApi, SellerApi, Miravia, SystemApi

### Community 12 - "Product V2 Retrieval"
Cohesion: 0.21
Nodes (7): GetProductPayload, ProductCollection, GetProductRequest, ProductV2Api, Method, Response, Response

### Community 13 - "Product API (v1)"
Cohesion: 0.20
Nodes (5): GetProductsPayload, GetProductsRequest, ProductApi, Method, Response

### Community 14 - "Finance Transaction Requests"
Cohesion: 0.16
Nodes (5): GetTransactionsRequest, TransactionCollection, self, Method, Response

### Community 15 - "Orders List Requests"
Cohesion: 0.16
Nodes (5): GetOrdersRequest, OrderCollection, self, Method, Response

### Community 16 - "Shipment Provider Objects"
Cohesion: 0.17
Nodes (4): ShipmentProvider, ShipmentProviderCollection, self, self

### Community 17 - "HTTP Response Layer"
Cohesion: 0.26
Nodes (5): JsonResponse, Responsable, SaloonResponse, Request, Response

### Community 18 - "Seller Warehouse Objects"
Cohesion: 0.17
Nodes (4): Warehouse, WarehouseCollection, self, self

### Community 19 - "Product V2 Objects"
Cohesion: 0.24
Nodes (4): Arrayable, Product, ProductCollection, self

### Community 20 - "Product V2 Variants"
Cohesion: 0.20
Nodes (4): ProductVariant, self, self, TextSanitizer

### Community 21 - "Rate Limiting"
Cohesion: 0.29
Nodes (8): getLimiterPrefixUsing(), handleTooManyAttempts(), resolveLimits(), resolveRateLimitStore(), Limit, RateLimitStore, Closure, Request

### Community 23 - "Request Signing"
Cohesion: 0.43
Nodes (3): SignRequest, RequestMiddleware, PendingRequest

### Community 24 - "Product Categories"
Cohesion: 0.32
Nodes (3): GetCategoryTreeRequest, Method, Response

### Community 25 - "Retry Logic"
Cohesion: 0.43
Nodes (6): handleRetry(), handleRetryUsing(), FatalRequestException, RequestException, Closure, Request

### Community 26 - "Authentication"
Cohesion: 0.47
Nodes (3): Authenticator, MiraviaAuthenticator, PendingRequest

## Knowledge Gaps
- **80 isolated node(s):** `$schema`, `name`, `type`, `description`, `keywords` (+75 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **15 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `CarbonInterface` connect `Finance Transactions` to `Returns & Reversals`, `Order Items Requests`, `Order Detail & Address`, `Finance Payouts`, `Product V2 Objects`, `Access Token Auth`, `Category Objects`?**
  _High betweenness centrality (0.135) - this node is a cross-community bridge._
- **Why does `Resource` connect `API Resource Layer` to `Finance Transactions`, `Product V2 Retrieval`, `Product API (v1)`?**
  _High betweenness centrality (0.088) - this node is a cross-community bridge._
- **What connects `$schema`, `name`, `type` to the rest of the system?**
  _84 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Fulfillment & Pagination` be split into smaller, more focused modules?**
  _Cohesion score 0.05137844611528822 - nodes in this community are weakly interconnected._
- **Should `Graphify Pipeline` be split into smaller, more focused modules?**
  _Cohesion score 0.059379217273954114 - nodes in this community are weakly interconnected._
- **Should `Finance Transactions` be split into smaller, more focused modules?**
  _Cohesion score 0.07386363636363637 - nodes in this community are weakly interconnected._
- **Should `API Resource Layer` be split into smaller, more focused modules?**
  _Cohesion score 0.0967741935483871 - nodes in this community are weakly interconnected._