# Release Notes for Elastic Export treepodia.com

## v1.0.9 (2018-04-25)

### Changed
- The class FiltrationService is responsible for the filtration of all variations.
- Preview images updated.

## v1.0.8 (2018-02-16)

### Changed
- Updated plugin short description.

## v1.0.7 (2018-02-05)

### Fixed
- Images will now be exported in the right order.
- The free text fields 1 till 4 will be correctly exported again.

## v1.0.6 (2018-01-31)

### Behoben
- The SKU is now based on the item ID.
- CDATA will now be used for the XML tag "name".

## v1.0.5 (2018-01-15)

### Behoben
- The SKU is now based on the variation ID instead of the item ID.

## v1.0.4 (2017-06-30)

### Changed
- The logic of the generator was adjusted to improve the performance and the stability.
- The XML structure was updated.
- The whole category path will be exported, instead of the main category.

### Fixed
- The SKU will now be exported based on the variation ID, instead of item ID.

## v1.0.3 (2017-05-29)

### Changed
- The plugin Elastic Export is now required to use the plugin format TreepodiaCOM.

## v1.0.2 (2017-04-18)

### Fixed
- An issue was fixed which caused the plugin to fail at the build productive.

## v1.0.1 (2017-03-22)

### Fixed
- We now use a different value to get the image URLs for plugins working with elastic search.

## v1.0.0 (2017-03-10)
 
### Added
- Added initial plugin files