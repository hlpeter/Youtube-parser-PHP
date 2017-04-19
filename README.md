# Youtube parser PHP


Check Valid URLs (youtube.com, youtu.be or youtube-nocookie.com)
```php
$youtube1 = new Youtube("https://www.youtube.com/watch?v=ef-4Bv5Ng0w");
echo $youtube1->valid();  // return true

$youtube2 = new Youtube("https://www.example.com/watch?v=ef-4Bv5Ng0w");
echo $youtube2->valid();  // return false
```

Get video id from URL
```php
$youtube3 = new Youtube("https://www.youtube.com/watch?v=ef-4Bv5Ng0w&list=RDQMKKCg_1xxtsQ");
echo $youtube3->get_id();  // return ef-4Bv5Ng0w

// Tiny url
$youtube4 = new Youtube("https://youtu.be/ef-4Bv5Ng0w?list=RDQMKKCg_1xxtsQ");
echo $youtube4->get_id();  // return ef-4Bv5Ng0w

// Embed
$youtube5 = new Youtube("https://www.youtube-nocookie.com/embed/ef-4Bv5Ng0w?list=RDQMKKCg_1xxtsQ");
echo $youtube5->get_id();  // return ef-4Bv5Ng0w
```

Get time from URL
```php
$youtube6 = new Youtube("https://www.youtube.com/watch?v=ef-4Bv5Ng0w&list=RDQMKKCg_1xxtsQ&t=22");
echo $youtube6->get_time();  // return 22

// From fragment #t=22
$youtube6 = new Youtube("https://www.youtube.com/watch?v=ef-4Bv5Ng0w&list=RDQMKKCg_1xxtsQ#t=22");
echo $youtube6->get_time();  // return 22

$youtube7 = new Youtube("https://www.youtube.com/watch?v=ef-4Bv5Ng0w&list=RDQMKKCg_1xxtsQ");
echo $youtube7->get_time();  // return null
```

Get play list
```php
$youtube8 = new Youtube("https://youtu.be/ef-4Bv5Ng0w?list=RDQMKKCg_1xxtsQ#t=22");
echo $youtube8->get_list();  // return RDQMKKCg_1xxtsQ
```
