# Content Types

This bundle provides two content types to include products in your template.

1. Direct assignment single: `single_product_selection`
2. Direct assignment multiple: `product_selection`

## Single Product-Selection

Allows to select one product which is assigned to your document.

### Parameters

No parameters.

### Returns

The content-type returns a `ProductView` instance.

### Example

```xml
<property name="product" type="single_product_selection">
    <meta>
        <title lang="en">Product</title>
        <title lang="de">Produkt</title>
    </meta>
</property>
```

## Product-Selection

Allows to select products which are assigned to your document.

### Parameters

No parameters.

### Returns

The content-type returns an array of `ProductView` instances.

### Example

```xml
<property name="products" type="product_selection">
    <meta>
        <title lang="en">Products</title>
        <title lang="de">Produkte</title>
    </meta>
</property>
```
