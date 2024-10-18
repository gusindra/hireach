<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class GenerateApiTokens extends Component
{
    public $userId;
    public $tokenName;
    public $permissions = [];
    public $availablePermissions = ['read', 'write', 'delete', 'update'];
    public $showingTokenModal = false;
    public $generatedToken;
    public $tokens;

    // New properties for editing permissions
    public $showingEditPermissionsModal = false;
    public $currentPermissions = [];
    public $selectedTokenId;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadTokens();
    }

    public function generateToken()
    {
        // Validate input
        $this->validate([
            'tokenName' => 'required|string|max:255',
            'permissions' => 'array',
        ]);

        $user = User::findOrFail($this->userId);
        $token = $user->createToken($this->tokenName, $this->permissions);
        $this->generatedToken = $token->plainTextToken;

        $this->showingTokenModal = true;
        $this->reset(['tokenName', 'permissions']);
        $this->loadTokens();
    }

    public function loadTokens()
    {
        $user = User::findOrFail($this->userId);
        $this->tokens = $user->tokens()->get();
    }

    public function deleteToken($tokenId)
    {
        $token = PersonalAccessToken::findOrFail($tokenId);
        $token->delete();

        $this->loadTokens();
        session()->flash('message', 'Token deleted successfully!');
    }

    public function editPermissions($tokenId)
    {
        $token = PersonalAccessToken::findOrFail($tokenId);
        $this->selectedTokenId = $tokenId;
        $this->currentPermissions = $token->abilities;

        $this->showingEditPermissionsModal = true;
    }

    public function closeEditPermissionsModal()
    {
        $this->showingEditPermissionsModal = false;
    }

    public function updatePermissions()
    {
        $token = PersonalAccessToken::findOrFail($this->selectedTokenId);
        $token->abilities = $this->currentPermissions;
        $token->save();

        $this->closeEditPermissionsModal();
        session()->flash('message', 'Permissions updated successfully!');
    }

    public function closeModal()
    {
        $this->showingTokenModal = false;
    }

    public function render()
    {
        return view('livewire.user.generate-api-tokens');
    }
}
