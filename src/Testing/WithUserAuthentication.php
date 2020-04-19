<?php


namespace YlsIdeas\LaravelAdditions\Testing;

use Illuminate\Foundation\Testing\TestCase;

/**
 * @mixin TestCase
 */
trait WithUserAuthentication
{
    use WithApplicationTraitHooks;

    protected $user;

    /**
     * @afterAppCreated
     */
    public function setUpNewUser()
    {
        $this->user = factory($this->getUserClass())
            ->states($this->getUserStates())
            ->create($this->getUserProperties());
    }

    public function actingAsUser()
    {
        $this->actingAs($this->user);

        return $this;
    }

    public function actingAsSanctumUser($scopes = [])
    {
        if (class_exists('\Laravel\Sanctum\Sanctum')) {
            \Laravel\Sanctum\Sanctum::actingAs($this->user, $scopes);
        } else {
            throw new \BadMethodCallException('This method requires the Laravel Sanctum package installed.');
        }

        return $this;
    }

    public function actingAsPassport($scopes = [])
    {
        if (class_exists('\Laravel\Passport\Passport')) {
            \Laravel\Passport\Passport::actingAs($this->user, $scopes);
        } else {
            throw new \BadMethodCallException('This method requires the Laravel Passport package installed.');
        }

        return $this;
    }

    protected function getUserClass()
    {
        return '\App\User::class';
    }

    protected function getUserStates()
    {
        return [];
    }

    protected function getUserProperties()
    {
        return [];
    }
}
