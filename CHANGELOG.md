# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.9.0] - 2026-05-31

### Added

- The `Formatter` subclasses expose the formatting codes by `getColorCodes()` & `getFormattingCodes()`
- Rector for PHP upgrades

### Changed

- PHP 8.4 or higher is required
- `HtmlFormatter` requires the `MinecraftType` in the constructor
- `HtmlFormatter` is able to format `MinecraftType::Java` (`MinecraftType::Bedrock` is still wip)
- Updated docker config
  - changed `WORKDIR` vom `/opt` to `/app`
  - changed composer home directory vom `/tmp/.composer` to `/app/.composer` (persists on the host in this project)
- Updated docker compose config
- Updated composer dependencies
  - Updated dev libraries to the lastest version
  - added `symfony/var-dumper`
- GrumPHP config update
- PHPStan also checks `/tests`
