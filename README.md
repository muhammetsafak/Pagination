# Pagination

PHP Sayfalama Sınıfı

[![Latest Stable Version](http://poser.pugx.org/muhammetsafak/php-pagination/v)](https://packagist.org/packages/muhammetsafak/php-pagination) [![Total Downloads](http://poser.pugx.org/muhammetsafak/php-pagination/downloads)](https://packagist.org/packages/muhammetsafak/php-pagination) [![Latest Unstable Version](http://poser.pugx.org/muhammetsafak/php-pagination/v/unstable)](https://packagist.org/packages/muhammetsafak/php-pagination) [![License](http://poser.pugx.org/muhammetsafak/php-pagination/license)](https://packagist.org/packages/muhammetsafak/php-pagination) [![PHP Version Require](http://poser.pugx.org/muhammetsafak/php-pagination/require/php)](https://packagist.org/packages/muhammetsafak/php-pagination)

## Kurulum

```
composer require muhammetsafak/php-pagination
```

## Yöntemler

### `__construct()`

Sınıfın kurucu metodudur.

```php
public function __construct(int $page, int $totalRow, int $perPageLimit = 10, string $linkTemplate = '?page={page}')
```

- `$page` : Geçerli sayfa
- `$totalRow` : Sayfalanacak toplam satır/içerik sayısı
- `$perPageLimit` : Sayfa başına listelenecek satır/içerik sayısı
- `$linkTemplate` : Sayfaların link şablonunu tanımlar.

### `getPage()`

Geçerli sayfayı döndürür.

```php
public function getPage(): int
```

### `getLimit()`

Sayfa başına gösterilen içerik/satır sayısını döndürür.

```php
public function getLimit(): int
```

### `getOffset()`

Geçerli sayfanın son satır/içerik sayısını döndürür.

```php
public function getOffset(): int
```

### `linkTemplate()`

Link şablonunu tanımlar.

```php
public function linkTemplate(string $template): self
```

### `setPerPageLimit()`

Sayfa başına gösterilen satır/içerik sayısını tanımlar.

```php
public function setPerPageLimit(int $perPageLimit = 10): self
```

### `setTotalRow()`

Sayfalanacak toplam satır/içerik sayısını tanımlar.

```php
public function setTotalRow(int $totalRow = 0): self
```

### `setHowDisplayedPage()`

Gösterilecek toplam sayfa sayısını tanımlar.

```php
public function setHowDisplayedPage(int $howDisplayedPage = 8): self
```

- `$howDisplayedPage` : Bir çift sayı.

### `getPagination()`

Sayfalama HTML'i oluşturabileceğiniz bir dizi döndürür.

```php
public function getPagination(): array
```

Dönecek dizi şuna benzer;

```php
array(
    array(
        'url' => 'http://example.com/page/1',
        'page => 1,
        'active' => false
    ),
    array(
        'url' => 'http://example.com/page/2',
        'page => 2,
        'active' => true
    ),
    array(
        'url' => 'http://example.com/page/3',
        'page => 3,
        'active' => false
    )
);
```

### `nextPage()`

Varsa sonraki sayfanın URL'sini içeren bir dizi döndürür. Yoksa `NULL` döndürür.

```php
public function nextPage(): array|null
```

Dönecek dizi şuna benzer;

```php
[
    'url'   => 'http://example.com/?page=4',
    'page'  => 4,
];
```

### `prevPage()`

Varsa önceki sayfanın URL'sini içeren bir dizi döndürür. Yoksa `NULL` döndürür.

```php
public function prevPage(): array|null
```

Dönecek dizi şuna benzer;

```php
[
    'url'   => 'http://example.com/?page=3',
    'page'  => 3,
];
```

### `showPagination()`

Bootstrap 5 için uyumlu bir pagination oluşturur ve döndürür.

```php
public function showPagination(array $configs = []): string
```

`$configs` dizisi aşağıdaki elemanlara sahip olabilir;

- `ul_class` : `ul` html etiketinin class niteliğine eklenecek dize.
- `li_class` : `li` html etiketinin class niteliğine eklenecek dize.
- `prev_display` : Önceki sayfa iteminin eklenip eklenmeyeceğini belirten mantıksal değer. Varsayılan `true`.
- `next_display` : Sonraki sayfa iteminin eklenip eklenmeyeceğini belirten mantıksal değer. Varsayılan `true`.
- `prev_li_class` : Önceki sayfa iteminin class niteliğine eklenecek dize.
- `next_li_class` : Sonraki sayfa iteminin class niteliğine eklenecek dize.
- `prev_text` : Önceki sayfa iteminde görünecek dize. Varsayılan `"Previous"`
- `next_text` : Sonraki sayfa iteminde görünecek dize. Varsayılan `"Next"`

## Kullanımı

```php
$pagination = new \MuhammetSafak\Pagination\Pagination(1, 100, 10, 'https://www.example.com/page/{page}');
```

## Lisans

Bu kütüphane [Muhammet ŞAFAK](https://www.muhammetsafak.com.tr) tarafından geliştirilip [MIT Lisansı](./LICENSE) ile birlikte dağıtılmaktadır.
