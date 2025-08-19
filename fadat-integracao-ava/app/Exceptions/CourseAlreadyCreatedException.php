<?php 

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CourseAlreadyCreatedException extends Exception
{
    public function __construct()
    {
        parent::__construct("• Curso já criado.");
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
            ->withErrors(['course_already_created' => $this->getMessage()])
            ->onlyInput();
    }

}