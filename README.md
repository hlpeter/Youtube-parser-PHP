# Youtube parser PHP

Simple PHP library for extracting information from Youtube URLs. It works with
standard, shortened and embedded links and can return the video ID, start time or
playlist identifier.

## Installation

Install via composer:

```bash
composer require youtube/parser-php
```

## Usage

Create an instance of `Youtube` with the URL and call one of the helper methods.

### Validate URL

```php
$yt = new Youtube('https://www.youtube.com/watch?v=ef-4Bv5Ng0w');
var_dump($yt->valid()); // true

$invalid = new Youtube('https://www.example.com/watch?v=ef-4Bv5Ng0w');
var_dump($invalid->valid()); // false
```

### Get video ID

```php
$yt = new Youtube('https://youtu.be/ef-4Bv5Ng0w?list=RDQMKKCg_1xxtsQ');
echo $yt->get_id(); // ef-4Bv5Ng0w
```

### Get start time

```php
$yt = new Youtube('https://www.youtube.com/watch?v=ef-4Bv5Ng0w&t=22');
echo $yt->get_time(); // 22
```

### Get playlist ID

```php
$yt = new Youtube('https://www.youtube.com/watch?v=ef-4Bv5Ng0w&list=RDQMKKCg_1xxtsQ');
echo $yt->get_list(); // RDQMKKCg_1xxtsQ
```
