
# Simple Action

## _Lightweight action classes for Laravel_

### Usage

#### CreateUserData.php

```php
namespace App\Actions\ActionData\User;

use PharkasBence\SimpleAction\AbstractActionData;

class CreateUserData extends AbstractActionData
{
    protected string $email;
    protected string $username;
    protected string $password;
    protected ?string $phoneNumber;

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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
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
        $passwordHash = Hash::make($data->getPassword());
        
        return User::create([
            'email' => $data->getEmail(),
            'password' => $passwordHash,
            'username' => $data->getUsername(),
            'phone_number' => $data->getPhoneNumber(),
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
