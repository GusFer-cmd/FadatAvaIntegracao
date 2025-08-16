<?php 

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RoombookingConflictException extends Exception
{
    public function __construct()
    {
        parent::__construct("• Já existe um agendamento em conflito para este período.");
    }

    public function report():void
    {
        Log::error($this->getMessage());
    }

    public function render(Request $request): Response|RedirectResponse
    {
        if ($request->is('api/*')) {
            return response()->json([
                'message' => $this->getMessage()
            ], 422);
        }

        return back()
            ->withErrors(['roombooking' => $this->getMessage()])
            ->withInput();
    }


}