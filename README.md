Next steps:
1. Edit tests/acceptance.suite.yml to set url of your application. Change PhpBrowser to WebDriver to enable browser testing
2. Edit tests/functional.suite.yml to enable a framework module. Remove this file if you don't use a framework
3. Create your first acceptance tests using codecept g:cest acceptance First
4. Write first test in tests/acceptance/FirstCest.php
5. Run tests using: codecept run


export PATH="$PATH:/srv/http/learning_shop/vendor/bin:/srv/http:/srv/http/learning_shop/bin"


after installing codeception with symfony


Some files may have been created or updated to configure your new packages.
Please review, edit and commit them: these files are yours.

                                                                                             
 Adding phpunit/phpunit as a dependency is discouraged in favor of Symfony's PHPUnit Bridge. 
                                                                                             

  * Instead:
    1. Remove it now: composer remove --dev phpunit/phpunit
    2. Use Symfony's bridge: composer require --dev phpunit
