# Graph Report - .  (2026-06-14)

## Corpus Check
- Corpus is ~18,597 words - fits in a single context window. You may not need a graph.

## Summary
- 587 nodes · 769 edges · 56 communities (41 shown, 15 thin omitted)
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 39 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- [[_COMMUNITY_Community 0|Community 0]]
- [[_COMMUNITY_Community 1|Community 1]]
- [[_COMMUNITY_Community 2|Community 2]]
- [[_COMMUNITY_Community 3|Community 3]]
- [[_COMMUNITY_Community 4|Community 4]]
- [[_COMMUNITY_Community 5|Community 5]]
- [[_COMMUNITY_Community 6|Community 6]]
- [[_COMMUNITY_Community 7|Community 7]]
- [[_COMMUNITY_Community 8|Community 8]]
- [[_COMMUNITY_Community 9|Community 9]]
- [[_COMMUNITY_Community 10|Community 10]]
- [[_COMMUNITY_Community 11|Community 11]]
- [[_COMMUNITY_Community 12|Community 12]]
- [[_COMMUNITY_Community 13|Community 13]]
- [[_COMMUNITY_Community 14|Community 14]]
- [[_COMMUNITY_Community 15|Community 15]]
- [[_COMMUNITY_Community 16|Community 16]]
- [[_COMMUNITY_Community 17|Community 17]]
- [[_COMMUNITY_Community 18|Community 18]]
- [[_COMMUNITY_Community 19|Community 19]]
- [[_COMMUNITY_Community 20|Community 20]]
- [[_COMMUNITY_Community 21|Community 21]]
- [[_COMMUNITY_Community 22|Community 22]]
- [[_COMMUNITY_Community 23|Community 23]]
- [[_COMMUNITY_Community 24|Community 24]]
- [[_COMMUNITY_Community 25|Community 25]]
- [[_COMMUNITY_Community 26|Community 26]]
- [[_COMMUNITY_Community 27|Community 27]]
- [[_COMMUNITY_Community 28|Community 28]]
- [[_COMMUNITY_Community 29|Community 29]]
- [[_COMMUNITY_Community 30|Community 30]]
- [[_COMMUNITY_Community 31|Community 31]]
- [[_COMMUNITY_Community 32|Community 32]]
- [[_COMMUNITY_Community 33|Community 33]]
- [[_COMMUNITY_Community 35|Community 35]]
- [[_COMMUNITY_Community 40|Community 40]]
- [[_COMMUNITY_Community 43|Community 43]]
- [[_COMMUNITY_Community 52|Community 52]]
- [[_COMMUNITY_Community 53|Community 53]]
- [[_COMMUNITY_Community 54|Community 54]]
- [[_COMMUNITY_Community 55|Community 55]]

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

### Community 0 - "Community 0"
Cohesion: 0.05
Nodes (26): paginate(), GetShipmentProvidersRequest, HasBody, HasFormBody, GetBrandByMaxIdRequest, GetBrandByPagesRequest, GetProductItemsRequest, Request (+18 more)

### Community 1 - "Community 1"
Cohesion: 0.06
Nodes (39): graphify Skill, Part A: AST Structural Extraction, Extraction Cache (Step B0), Fast Path (Existing Graph Query), Gemini Backend for Semantic Extraction, graphify Full Pipeline, Honesty Rules, Part C: Merge AST + Semantic Extraction (+31 more)

### Community 2 - "Community 2"
Cohesion: 0.07
Nodes (13): CarbonInterface, GetTransactionsPayload, Transaction, GetTransactionsPayload, GetOrdersPayload, FinanceApi, GetReversalsPayload, self (+5 more)

### Community 3 - "Community 3"
Cohesion: 0.10
Nodes (14): GetOrdersPayload, GetReversalsPayload, FulfillmentApi, OrdersApi, ReturnAndRefundApi, SellerApi, SystemApi, static (+6 more)

### Community 4 - "Community 4"
Cohesion: 0.07
Nodes (28): autoload, psr-4, config, optimize-autoloader, preferred-install, sort-packages, description, extra (+20 more)

### Community 5 - "Community 5"
Cohesion: 0.08
Nodes (9): GetReversalsRequest, Reversal, ReversalCollection, ReversalLine, self, self, self, Method (+1 more)

### Community 6 - "Community 6"
Cohesion: 0.12
Nodes (14): Cacheable, cacheKey(), resolveCacheDriver(), Connector, Driver, HasCaching, HasRateLimits, HasRetries (+6 more)

### Community 7 - "Community 7"
Cohesion: 0.11
Nodes (8): GetMultipleOrderItemsRequest, GetOrderItemsRequest, OrderItem, self, Method, Response, Method, Response

### Community 8 - "Community 8"
Cohesion: 0.11
Nodes (7): GetSellerRequest, Seller, self, self, Method, Response, ApiValueParser

### Community 9 - "Community 9"
Cohesion: 0.11
Nodes (7): Address, GetOrderRequest, Order, self, self, Method, Response

### Community 10 - "Community 10"
Cohesion: 0.12
Nodes (6): GetPayoutsRequest, PayoutStatus, PayoutStatusCollection, self, Method, Response

### Community 11 - "Community 11"
Cohesion: 0.17
Nodes (8): FinanceApi, FulfillmentApi, OrdersApi, ProductV2Api, ReturnAndRefundApi, SellerApi, Miravia, SystemApi

### Community 12 - "Community 12"
Cohesion: 0.21
Nodes (7): GetProductPayload, ProductCollection, GetProductRequest, ProductV2Api, Method, Response, Response

### Community 13 - "Community 13"
Cohesion: 0.20
Nodes (5): GetProductsPayload, GetProductsRequest, ProductApi, Method, Response

### Community 14 - "Community 14"
Cohesion: 0.16
Nodes (5): GetTransactionsRequest, TransactionCollection, self, Method, Response

### Community 15 - "Community 15"
Cohesion: 0.16
Nodes (5): GetOrdersRequest, OrderCollection, self, Method, Response

### Community 16 - "Community 16"
Cohesion: 0.17
Nodes (4): ShipmentProvider, ShipmentProviderCollection, self, self

### Community 17 - "Community 17"
Cohesion: 0.26
Nodes (5): JsonResponse, Responsable, SaloonResponse, Request, Response

### Community 18 - "Community 18"
Cohesion: 0.17
Nodes (4): Warehouse, WarehouseCollection, self, self

### Community 19 - "Community 19"
Cohesion: 0.24
Nodes (4): Arrayable, Product, ProductCollection, self

### Community 20 - "Community 20"
Cohesion: 0.20
Nodes (4): ProductVariant, self, self, TextSanitizer

### Community 21 - "Community 21"
Cohesion: 0.29
Nodes (8): getLimiterPrefixUsing(), handleTooManyAttempts(), resolveLimits(), resolveRateLimitStore(), Limit, RateLimitStore, Closure, Request

### Community 23 - "Community 23"
Cohesion: 0.43
Nodes (3): SignRequest, RequestMiddleware, PendingRequest

### Community 24 - "Community 24"
Cohesion: 0.32
Nodes (3): GetCategoryTreeRequest, Method, Response

### Community 25 - "Community 25"
Cohesion: 0.43
Nodes (6): handleRetry(), handleRetryUsing(), FatalRequestException, RequestException, Closure, Request

### Community 26 - "Community 26"
Cohesion: 0.47
Nodes (3): Authenticator, MiraviaAuthenticator, PendingRequest

## Knowledge Gaps
- **80 isolated node(s):** `$schema`, `name`, `type`, `description`, `keywords` (+75 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **15 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `CarbonInterface` connect `Community 2` to `Community 5`, `Community 7`, `Community 9`, `Community 10`, `Community 19`, `Community 22`, `Community 28`?**
  _High betweenness centrality (0.135) - this node is a cross-community bridge._
- **Why does `Resource` connect `Community 3` to `Community 2`, `Community 12`, `Community 13`?**
  _High betweenness centrality (0.088) - this node is a cross-community bridge._
- **What connects `$schema`, `name`, `type` to the rest of the system?**
  _84 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Community 0` be split into smaller, more focused modules?**
  _Cohesion score 0.05137844611528822 - nodes in this community are weakly interconnected._
- **Should `Community 1` be split into smaller, more focused modules?**
  _Cohesion score 0.059379217273954114 - nodes in this community are weakly interconnected._
- **Should `Community 2` be split into smaller, more focused modules?**
  _Cohesion score 0.07386363636363637 - nodes in this community are weakly interconnected._
- **Should `Community 3` be split into smaller, more focused modules?**
  _Cohesion score 0.0967741935483871 - nodes in this community are weakly interconnected._