# Proxx game business logic on PHP
Try original game [here](https://proxx.app/) and find rules

# Run
## Init composer to get dependencies

Create auth.json
```shell
cp ./auth.example.json ./auth.json
```

Add [github token](https://github.com/settings/tokens)
```json
{
    "github-oauth": {
        "github.com": "ghp_***"
    }
}

```

## Run via Docker
```shell
docker-compose up -d
```
Default cmd for the container will run unit tests from `./tests` folder that covers all domain logic.
Check container's log then.

```shell
docker-compose logs app
```

example output:
```shell
proxx  | PHPUnit 9.5.26 by Sebastian Bergmann and contributors.
proxx  | 
proxx  | ...................                                               19 / 19 (100%)
proxx  | 
proxx  | Time: 00:00.129, Memory: 6.00 MB
proxx  | 
proxx  | OK (19 tests, 166 assertions)
```