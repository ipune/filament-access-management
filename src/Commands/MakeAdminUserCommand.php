<?php

namespace SolutionForest\FilamentAccessManagement\Commands;

use Filament\Facades\Filament;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\SessionGuard;
use Illuminate\Console\Command;
use SolutionForest\FilamentAccessManagement\FilamentAccessManagement;
use SolutionForest\FilamentAccessManagement\Support\Utils;

class MakeAdminUserCommand extends Command
{
    protected $signature = "filament-access-management:admin-user";

    public $description = 'Creates Filament Admin User';

    public function handle(): int
    {
        /** @var SessionGuard $auth */
        $auth = Filament::auth();

        /** @var EloquentUserProvider $userProvider */
        $userProvider = $auth->getProvider();

        if (Utils::getRoleModel()::whereName(Utils::getAdminRoleName())->doesntExist()) {
            FilamentAccessManagement::createAdminRole();
        }

        // if (Utils::isFilamentUserRoleEnabled() && Utils::getRoleModel()::whereName(Utils::getFilamentUserRoleName())->doesntExist()) {
        //     FilamentShield::createRole(isSuperAdmin: false);
        // }

        // if ($this->option('user')) {
        //     $this->superAdmin = $userProvider->getModel()::findOrFail($this->option('user'));
        // } elseif ($userProvider->getModel()::count() === 1) {
        //     $this->superAdmin = $userProvider->getModel()::first();
        // } elseif ($userProvider->getModel()::count() > 1) {
        //     $this->table(
        //         ['ID', 'Name', 'Email', 'Roles'],
        //         $userProvider->getModel()::with('roles')->get()->map(function ($user) {
        //             return [
        //                 'id' => $user->id,
        //                 'name' => $user->name,
        //                 'email' => $user->email,
        //                 'roles' => implode(',', $user->roles->pluck('name')->toArray()),
        //             ];
        //         })
        //     );

        //     $superAdminId = $this->ask('Please provide the `UserID` to be set as `super_admin`');

        //     $this->superAdmin = $userProvider->getModel()::findOrFail($superAdminId);
        // } else {
        //     $this->superAdmin = $userProvider->getModel()::create([
        //         'name' => $this->validateInput(fn () => $this->ask('Name'), 'name', ['required']),
        //         'email' => $this->validateInput(fn () => $this->ask('Email address'), 'email', ['required', 'email', 'unique:'.$userProvider->getModel()]),
        //         'password' => Hash::make($this->validateInput(fn () => $this->secret('Password'), 'password', ['required', 'min:8'])),
        //     ]);
        // }

        // $this->superAdmin->assignRole(Utils::getSuperAdminName());

        // if (Utils::isFilamentUserRoleEnabled()) {
        //     $this->superAdmin->assignRole(Utils::getFilamentUserRoleName());
        // }

        // $loginUrl = route('filament.auth.login');
        // $this->info("Success! {$this->superAdmin->email} may now log in at {$loginUrl}.");

        return self::SUCCESS;
    }
}
