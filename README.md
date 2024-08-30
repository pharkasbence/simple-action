
# Simple Action

## _Lightweight action classes for Laravel_

### Usage

#### CreateUserData.php

```php
namespace App\Actions\ActionData\User;

use PharkasBence\SimpleAction\ActionData;

class CreateUserData extends ActionData
{
    use HydratesProperties;

    public readonly string $email;
    public readonly string $username;
    public readonly string $password;
    public readonly ?string $phoneNumber;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->hydrateProperties();
    }

    // optional
    protected function validationRules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'username' => 'required|string',
            'phone_number' => 'string',
        ];
    }
    
    // optional
    protected function validationMessages(): array
    {
        'password' => 'Password must be at least 6 characters in length',
    }
}
```

CreateUser.php

```php
namespace App\Actions\User;

use Illuminate\Support\Facades\Hash;
use App\Actions\Action;
use App\Actions\ActionData\User\CreateUserData;
use App\Models\User;

class CreateUser extends Action
{
    public function __construct(/*  */) {}

    public function handle(CreateUserData $data): User
    {
        $passwordHash = Hash::make($data->password);
        
        return User::create([
            'email' => $data->email,
            'password' => $passwordHash,
            'username' => $data->username,
            'phone_number' => $data->phoneNumber,
        ]);

        // data can also be extracted by calling $data->toArray()
    }
}
```

UserController.php

```php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Actions\User\CreateUser;
use App\Actions\ActionData\User\CreateUserData;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // request data fields need to be: email, username, password, phone_number
        CreateUser::run(new CreateUserData($request->all()));
        
        // ...
    }
}

```

## License

MIT
