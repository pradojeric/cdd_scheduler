<?php

namespace App\Http\Livewire\Admin;

use Auth;
use Livewire\Component;

class ApiTokens extends Component
{
    public $isModalOpen;

    public $tokenName;
    public $ability;

    public function close()
    {
        $this->isModalOpen = false;
    }

    public function addToken()
    {
        $user = request()->user();

        $token = $user->createToken($this->tokenName, [$this->ability]);

        $user->plainTokens()->create([
            'token_id' => $token->accessToken->id,
            'plain_token' => $token->plainTextToken,
        ]);

        $this->isModalOpen = false;
    }

    public function render()
    {
        $plainTokens = Auth::user()->plainTokens;
        $tokens = Auth::user()->tokens;



        return view('livewire.admin.api-tokens', [
            'tokens' => Auth::user()->tokens,
            'plainTokens' => Auth::user()->plainTokens,
        ]);
    }
}
