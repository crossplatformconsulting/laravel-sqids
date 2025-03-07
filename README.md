<p align="center"><img width="400" src="./art/logo.svg" alt="Laravel Sqids Logo"></p>

# Laravel Sqids

Laravel Sqids (pronounced "squids") allows you to easily generate Stripe/YouTube looking IDs for your Laravel models.
These IDs are short and are guaranteed to be Collision free.

For more information on Sqids, we recommend checking out the official Sqids (formerly Hashids) website: [https://sqids.org](https://sqids.org).

## Installation

This is a semi-private package, so you will need to add the following to your `composer.json` file:

```shell
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/crossplatformconsulting/laravel-sqids.git"
    }
]
```

To get started, install Laravel Sqids via the Composer package manager:

```shell
composer require crossplatform/laravel-sqids
```

Next, you should publish the Sqids configuration file using the `vendor:publish` artisan command. The `sqids`
configuration file will be placed in your applications `config` directory:

```shell
php artisan vendor:publish --provider="Crossplatform\Sqids\SqidsServiceProvider"
```

## Usage

### Using Sqids

To use Laravel Sqids, simply add the `Crossplatform\Sqids\Concerns\HasSqids` trait to your model:

```php
use Crossplatform\Sqids\Concerns\HasSqids;

class User extends Authenticatable
{
    use HasSqids;
}
```

You will now be able to access the Sqid for the model, by calling the `sqid` attribute:

```php
$user = User::first();

$sqid = $user->sqid; // use_A3EyoEb2TO
```

The result of `$sqid` will be encoded value of the models primary key along with the model prefix.

> [!Tip]
> Only integers can be encoded, and therefore we recommend using this package in conjunction with auto
incrementing IDs.

If you would like to set a custom prefix for the model, you can override it by setting a `$sqidPrefix` property value
on your model like so:

```php
use Crossplatform\Sqids\Concerns\HasSqids;

class User extends Authenticatable
{
    use HasSqids;
    
    protected string $sqidPrefix = 'user';
}

$user = User::first();
$sqid = $user->sqid; // user_A3EyoEb2TO
```

### Builder Mixins

Laravel Sqids provides a number of Eloquent builder mixins to make working with Sqids seamless.

#### Find by Sqid

To find a model by a given Sqid, you can use the `findBySqid` method:

```php
$user = User::findBySqid('use_A3EyoEb2TO');
```

If the model doesn't exist, `null` will be returned. However, if you would like to throw an exception, you can use
the `findBySqidOrFail` method instead which will throw a `ModelNotFoundException` when a model can't be found:

```php
$user = User::findBySqidOrFail('use_invalid');
```

#### Where Sqid

To add a where clause to your query, you can use the `whereSqid` method:

```php
$users = User::query()
    ->whereSqid('use_A3EyoEb2TO')
    ->get();
```

This will retrieve all users where the Sqid/primary key matches the given value.

#### Where Sqid in

To get all models where the Sqid is in a given array, you can use the `whereSqidIn` method:

```php
$users = User::query()
    ->whereSqidIn('id', ['use_A3EyoEb2TO'])
    ->get();
```

This will return all users where the `id` is in the array of decoded Sqids.

#### Where Sqid not in

To get all models where the Sqid is not in a given array, you can use the `whereSqidNotIn` method:

```php
$users = User::query()
    ->whereSqidNotIn('id', ['use_A3EyoEb2TO'])
    ->get();
```

This will return all users where the `id` is not in the array of decoded Sqids.

### Route model binding

Laravel Sqids supports route model binding out of the box. Simply create a route as you normally would and we'll take
care of the rest:

```php
// GET /users/use_A3EyoEb2TO
Route::get('users/{user}', function (User $user) {
    return "Hello $user->name";
});
```

### Finding a model from a Sqid

One of the most powerful features of Laravel Sqids is being able to resolve a model instance from a given Sqid. This
could be incredibly powerful when searching models across your application. 

```php
use Crossplatform\Sqids\Model;

$model = Model::find('use_A3EyoEb2TO');
```

When we run the following, `$user` will be an instance of the `User` model for the given Sqid. If no model could be
found, then `null` will be returned.

if you would like to throw an exception instead, you can use the `findOrFail` method which will throw an instance of
the `ModelNotFoundException`:

```php
use Crossplatform\Sqids\Model;

$model = Model::findOrFail('use_A3EyoEb2TO');
```

> [!IMPORTANT]
> In order to use this feature, you must use prefixes for your Sqids.

## Credits

- [Ben Sherred](https://github.com/bensherred)

## License

Laravel Sqids is open-sourced software licensed under the [MIT license](LICENSE).
