# Upgrade

## 0.x

```sql
ALTER TABLE ca_categories ADD syliusCode VARCHAR(255) DEFAULT NULL;
UPDATE ca_categories SET syliusCode = category_key WHERE syliusId IS NOT NULL AND category_key IS NOT NULL;
UPDATE ca_categories SET category_key = NULL WHERE syliusId IS NOT NULL;
```

If you have used the category key for sylius taxons in sulu you have to use `syliusCode` property in the future.
