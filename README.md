# minecraft-formatter

A library for translating the Minecraft formatting codes into another format.  
The official documentation can be found at https://minecraft.wiki/w/Formatting_codes.  

## Usage

```php
$formatter = new HtmlFormatter(type: MinecraftType::Java);
$result    = $formatter->format(text: $text);
```

## Contribute

In case you want to contribute to this project, a suitable PHP environment with docker is available.  

The following software must be installed:  

* [Docker](https://docs.docker.com/get-docker)
* [Docker Compose](https://docs.docker.com/compose/install)

Execute the following commands to use the Docker environment:  

```shell
docker-compose build
```

```shell
docker-compose run --rm minecraft-formatter bash
```

Congratulations, you are now using the PHP environment with Docker.  
Next, install some packages with composer.  
The packages are there to ensure the code quality to a certain level.  

```shell
composer install
```

An example to check our code.  

```shell
vendor/bin/grumphp run
```
