<p align="center">
  <a href="https://github.com/matchish/laravel-scout-elasticsearch">
    <img alt="Scout ElasticSearch" src="docs/banner.svg" >
  </a>

  <p align="center">
    <a href="https://travis-ci.org/matchish/laravel-scout-elasticsearch"><img src="https://travis-ci.com/matchish/laravel-scout-elasticsearch.svg?token=BygWG5QtD24PK5xsCgKE&branch=master" alt="Build Status"></img></a>
    <a href="https://scrutinizer-ci.com/g/matchish/laravel-scout-elasticsearch"><img src="https://img.shields.io/scrutinizer/g/matchish/laravel-scout-elasticsearch.svg" alt="Quality Score"></img></a>
    <a href="https://scrutinizer-ci.com/g/matchish/laravel-scout-elasticsearch"><img src="https://scrutinizer-ci.com/g/matchish/laravel-scout-elasticsearch/badges/coverage.png?b=master" alt="Coverage"></img></a>
    <a href="https://packagist.org/packages/matchish/laravel-scout-elasticsearch"><img src="https://poser.pugx.org/matchish/laravel-scout-elasticsearch/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/matchish/laravel-scout-elasticsearch"><img src="https://poser.pugx.org/matchish/laravel-scout-elasticsearch/v/stable.svg" alt="Latest Version"></a>
    <a href="https://packagist.org/packages/matchish/laravel-scout-elasticsearch"><img src="https://poser.pugx.org/matchish/laravel-scout-elasticsearch/license.svg" alt="License"></a>
  </p>
</p>

The package provides the perfect starting point to integrate
ElasticSearch into your Laravel application. It is carefully crafted to simplify the usage
of ElasticSearch within the [Laravel Framework](https://laravel.com).

It’s built on top of the latest release of [Laravel Scout](https://laravel.com/docs/scout), the official Laravel search
package. Using this package, you are free to take advantage of all of Laravel Scout’s
great features, and at the same time leverage the complete set of ElasticSearch’s search experience.

If you need any help, [stack overflow](https://stackoverflow.com/questions/tagged/laravel-scout%20laravel%20elasticsearch) is the preffered and recommended way to ask support questions.

## :two_hearts: Features

- [**Zero downtime** reimports]() - it’s a breeze to import data in production.
- Bulk indexing.
- A fully configurable mapping for each model.
- Full power of ElasticSearch in your queries

## :warning: Requirements

- PHP version >= 7.1.3
- Laravel Framework version >= 5.6
- Elasticsearch version >= 6

## :rocket: Installation

Use composer to install the package:

`composer require matchish/laravel-scout-elasticsearch`

## :bulb: Usage

> **Note:** This package adds functionalities to [Laravel Scout](https://github.com/laravel/scout), and for this reason, we encourage you to **read the Scout documentation first**. Documentation for Scout can be found on the [Laravel website](https://github.com/laravel/scout).

### Index [settings](https://www.elastic.co/guide/en/elasticsearch/reference/current/indices-create-index.html#create-index-settings) and [mappings](https://www.elastic.co/guide/en/elasticsearch/reference/current/indices-create-index.html#mappings)
It is very important to define the mapping when we create an index — an inappropriate preliminary definition and mapping may result in the wrong search results.

To define mappings or settings for index, set config with right value. 

For example if method `searchableAs` return 
`products` string

Config key for mappings should be  
`elasticsearch.indices.mappings.products`  
Or you you can specify default mappings with config key 
`elasticsearch.indices.mappings.default`

Same way you can define settings

For index `products` it will be  
`elasticsearch.indices.settigs.products`  

And for default settings  
`elasticsearch.indices.settigs.default
`
### Zero downtime reimports
While working in production, to keep your existing search experience available while reimporting your data, you also can use `scout:import` Artisan command:  

`php artisan scout:import`

The command create new temporary index, import all models to it, and then switch to the index and remove old index.

### Search

To be fully compatible with original scout package, this package don't add new methods.  
So how we can build complex queries?
There is two ways.   
By default when you pass query to `search` method the engine builds [query_string](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-query-string-query.html) query, so you can build queries like this

`Product::search('title:this OR description:this) AND (title:that OR description:that')`

If it's not enough in your case you can pass callback to query builder

`Product::search('zonga', function($client, $body) {  
    //... build your fancy query
    $client->search(['index' => 'products', 'body' => $body->toArray()]);
})`  

`$client` here is `\ElasticSearch\Client` object from [`elastic/elasticsearch-php`](https://github.com/elastic/elasticsearch-php) package
  

## :free: License
Scout ElasticSearch is an open-sourced software licensed under the [MIT license](LICENSE.md).
