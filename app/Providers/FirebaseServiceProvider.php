<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
{
    $this->app->singleton('firebase', function ($app) {
    $firebaseCredentials = [
        'type' => 'service_account',
        'project_id' => 'faster-69b8c',
        'private_key_id' => '32aa56e09b5d2cf2339beb597e3fbf8f149f2892',
        'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDX1DGTjlG/1lbS\nsBbBeC6M2A2mccVIDcODLQ4RNq/ZJNe5TX+5vxaA8s3TDKhDQ41BInJ7Aw5nIFPs\nB9zNFN3bKMrKkXTvKl/hIAl2eABb6OedJGioH7JMb4QwuKYMirOW4WZ7AyMggY+/\nO72FDHS02ti744S3EDymzItZIX1e9tzYE5gDcF+K4qcEEOOwwaYkkuhZ4YgcuIIy\nvPfnrRSBiWR5RGey8cGyUclvGltSL8nFQq+BTnK0OfcotD+FPqpyVxI+EtEKxLdj\nUQhkCczmq3z0UApW0Kq2lmpMDq9L+xcyE3AUg5xZ/yXllfAj1ohLWqWObMre6CNJ\nBJdNGpnvAgMBAAECggEAIfj0zB5Q+t/WWc09lRAsT5+AgoxnpSBZf+U7JiApYjDc\n7f48wR71gAWiuqTu5WuVfppZUnNC30kPkgMTe9/cI2+n1WaQ9UaCbLwaETZGuYY5\n0u/qCLC4jt8s0Rh3jAOBzO7yLncUyTyWRQqLxIzB4BKPSVVA938hn5BpzMqrN85c\n0uAPtVPWLpNvpslAuNfT0QYFCn4MRX0BAE4+BCqg8W086pfp9BKGSZ0rY9vqQIXf\nKsNIl9sz88MpdwQas5pvNqu2N5Cjyd0ntJ/pzVbXDR+AN//1Y86/BC9Uewqq2IDr\n3J2LAAXileQxRAs3Ysz+N7jlaxKnwDjYq7GYpvoFpQKBgQDtjXf3u4xvjl1/GqLd\nm0vyP4tYM1/IM9TZB+jDfdDXlUFTa4iTJBEJ8A8IACdp8JzqhylH3wle27ZQ2gbx\nGJVZD2HfZg6USHFFI9ZrMReblM8cM4C3LgnH2N7AiGx7KpUm+ZgvOh6KTrMWCweS\nX/ihHkatUdGmoCAmlUU6MUhtswKBgQDoltvNi1K93ByCLwATRoDwxLXiDlmk69K8\nhTln06PWFUtJ0RD/mAs3BXB4mvgzgFndTbbI2zDelS5OHlRBlt3EdO5E9xcLHCl+\nI/FCElvc4zukoCF6QCmuB6khDxeIi/93nfUU4ZpGFczFgKsG0BI09yhl8RajxlMy\nRWZSomlc1QKBgQCHkzTDu1MkG9E6iF4pMcd/Y0rItNFWdlZk4wGyCK1XTISy8m1I\n5M2gqVQ60bOs37j+lNM3hJBZhfWgYT6S/N/Hq2LFV/68HDghKJnoJWV+0sf9JVux\nr+G/IAPJSFL5XE0xqEN1uKrTbqUA0JyqqoFAmwHlSwvnF/4hZxHSa2wVxwKBgH9F\n/eVN9er6xYbfXTUvAWO+4KBgpeE/QkPyyuTrxN1jLZ2pD5otgwWKrm7wrhzQgVw+\nKGVkvCswivQoWIbDnXrhWXjXlP55XKMv29cB4M7QcVS2Y1tYPPaELqJudbw8j4DP\nKMtSYG81gqYYsH274hqlnK+b632XCvOZUlKpmOo5AoGATJKtejILwr4WzCtAwGkq\nmBSWT9fTDLoMfWsERQktgajpr8KIOI94mLcShTI/0CNchyu8bZw7Am1vvyAV+vLH\nJeQbpNQ9KTAJITfoYIFXaFHuV6D7gKbLZ7A4Kx0tka8Eh90qL+VZaG+OnpBu+ZNi\nr1mq6F2mxXfwI3fRhk0KfG8=\n-----END PRIVATE KEY-----\n",
        'client_email' => 'firebase-adminsdk-spv9i@faster-69b8c.iam.gserviceaccount.com',
        'client_id' => '117023560086196827644',
        'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
        'token_uri' => 'https://oauth2.googleapis.com/token',
        'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
        'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-spv9i%40faster-69b8c.iam.gserviceaccount.com',
        'universe_domain' => 'googleapis.com'
    ];
    $serviceAccount = ServiceAccount::fromValue($firebaseCredentials);

    $firebase = (new Factory)
    ->withServiceAccount($serviceAccount);
    return $firebase;
   });
}

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
