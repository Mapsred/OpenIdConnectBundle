#[WIP] OpenIDConnectBundle

The OpenIDConnectBundle adds OpenId connection in Symfony.

##Step 1

### Add OpenIDConnectBundle to your project

```bash
composer require maps_red/openid-connect-bundle
```

#### Enable the Bundle in the Kernel (< Symfony 4.0)
```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Maps_red\OpenIDConnectBundle(),
    );
}
```


### Import the routes.yaml

```yaml
# config/routes.yaml
app:
  resource: '@OpenIDConnectBundle/Resources/config/routing/routes.yaml'
```



### security.yaml (example)
```yaml
    security:
        providers:
            webservice:
                id: open_id_connect.user_provider
        encoders:
            Maps_red\OpenIDConnectBundle\Security\User\User: bcrypt
    
        firewalls:
            dev:
                pattern: ^/(_(profiler|wdt)|css|images|js)/
                security: false
            test:
                http_basic: ~
                pattern: ^/(_(profiler|wdt)|css|images|js)/
                security: false
            main:
                anonymous: false
                guard:
                    authenticators:
                        - open_id_connect.guard_anthenticator
    
        access_control:
            - { path: ^/login, role: IS_AUTHENTICATED_ANONYMOUSLY }
            - { path: ^/, role: ROLE_USER }
```