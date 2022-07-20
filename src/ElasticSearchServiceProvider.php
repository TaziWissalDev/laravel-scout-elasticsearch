<?php

declare(strict_types=1);

namespace Matchish\ScoutElasticSearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Matchish\ScoutElasticSearch\ElasticSearch\EloquentHitsIteratorAggregate;
use Matchish\ScoutElasticSearch\ElasticSearch\HitsIteratorAggregate;
use Aws\ElasticsearchService\ElasticsearchPhpHandler;
use Aws\Credentials\CredentialProvider;
use Matchish\ScoutElasticSearch\ElasticSearch\Config\Config as esConfig;



final class ElasticSearchServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/elasticsearch.php', 'elasticsearch');

        $this->app->bind(Client::class, function () {

            $aws_enabled = Config::get('elasticscout.connection.hosts.0.aws_enable');
            $hosts = [config('elasticsearch.host')];

            $clientBuilder = ClientBuilder::create();

            if ($aws_enabled) {
                $hosts = [Config::get('elasticscout.connection.hosts.0.host') . ':' . Config::get('elasticscout.connection.hosts.0.port')];
                $provider = CredentialProvider::defaultProvider();
                $handler = new ElasticsearchPhpHandler('eu-west-3', $provider);
                $clientBuilder->setHandler($handler);
                $clientBuilder->setHosts($hosts);
            }

            if ($user = esConfig::user()) {
                $clientBuilder->setBasicAuthentication($user, esConfig::password());
            }

            if ($cloudId = esConfig::elasticCloudId()) {
                $clientBuilder->setElasticCloudId($cloudId)
                    ->setApiKey(esConfig::apiKey());
            }


            return $clientBuilder->build();
        });

        $this->app->bind(
            HitsIteratorAggregate::class,
            EloquentHitsIteratorAggregate::class
        );
    }

    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/elasticsearch.php' => config_path('elasticsearch.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../config/elasticscout.php' => config_path('elasticscout.php'),
        ], 'config');
    }

    /**
     * {@inheritdoc}
     */
    public function provides(): array
    {
        return [Client::class];
    }
}
