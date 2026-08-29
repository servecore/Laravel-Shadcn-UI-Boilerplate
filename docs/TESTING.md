# Testing

## Running Tests

```bash
# Run all tests
php artisan test

# Run with compact output
php artisan test --compact

# Run specific test suite
php artisan test --testsuite=Feature

# Run specific test file
php artisan test tests/Feature/Auth/LoginTest.php

# Run specific test method
php artisan test --filter=test_user_can_login

# Run with PHPUnit directly
vendor/bin/phpunit
```

## Test Structure

```
tests/
├── TestCase.php                    # Base test case (disables CSRF)
├── Feature/
│   ├── ExampleTest.php             # Basic smoke test
│   ├── DashboardTest.php           # Dashboard access tests
│   └── Auth/
│       ├── LoginTest.php           # Login flow tests
│       ├── RegisterTest.php        # Registration tests
│       ├── LogoutTest.php          # Logout tests
│       └── PasswordResetTest.php   # Password reset tests
└── Unit/
    └── ExampleTest.php             # Basic unit test
```

## Test Environment

The `phpunit.xml` configures a separate testing environment:

- **Database:** SQLite in-memory (`:memory:`)
- **Cache:** Array driver
- **Queue:** Sync driver
- **Session:** Array driver
- **Mail:** Array driver

## Writing Tests

### Feature Test

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }
}
```

### Using Factories

```php
// Create a user
$user = User::factory()->create();

// Create with specific attributes
$user = User::factory()->create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
]);
```

### Testing Authentication

```php
// Act as user
$this->actingAs($user);

// Assert authentication status
$this->assertAuthenticatedAs($user);
$this->assertGuest();
```

### Testing Validation

```php
$response = $this->post(route('login.store'), [
    'email' => '',
    'password' => '',
]);

$response->assertSessionHasErrors('email');
```

## Test Coverage

Current tests cover:

- ✅ Login form display
- ✅ Login with valid/invalid credentials
- ✅ Registration form display
- ✅ Registration with validation
- ✅ Logout functionality
- ✅ Password reset form
- ✅ Dashboard access (authenticated/guest)
- ✅ Basic application response
