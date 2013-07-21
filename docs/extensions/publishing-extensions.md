### Publishing Extensions

- [Introduction](#introduction)
- [Public Extensions](#public-extensions)
- [Private Extensions](#private-extensions)

<a name="introduction"></a>
#### Introduction

Because extensions are actually composer packages you can easily distribute them through [packagist.org](https://packagist.org). Or if you want your extension to be privately distributed you could use, for example, [satis](https://github.com/composer/satis).

<a name="public-extensions"></a>
#### Public Extensions

Publishing public extensions can through a lot of mediums, the foremost being public Github repositories. By any means, every extension requires a `composer.json` file. [Dayle Rees](https://twitter.com/daylerees) has written [a great article about using Composer for your packages](http://daylerees.com/composer-primer). It will get you started on how you can format your composer.json file.

For the full requirements for a Platform 2 extension see the [Basic Usage](/platform2/extensions#requirements) chapter.

After creating your extension you can push it to Github and publish it on [packagist.org](https://packagist.org).

<a name="private-extensions"></a>
#### Private Extensions

There are several ways to provide private extensions through Composer but we recommend the use of Satis. Satis is a static composer repository generator. It's basically your very own version of [packagist.org](https://packagist.org).

The good folks of Composer already wrote the documentation on how to set it up, check it out [here](http://getcomposer.org/doc/articles/handling-private-packages-with-satis.md).

