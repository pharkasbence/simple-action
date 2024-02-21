
# Simple Action

## _Lightweight action classes for Laravel_

### Usage

#### CreateUserData.php

```php
namespace App\Actions\ActionData\User;

use PharkasBence\SimpleAction\AbstractActionData;
use PharkasBence\SimpleAction\TransformProperties;

class CreateUserData extends AbstractActionData
{
    use TransformProperties;

    public readonly int $email;
    public readonly string password;
    public readonly string $userName;
    public readonly string phoneNumber;
 
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->init();
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
            'username' => 'required|string',
            'phone_number' => 'string',
        ];
    }
    
    //optional
    protected function messages(): array
    {
        'password' => 'Password cannot be empty',
    }
}
```

CreateUser.php

```php
namespace App\Actions\User;

use Illuminate\Support\Facades\Hash;
use App\Actions\AbstractAction;
use App\Actions\ActionData\User\CreateUserData;
use App\Models\User;

class CreateUser extends AbstractAction
{
    public function __construct(/*  */) {}

    public function handle(CreateUserData $data): User
    {
        $passwordHash = Hash::make($data->password);
        
        return User::create([
            'email' => $data->email,
            'password' => $passwordHash,
            'username' => $data->userName,
            'phone_number' => $data->phoneNumber ?? null,
        ]);
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
        CreateUser::run(new CreateUserData($request->all()));
        
        // ...
    }
}

```

## License

MIT
