## Distributing Extensions

If you'd like to distribute your extensions you can do so using [Composer](http://getcomposer.org/). Composer makes it easy to allow your extensions to be set as dependencies in Platform 3. They can easily be distributed through [packagist.org](https://packagist.org). Or if you want your extension to be privately distributed you could use, for example, [satis](https://github.com/composer/satis).

### Public Extensions

Distributing public extensions through Composer can be done in a lot of ways, the foremost being public Github repositories. By any means, every extension which is distributed through Composer requires a `composer.json` file. [Dayle Rees](https://twitter.com/daylerees) has written [a great article about using Composer for your packages](http://daylerees.com/composer-primer). It will get you started on how you can format your `composer.json` file.

For the full requirements for a Platform 3 extension see the [Extensions](#extensions) chapter.

After creating your extension you can push it to Github and publish it on [packagist.org](https://packagist.org).


### Private Extensions

There are several ways to provide private extensions through Composer but we recommend the use of Satis. Satis is a static composer repository generator. It's basically your very own version of [packagist.org](https://packagist.org).

The good folks of Composer already wrote the documentation on how to set it up, check it out [here](http://getcomposer.org/doc/articles/handling-private-packages-with-satis.md).
