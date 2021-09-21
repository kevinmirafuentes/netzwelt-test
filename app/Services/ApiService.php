<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    const LOGIN_URL = 'https://netzwelt-devtest.azurewebsites.net/Account/SignIn';
    const TERRITORIES_URL = 'https://netzwelt-devtest.azurewebsites.net/Territories/All';

    public function authenticate($username, $password)
    {
        $response = Http::post(self::LOGIN_URL, compact('username', 'password'));

        if ($response->successful()) {
            session(['user' => $response->object()]);
        }

        return $response->successful();
    }

    public function getTerritories()
    {
        $response = Http::get(self::TERRITORIES_URL);

        if (!$response->successful()) {
            throw new Exception('Failed to get territories.');
        }

        $output = [];
        $data = $response->object()->data;

        foreach ($data as $item) {
            if ($item->parent == 0) {
                $output[$item->id] = $item;
                $output[$item->id]->children = $this->getChildren($data, $item);
            }
        }

        return $output;
    }

    private function getChildren($source, $subject)
    {
        $children = [];
        foreach ($source as $child) {
            if ($child->parent == $subject->id) {
                $children[$child->id] = $child;
                $children[$child->id]->children = $this->getChildren($source, $child);
            }
        }
        return $children;
    }
}
