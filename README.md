# Installation

Add the following part to you `composer.json`:

```
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/keylightberlin/util.git"
        }
    ]
```

Then, add the bundle to your requirements section in `composer.json`:

```
        "keylightberlin/util": "dev-master"
```

Now initialize the bundle by adding it to your `AppKernel.php`:

```
public function registerBundles()
    {
        $bundles = array(
            ...
            new KeylightUtilBundle\KeylightUtilBundle(),
            ...
        );
        
        ...
    }

```

# Basic usage

You can configure the following options in config.yml

keylight_util:
    email:
        sender_address: ~ 
    aws:
        s3_access_key_id: ~
        s3_secret_access_key: ~
        s3_bucket: ~
        s3_base_path: ~
        cloudfront_endpoint: ~
        
## Entity traits

## Emails

## EntityManager

## Twig extensions
