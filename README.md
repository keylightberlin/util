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

TODO

## Entity traits

## Emails

## EntityManager

## Twig extensions
