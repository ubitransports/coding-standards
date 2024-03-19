# Coding Standards

This repository is a toolkit including all PHP tools used for local development and the CI.

## How to
### Add a package
```sh
make composer-require args="PACKAGE"
```

### Update packages
All packages
```sh
make composer-update
```

Specific packages
```sh
make composer-update args="PACKAGE"
```

### CD
The gitflow must follow the naming in order to have a correct tag creation. The semantic will be updated according to the prefix of the branch: 
- feat/BRANCH_NAME : vx.X.x
- fix/BRANCH_NAME (or no prefix): vx.x.X

When merging into master branch, the CD is triggered and a new tag is created.

## Create your custom PHP CS fixers

A few examples:
* [https://tomasvotruba.com/blog/2017/07/24/how-to-write-custom-fixer-for-php-cs-fixer-24/](https://tomasvotruba.com/blog/2017/07/24/how-to-write-custom-fixer-for-php-cs-fixer-24/)
* [https://github.com/PedroTroller/PhpCSFixer-Custom-Fixers](https://github.com/PedroTroller/PhpCSFixer-Custom-Fixers)
