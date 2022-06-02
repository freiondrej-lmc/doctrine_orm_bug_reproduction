# Doctrine orm left join bug reproduction

Thank you for taking the time to investigate [my bug](https://github.com/doctrine/orm/issues/9807) reproduction!

Please do the following:

```shell
make dev-build
make dev-start
make sh
bin/console doctrine:migrations:migrate # if missing symfony/runtime is reported, just wait a couple of seconds, the entrypoint still doing its job
bin/console app:create-test-data
```

Now the tests:

```shell
bin/console app:test:successful
# outputs correctly one row - entity Other named Test 1
bin/console app:test:failing
# should output one row - entity Other named Test 2 - but outputs nothing
```

If the `leftJoin()` in `\App\Command\TestCommandTrait::preloadOthers()` is changed to `innerJoin()`, it works as expected.

The reason is in `\Doctrine\ORM\Internal\Hydration\ObjectHydrator::hydrateRowData()` on the line `if (isset($this->existingCollections[$collKey])) {` :

In the failing scenario, the **if** is evaluated as true and the code then continues to the line `unset($this->resultPointers[$dqlAlias]);`.

For the successful test scenario, the **if** is evaluated as false and the code proceeds to `$element = $this->getEntity($data, $dqlAlias);`, even though the next `hydrateRowData()` call receives the proper row data for "Test 2"
in `$rowData = $this->gatherRowData($row, $id, $nonemptyComponents);`
